<?php
/**
 * author : Mahmut Özdemir
 * web    : www.mahmutozdemir.com.tr
 * email  : bilgi@mahmutozdemir.com.tr
 * ----------------------------------------
 * Date   : 2021-08-19 17:44
 * File   : example.php
 */

include_once "vendor/autoload.php";

spl_autoload_register(function($class) {
    include 'src/' . str_replace('\\', '/', $class) . '.php';
});

try {

    $station = new \Meteoroloji\Entity\Station();
    $station->city = 'ankara';
    $station->town = 'yenimahalle';
    $station->latitude = 39.903;
    $station->longitude = 32.809;

    $weather = new \Meteoroloji\Weather($station, \Meteoroloji\Entity\StationType::City);
    $result = $weather
        ->setLanguage('tr') // ingilizce için 'en' kullanabilirsiniz.
        ->setCachePath(__DIR__ . '/cache/')
        ->cache(true)
        ->fetch();

    print_r($result);

} catch (\Meteoroloji\Exception\CurrentNotFoundException $e) {
    die($e->getMessage());
} catch (\Meteoroloji\Exception\ForecastNotFoundException $e) {
    die($e->getMessage());
} catch (\Meteoroloji\Exception\StationNotFoundException $e) {
    die($e->getMessage());
} catch (\Meteoroloji\Exception\Exception $e) {
    die($e->getMessage());
}

