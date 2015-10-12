<?php

namespace App\Exception;

use Exception;

class StringException extends Exception
{
    public function __construct($message) {
        $message = sprintf(
            '(%s) %s is not an string',
            gettype($message),
            $message
        );
        error_log($message);
        parent::__construct($message);
    }
}