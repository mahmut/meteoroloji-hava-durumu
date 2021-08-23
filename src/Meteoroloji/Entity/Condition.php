<?php
/**
 * author : Mahmut Özdemir
 * web    : www.mahmutozdemir.com.tr
 * email  : bilgi@mahmutozdemir.com.tr
 * ----------------------------------------
 * Date   : 2021-08-19 21:04
 * File   : Condition.php
 */

namespace Meteoroloji\Entity;

class Condition implements \JsonSerializable
{
    /**
     * short code
     *
     * @var string
     */
    public $code;

    /**
     * long name
     *
     * @var string
     */
    public $name;

    /**
     * url of condition icon
     *
     * @var string
     */
    public $icon;

    /**
     * @var \string[][]
     */
    private static $conditions = [
        'A' => ['tr' => 'Açık', 'en' => 'Clear'],
        'AB' => ['tr' => 'Az Bulutlu', 'en' => 'Intermittent Clouds'],
        'DMN' => ['tr' => 'Duman', 'en' => 'Smokey'],
        'HY' => ['tr' => 'Hafif Yağmurlu', 'en' => 'Partly Rainy'],
        'HSY' => ['tr' => 'Hafif Sağanak Yağışlı', 'en' => 'Showers'],
        'HKY' => ['tr' => 'Hafif Kar Yağışlı', 'en' => 'Partly Snow Showers'],
        'MSY' => ['tr' => 'Yer Yer Sağanak Yağışlı', 'en' => 'Partly Showers'],
        'KKY' => ['tr' => 'Karla Karışık Yağmurlu', 'en' => 'Rain and Snow'],
        'GKR' => ['tr' => 'Güneyli Kuvvetli Rüzgar', 'en' => 'Strong Wind From South'],
        'SCK' => ['tr' => 'Sıcak', 'en' => 'Hot'],
        'PB' => ['tr' => 'Parçalı Bulutlu', 'en' => 'Partly Cloudy'],
        'PUS' => ['tr' => 'Pus', 'en' => 'Haze'],
        'Y' => ['tr' => 'Yağmurlu', 'en' => 'Rainy'],
        'SY' => ['tr' => 'Sağanak Yağışlı', 'en' => 'Heavy Rain'],
        'K' => ['tr' => 'Kar Yağışlı', 'en' => 'Snow'],
        'DY' => ['tr' => 'Dolu', 'en' => 'Hail'],
        'R' => ['tr' => 'Rüzgarlı', 'en' => 'Windy'],
        'KKR' => ['tr' => 'Kuzeyli Kuvvetli Rüzgar', 'en' => 'Strong Wind From North'],
        'SGK' => ['tr' => 'Soğuk', 'en' => 'Cold'],
        'CB' => ['tr' => 'Çok Bulutlu', 'en' => 'Mostly Cloudy'],
        'SIS' => ['tr' => 'Sis', 'en' => 'Fog'],
        'KY' => ['tr' => 'Kuvvetli Yağmurlu', 'en' => 'Strong Rainy'],
        'KSY' => ['tr' => 'Kuvvetli Sağanak Yağışlı', 'en' => 'Strong Showers'],
        'YKY' => ['tr' => 'Yoğun Kar Yağışlı', 'en' => 'Heavy Snow'],
        'GSY' => ['tr' => 'Gökgürültülü Sağanak Yağışlı', 'en' => 'Showers With T-Storms'],
        'KF' => ['tr' => 'Toz veya Kum Fırtınası', 'en' => 'Dust or Sand Storm'],
        'KGY' => ['tr' => 'Kuvvetli Gökgürültülü Sağanak Yağışlı', 'en' => 'Strong T-Storms with Showers']
    ];

    /**
     * Condition constructor.
     */
    public function __construct(){}

    /**
     * create condition from code
     *
     * @param $code
     * @param $language
     * @return Condition
     */
    public static function createFromCode($code, $language): Condition
    {
        $condition = new Condition();
        $condition->code = $code;
        $condition->name = isset(self::$conditions[$code][$language]) ? self::$conditions[$code][$language] : '';
        $condition->icon = 'https://mgm.gov.tr/Images_Sys/hadiseler/'.$code.'.svg';

        return $condition;
    }

    /**
     * json
     * 
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
