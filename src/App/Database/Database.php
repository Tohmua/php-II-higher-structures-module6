<?php

namespace App\Database;

interface Database
{
    public function connect($dsn, $username, $password);
}