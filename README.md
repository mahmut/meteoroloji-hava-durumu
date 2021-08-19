# Meteoroloji Genel Müdürlüğü Hava Durumu Api

İl, ilçe adına göre meteoroloji genel müdürlüğünden istasyon bilgileri, gün doğumu, gün batımı, günlük hava durumu ve 5 günlük hava tahminleri listesini kolayca alabilirsiniz. 

## Kurulum
```sh
composer require mahmut/meteoroloji-hava-durumu
```

## Örnek
```php
// şehir adı
$city = 'ankara';

// hava durumunu getir
try {
    $weather = new \Meteoroloji\Weather('ankara');
    $result = $weather
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
```

## Çıktı
```php
Meteoroloji\Entity\Result Object
(
    [station] => Meteoroloji\Entity\Station Object
        (
            [city] => Ankara
            [town] => Keçiören
            [centerId] => 90601
            [latitude] => 39.9727
            [longitude] => 32.8637
            [altitude] => 891
            [sunrise] => 06:04
            [sunset] => 19:39
        )

    [current] => Meteoroloji\Entity\Current Object
        (
            [date] => 19.08.2021 19:58
            [stationNumber] => 17130
            [condition] => Meteoroloji\Entity\Condition Object
                (
                    [code] => A
                    [name] => Açık
                    [icon] => https://mgm.gov.tr/Images_Sys/hadiseler/A.svg
                )

            [temp] => 22.3
            [humidity] => 42
            [windDirection] => 25
            [windSpeed] => 4.68
            [pressure] => 910.7
            [seaLevelPressure] => 1005.7
            [sight] => 20000
        )

    [forecasts] => Array
        (
            [0] => Meteoroloji\Entity\Forecast Object
                (
                    [date] => 20.08.2021
                    [lowest] => 16
                    [highest] => 31
                    [lowestHumidity] => 24
                    [highestHumidity] => 86
                    [condition] => Meteoroloji\Entity\Condition Object
                        (
                            [code] => AB
                            [name] => Az Bulutlu
                            [icon] => https://mgm.gov.tr/Images_Sys/hadiseler/AB.svg
                        )

                    [windSpeed] => 13
                    [windDirection] => 30
                )

            [1] => Meteoroloji\Entity\Forecast Object
                (
                    [date] => 21.08.2021
                    [lowest] => 17
                    [highest] => 32
                    [lowestHumidity] => 18
                    [highestHumidity] => 84
                    [condition] => Meteoroloji\Entity\Condition Object
                        (
                            [code] => AB
                            [name] => Az Bulutlu
                            [icon] => https://mgm.gov.tr/Images_Sys/hadiseler/AB.svg
                        )

                    [windSpeed] => 11
                    [windDirection] => 34
                )

            [2] => Meteoroloji\Entity\Forecast Object
                (
                    [date] => 22.08.2021
                    [lowest] => 18
                    [highest] => 32
                    [lowestHumidity] => 19
                    [highestHumidity] => 77
                    [condition] => Meteoroloji\Entity\Condition Object
                        (
                            [code] => PB
                            [name] => Parçalı Bulutlu
                            [icon] => https://mgm.gov.tr/Images_Sys/hadiseler/PB.svg
                        )

                    [windSpeed] => 17
                    [windDirection] => 4
                )

            [3] => Meteoroloji\Entity\Forecast Object
                (
                    [date] => 23.08.2021
                    [lowest] => 19
                    [highest] => 30
                    [lowestHumidity] => 24
                    [highestHumidity] => 73
                    [condition] => Meteoroloji\Entity\Condition Object
                        (
                            [code] => PB
                            [name] => Parçalı Bulutlu
                            [icon] => https://mgm.gov.tr/Images_Sys/hadiseler/PB.svg
                        )

                    [windSpeed] => 17
                    [windDirection] => 57
                )

            [4] => Meteoroloji\Entity\Forecast Object
                (
                    [date] => 24.08.2021
                    [lowest] => 18
                    [highest] => 31
                    [lowestHumidity] => 19
                    [highestHumidity] => 82
                    [condition] => Meteoroloji\Entity\Condition Object
                        (
                            [code] => AB
                            [name] => Az Bulutlu
                            [icon] => https://mgm.gov.tr/Images_Sys/hadiseler/AB.svg
                        )

                    [windSpeed] => 18
                    [windDirection] => 66
                )

        )

)
```