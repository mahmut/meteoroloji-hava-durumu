<?php
/**
 * ----------------------------------------
 * author : [not]
 * web    : [not]
 * email  : [not]
 * ----------------------------------------
 * Date   : 2021-08-19 22:51
 * File   : Result.php
 */

namespace Meteoroloji\Entity;

class Result implements \JsonSerializable
{
    /**
     * @var Station
     */
    public $station;

    /**
     * @var Current
     */
    public $current;

    /**
     * forecasts
     *
     * @var Forecast[]
     */
    public $forecasts = [];

    /**
     * Result constructor.
     */
    public function __construct(){}

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