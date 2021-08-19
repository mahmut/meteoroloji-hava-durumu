<?php
/**
 * ----------------------------------------
 * author : [not]
 * web    : [not]
 * email  : [not]
 * ----------------------------------------
 * Date   : 2021-08-19 20:39
 * File   : Exception.php
 */

namespace Meteoroloji\Exception;

use Throwable;

class Exception extends \Exception
{
    /**
     * Exception constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}