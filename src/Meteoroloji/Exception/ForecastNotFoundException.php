<?php
/**
 * author : Mahmut Özdemir
 * web    : www.mahmutozdemir.com.tr
 * email  : bilgi@mahmutozdemir.com.tr
 * ----------------------------------------
 * Date   : 2021-08-19 20:55
 * File   : ForecastNotFoundException.php
 */

namespace Meteoroloji\Exception;

use Throwable;

class ForecastNotFoundException extends Exception
{
    /**
     * ForecastNotFoundException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "Tahminler bilgisi alınamadı", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
