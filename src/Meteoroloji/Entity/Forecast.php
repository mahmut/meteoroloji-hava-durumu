<?php
/**
 * author : Mahmut Özdemir
 * web    : www.mahmutozdemir.com.tr
 * email  : bilgi@mahmutozdemir.com.tr
 * ----------------------------------------
 * Date   : 2021-08-19 17:29
 * File   : Forecast.php
 */

namespace Meteoroloji\Entity;

class Forecast implements \JsonSerializable
{
    /**
     * Forecast date
     * @var string
     */
    public $date;

    /**
     * Forecast lowest temp
     * @var int
     */
    public $lowest;

    /**
     * Forecast highest temp
     * @var int
     */
    public $highest;

    /**
     * @var int
     */
    public $lowestHumidity;

    /**
     * @var int
     */
    public $highestHumidity;

    /**
     * forecast condition
     *
     * @var Condition
     */
    public $condition;

    /**
     * Wind speed
     *
     * @var int
     */
    public $windSpeed;

    /**
     * Wind direction
     * @var int
     */
    public $windDirection;

    /**
     * Forecast constructor.
     */
    public function __construct() {}

    /**
     * create forecasts from objects
     *
     * @param $obj
     * @param $language
     * @return array
     */
    public static function createFromJson($obj, $language): array
    {
        $forecasts = [];

        for($i = 1; $i <= 5; $i++){
            $forecast = new self();

            $forecast->date = date('d.m.Y', strtotime($obj->{'tarihGun' . $i}));
            $forecast->lowest = $obj->{'enDusukGun'.$i};
            $forecast->highest = $obj->{'enYuksekGun'.$i};
            $forecast->lowestHumidity = $obj->{'enDusukNemGun'.$i};
            $forecast->highestHumidity = $obj->{'enYuksekNemGun'.$i};
            $forecast->windDirection = $obj->{'tarihGun'.$i};
            $forecast->windSpeed = $obj->{'tarihGun'.$i};
            $forecast->condition = Condition::createFromCode($obj->{'hadiseGun'.$i}, $language);
            $forecast->windSpeed = $obj->{'ruzgarHizGun'.$i};
            $forecast->windDirection = $obj->{'ruzgarYonGun'.$i};

            $forecasts[] = $forecast;
        }

        return $forecasts;
    }

    /**
     * json
     *
     * @return array|mixed
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
