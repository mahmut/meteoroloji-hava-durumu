# Meteoroloji Genel Müdürlüğü Hava Durumu Apisi

İl, ilçe adına göre meteoroloji genel müdürlüğünden istasyon bilgileri, gün doğumu, gün batımı, günlük hava durumu ve 5 günlük hava tahminleri listesini kolayca alabilirsiniz. 

## Kurulum
```sh
composer require mahmut/meteoroloji-hava-durumu
```

## Örnek
```php
// şehir adı
$city = 'ankara';
// ilçe adı
$town = 'cankaya'; // boş bırakılabilir

// hava durumunu getir
try {
    $weather = new \Meteoroloji\Weather($city, $town);
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
```

## Çıktı
```php
Meteoroloji\Entity\Result Object
(
    [station] => Meteoroloji\Entity\Station Object
        (
            [city] => Ankara
            [town] => Çankaya
            [centerId] => 90614
            [latitude] => 39.9075
            [longitude] => 32.8494
            [altitude] => 927
            [sunrise] => 06:08
            [sunset] => 19:33
        )

    [current] => Meteoroloji\Entity\Current Object
        (
            [date] => 23.08.2021 21:46
            [stationNumber] => 18046
            [condition] => Meteoroloji\Entity\Condition Object
                (
                    [code] => A
                    [name] => Açık
                    [icon] => https://mgm.gov.tr/Images_Sys/hadiseler/A.svg
                )

            [temp] => 20.1
            [humidity] => 58
            [windDirection] => 7
            [windSpeed] => 2.16
            [pressure] => 908.8
            [seaLevelPressure] => 1008.1
            [sight] => 33020
        )

    [forecasts] => Array
        (
            [0] => Meteoroloji\Entity\Forecast Object
                (
                    [date] => 24.08.2021
                    [lowest] => 15
                    [highest] => 31
                    [lowestHumidity] => 17
                    [highestHumidity] => 82
                    [condition] => Meteoroloji\Entity\Condition Object
                        (
                            [code] => AB
                            [name] => Az Bulutlu
                            [icon] => https://mgm.gov.tr/Images_Sys/hadiseler/AB.svg
                        )

                    [windSpeed] => 12
                    [windDirection] => 70
                )

            [1] => Meteoroloji\Entity\Forecast Object
                (
                    [date] => 25.08.2021
                    [lowest] => 16
                    [highest] => 34
                    [lowestHumidity] => 15
                    [highestHumidity] => 73
                    [condition] => Meteoroloji\Entity\Condition Object
                        (
                            [code] => PB
                            [name] => Parçalı Bulutlu
                            [icon] => https://mgm.gov.tr/Images_Sys/hadiseler/PB.svg
                        )

                    [windSpeed] => 10
                    [windDirection] => 308
                )

            [2] => Meteoroloji\Entity\Forecast Object
                (
                    [date] => 26.08.2021
                    [lowest] => 19
                    [highest] => 34
                    [lowestHumidity] => 18
                    [highestHumidity] => 44
                    [condition] => Meteoroloji\Entity\Condition Object
                        (
                            [code] => AB
                            [name] => Az Bulutlu
                            [icon] => https://mgm.gov.tr/Images_Sys/hadiseler/AB.svg
                        )

                    [windSpeed] => 14
                    [windDirection] => 249
                )

            [3] => Meteoroloji\Entity\Forecast Object
                (
                    [date] => 27.08.2021
                    [lowest] => 20
                    [highest] => 34
                    [lowestHumidity] => 15
                    [highestHumidity] => 63
                    [condition] => Meteoroloji\Entity\Condition Object
                        (
                            [code] => AB
                            [name] => Az Bulutlu
                            [icon] => https://mgm.gov.tr/Images_Sys/hadiseler/AB.svg
                        )

                    [windSpeed] => 11
                    [windDirection] => 293
                )

            [4] => Meteoroloji\Entity\Forecast Object
                (
                    [date] => 28.08.2021
                    [lowest] => 18
                    [highest] => 35
                    [lowestHumidity] => 16
                    [highestHumidity] => 64
                    [condition] => Meteoroloji\Entity\Condition Object
                        (
                            [code] => SCK
                            [name] => Sıcak
                            [icon] => https://mgm.gov.tr/Images_Sys/hadiseler/SCK.svg
                        )

                    [windSpeed] => 10
                    [windDirection] => 70
                )

        )

)
```