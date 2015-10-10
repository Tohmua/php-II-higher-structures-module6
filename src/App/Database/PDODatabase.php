<?php

namespace App\Database;

use App\Database\DatabaseCreationException;
use App\Database\Database;
use PDO;
use PDOException;

class PDODatabase extends PDO implements Database
{
    public function __construct() {}

    public function connect($dsn, $username, $password)
    {
        try {
            $db = parent::__construct($dsn, $username, $password);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return true;
        } catch (PDOException $e) {
            throw new DatabaseCreationException(
                sprintf(
                    'Unable to connect to database with DSN: %s and Username: %s because: %s',
                    $dsn,
                    $username,
                    $e->getMessage()
                )
            );
        }
    }
}
