<?php

namespace App\Exception;

use App\Exception\IntegerException;
use App\Exception\StringException;

class Product
{
    private $id = 0;
    private $name = '';

    public function __construct($id, $name)
    {
        if (!is_int($id)) {
            throw new IntegerException($id);
        }

        if (!is_string($name)) {
            throw new StringException($name);
        }

        $this->id = $id;
        $this->name = $name;
    }
}