<?php
/**
 * author : Mahmut Özdemir
 * web    : www.mahmutozdemir.com.tr
 * email  : bilgi@mahmutozdemir.com.tr
 * ----------------------------------------
 * Date   : 2021-08-19 17:37
 * File   : Current.php
 */

namespace Meteoroloji\Entity;

class Current implements \JsonSerializable
{
    /**
     * @var string
     */
    public $date;

    /**
     * station number
     *
     * @var int
     */
    public $stationNumber;

    /**
     * current condition
     *
     * @var Condition
     */
    public $condition;

    /**
     * current temperature
     *
     * @var double
     */
    public $temp;

    /**
     * current humidity
     *
     * @var double
     */
    public $humidity;

    /**
     * current wind direction
     *
     * @var int
     */
    public $windDirection;

    /**
     * current wind speed
     *
     * @var double
     */
    public $windSpeed;

    /**
     * current pressure
     *
     * @var double
     */
    public $pressure;

    /**
     * current sea level pressure
     *
     * @var double
     */
    public $seaLevelPressure;

    /**
     * sight distance
     *
     * @var int
     */
    public $sight;

    /**
     * Current constructor.
     */
    public function __construct(){}

    /**
     * create from json
     *
     * @param $obj
     * @param $language
     * @return static
     */
    public static function createFromJson($obj, $language): self
    {
        $current = new self();

        $current->pressure = $obj->aktuelBasinc;
        $current->seaLevelPressure = $obj->denizeIndirgenmisBasinc;
        $current->sight = $obj->gorus;
        $current->condition = Condition::createFromCode($obj->hadiseKodu, $language);
        $current->stationNumber = $obj->istNo;
        $current->humidity = $obj->nem;
        $current->windSpeed = $obj->ruzgarHiz;
        $current->windDirection = $obj->ruzgarYon;
        $current->temp = $obj->sicaklik;
        $current->date = date('d.m.Y H:i', strtotime($obj->veriZamani));

        return $current;
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
