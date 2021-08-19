<?php
/**
 * author : Mahmut Özdemir
 * web    : www.mahmutozdemir.com.tr
 * email  : bilgi@mahmutozdemir.com.tr
 * ----------------------------------------
 * Date   : 2021-08-19 17:38
 * File   : Station.php
 */

namespace Meteoroloji\Entity;

class Station implements \JsonSerializable
{
    /**
     * station city
     *
     * @var string
     */
    public $city;

    /**
     * station town
     *
     * @var string
     */
    public $town;

    /**
     * center id
     * @var int
     */
    public $centerId;

    /**
     * latitude of station location
     *
     * @var double
     */
    public $latitude;

    /**
     * longitude of station location
     *
     * @var double
     */
    public $longitude;

    /**
     * altitude of station location
     *
     * @var double
     */
    public $altitude;

    /**
     * sunrise of station location
     *
     * @var string
     */
    public $sunrise;

    /**
     * sunrise of station location
     *
     * @var string
     */
    public $sunset;

    /**
     * Station constructor.
     */
    public function __construct(){ }

    /**
     * create new station from json
     *
     * @param $obj
     * @return Station
     */
    public static function createFromJson($obj): Station
    {
        $station = new self();
        $station->city = $obj->il;
        $station->town = $obj->ilce;
        $station->centerId = $obj->merkezId;
        $station->latitude = $obj->enlem;
        $station->longitude = $obj->boylam;
        $station->altitude = $obj->yukseklik;

        $station->sunrise = date_sunrise(time(), SUNFUNCS_RET_STRING, $obj->enlem, $obj->boylam, 90.50, 3);
        $station->sunset = date_sunset(time(), SUNFUNCS_RET_STRING, $obj->enlem, $obj->boylam, 90.50, 3);

        return $station;
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
