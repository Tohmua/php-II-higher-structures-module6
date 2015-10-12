<?php

namespace App\Exception;

use Exception;

class IntegerException extends Exception
{
    public function __construct($message) {
        $message = sprintf(
            '(%s) %s is not an integer',
            gettype($message),
            $message
        );
        error_log($message);
        parent::__construct($message);
    }
}