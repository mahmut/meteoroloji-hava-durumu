<?php
/**
 * author : Mahmut Özdemir
 * web    : www.mahmutozdemir.com.tr
 * email  : bilgi@mahmutozdemir.com.tr
 * ----------------------------------------
 * Date   : 2021-08-19 17:51
 * File   : StationNotFoundException.php
 */

namespace Meteoroloji\Exception;

use Throwable;

class StationNotFoundException extends Exception
{
    /**
     * StationNotFoundException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "İstasyon bulunamadı", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
