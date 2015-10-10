<?php

namespace App\Database;

interface Database
{
    public function connect(array $config);
}