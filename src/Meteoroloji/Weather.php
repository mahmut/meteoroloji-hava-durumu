<?php
/**
 * author : Mahmut Özdemir
 * web    : www.mahmutozdemir.com.tr
 * email  : bilgi@mahmutozdemir.com.tr
 * ----------------------------------------
 * Date   : 2021-08-19 17:18
 * File   : Weather.php
 */

namespace Meteoroloji;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use JsonMapper;
use Meteoroloji\Entity\Current;
use Meteoroloji\Entity\Forecast;
use Meteoroloji\Entity\Result;
use Meteoroloji\Entity\Station;
use Meteoroloji\Entity\StationType;
use Meteoroloji\Exception\CurrentNotFoundException;
use Meteoroloji\Exception\Exception;
use Meteoroloji\Exception\ForecastNotFoundException;
use Meteoroloji\Exception\StationNotFoundException;

class Weather {

    /**
     * @var string
     */
    protected $url = 'https://servis.mgm.gov.tr/web/';

    /**
     * @var Client
     */
    protected $client;

    /**
     * language of conditions
     *
     * @var string
     */
    protected $language = 'tr';

    /**
     * status of cache
     *
     * @var bool
     */
    protected $cache = false;

    /**
     * path of cache
     *
     * @var string
     */
    protected $cachePath = null;

    /**
     * cache file lifetime in minutes
     *
     * @var int
     */
    protected $cacheLifetime = 30;

    /**
     * @var string
     */
    protected $stationType;

    /**
     * @var Station
     */
    protected $station;

    /**
     * @var Current
     */
    protected $current;

    /**
     * @var array
     */
    protected $forecasts = [];

    /**
     * Weather construct
     *
     * @param Station $station
     * @param string $stationType
     */
    public function __construct(Station $station, string $stationType = StationType::City)
    {
        $this->station = $station;
        $this->stationType = $stationType;

        // init client
        $this->client = new Client([
            'base_uri' => $this->url,
            'headers' => [
                'Host' => 'servis.mgm.gov.tr',
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36',
                'Origin' => 'https://www.mgm.gov.tr'
            ]
        ]);
    }

    /**
     * clean turkish characters
     *
     * @param $str
     * @return string|string[]
     */
    protected function clean($str)
    {
        $replaces = ['ı' => 'i', 'ü' => 'u', 'ğ' => 'g', 'ö' => 'o', 'ş' => 's', 'ç' => 'c'];
        return str_replace(array_keys($replaces), array_values($replaces), $str);
    }

    /**
     * fetch station
     *
     * @return $this
     * @throws StationNotFoundException
     */
    private function fetchStation(): Weather
    {
        if($this->stationType == StationType::Location){
            return $this->fetchStationByLocation();
        } else {
            return $this->fetchStationByCity();
        }
    }

    /**
     * fetch station by city
     *
     * @return $this
     * @throws StationNotFoundException
     */
    private function fetchStationByCity(): Weather
    {
        try {
            $query = ['il' => $this->clean($this->station->city)];
            if($this->station->town){
                $query['ilce'] = $this->clean($this->station->town);
            }

            $response = $this->client->get('merkezler', [
                'query' => $query
            ]);

            $response = json_decode($response->getBody()->getContents());
            if(!$response) {
                throw new StationNotFoundException();
            }

            $this->station = Station::createFromJson($response[0]);

        } catch (ClientException $e) {
            throw new StationNotFoundException($e->getMessage());
        }

        return $this;
    }

    /**
     * fetch station by location
     *
     * @return $this
     * @throws StationNotFoundException
     */
    private function fetchStationByLocation(): Weather
    {
        try {
            $response = $this->client->get('merkezler/lokasyon', [
                'query' => [
                    'enlem' => $this->station->latitude,
                    'boylam' => $this->station->longitude
                ]
            ]);

            $response = json_decode($response->getBody()->getContents());
            if(!$response) {
                throw new StationNotFoundException();
            }

            $this->station = Station::createFromJson($response);

        } catch (ClientException $e) {
            throw new StationNotFoundException($e->getMessage());
        }

        return $this;
    }

    /**
     * fetch current
     *
     * @return Current
     * @throws CurrentNotFoundException
     * @throws StationNotFoundException
     */
    private function fetchCurrent(): Current
    {
        if(!$this->station){
            throw new StationNotFoundException();
        }

        try {
            $response = $this->client->get('sondurumlar', [
                'query' => ['merkezid' => $this->station->centerId]
            ]);

            $response = json_decode($response->getBody()->getContents());
            if(!$response) {
                throw new CurrentNotFoundException();
            }

            $this->current = Current::createFromJson($response[0], $this->language);

        } catch (ClientException $e) {
            throw new CurrentNotFoundException($e->getMessage());
        }

        return $this->current;
    }

    /**
     * fetch foreacasts
     *
     * @return array
     * @throws ForecastNotFoundException
     * @throws StationNotFoundException
     */
    private function fetchForecasts(): array
    {
        if(!$this->station){
            throw new StationNotFoundException();
        }

        try {
            $response = $this->client->get('tahminler/gunluk', [
                'query' => ['istno' => $this->station->centerId]
            ]);

            $response = json_decode($response->getBody()->getContents());
            if(!$response) {
                throw new ForecastNotFoundException();
            }

            $this->forecasts = Forecast::createFromJson($response[0], $this->language);

        } catch (ClientException $e) {
            throw new ForecastNotFoundException($e->getMessage());
        }

        return $this->forecasts;
    }

    /**
     * fetch
     *
     * @return Result
     * @throws CurrentNotFoundException
     * @throws Exception
     * @throws ForecastNotFoundException
     * @throws StationNotFoundException
     */
    public function fetch(): Result
    {
        if($this->stationType == StationType::Location){
            $cacheKey = 'weather-'.$this->clean($this->station->latitude).'-'.$this->clean($this->station->longitude).'-'.$this->language;
        } else {
            $cacheKey = 'weather-'.$this->clean($this->station->city).'-'.$this->clean($this->station->town).'-'.$this->language;
        }

        if($this->cache && $result = $this->readCache($cacheKey)){
            return $result;
        }

        $this->fetchStation();
        $this->fetchCurrent();
        $this->fetchForecasts();

        $result = new Result();
        $result->station = $this->station;
        $result->current = $this->current;
        $result->forecasts = $this->forecasts;


        if($this->cache){
            $this->writeCache($cacheKey, $result);
        }

        return $result;
    }

    /**
     * read cache
     *
     * @param $key
     * @return mixed|object|null
     * @throws Exception
     */
    protected function readCache($key)
    {
        $cacheFile = $this->cachePath.$key.'.json';
        if(!file_exists($cacheFile)){
            return null;
        }

        if(filemtime($cacheFile) < time() - ($this->cacheLifetime * 60)){
            return null;
        }

        $result = json_decode(file_get_contents($cacheFile));
        $mapper = new JsonMapper();
        try {
            return $mapper->map($result, new Result());
        } catch (\JsonMapper_Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * write cache
     *
     * @param $key
     * @param $content
     */
    protected function writeCache($key, $content)
    {
        $cacheFile = $this->cachePath.$key.'.json';
        file_put_contents($cacheFile, json_encode($content));
    }

    /**
     * cache status
     *
     * @param bool $cache
     * @return $this
     * @throws Exception
     */
    public function cache(bool $cache): Weather
    {
        $this->cache = $cache;

        if($cache) {
            if (!is_dir($this->cachePath)) {
                throw new Exception('Cache dizini geçerli değil: '.$this->cachePath);
            } elseif (!is_writable($this->cachePath)) {
                throw new Exception('Cache dizini yazılabilir değil: '.$this->cachePath);
            }
        }

        return $this;
    }

    /**
     * @param string $cachePath
     * @return Weather
     */
    public function setCachePath(string $cachePath): Weather
    {
        $this->cachePath = $cachePath;
        return $this;
    }

    /**
     * @param int $cacheLifetime
     * @return Weather
     */
    public function setCacheLifetime(int $cacheLifetime): Weather
    {
        $this->cacheLifetime = $cacheLifetime;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return Weather
     */
    public function setLanguage(string $language): Weather
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return Weather
     */
    public function setCity(string $city): Weather
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return String
     */
    public function getTown(): string
    {
        return $this->town;
    }

    /**
     * @param String $town
     * @return Weather
     */
    public function setTown(string $town): Weather
    {
        $this->town = $town;
        return $this;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     * @return Weather
     */
    public function setLatitude(float $latitude): Weather
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     * @return Weather
     */
    public function setLongitude(float $longitude): Weather
    {
        $this->longitude = $longitude;
        return $this;
    }
}
