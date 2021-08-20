<?php
/**
 * author : Mahmut Özdemir
 * web    : www.mahmutozdemir.com.tr
 * email  : bilgi@mahmutozdemir.com.tr
 * ----------------------------------------
 * Date   : 2021-08-19 20:51
 * File   : CurrentNotFoundException.php
 */

namespace Meteoroloji\Exception;

use Throwable;

class CurrentNotFoundException extends Exception
{
    /**
     * CurrentNotFoundException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "Sondurumlar bilgisi alınamadı", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
