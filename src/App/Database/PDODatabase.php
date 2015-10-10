<?php

namespace App\Database;

use App\Database\Database;
use App\Database\DatabaseConnectionException;
use App\Database\DatabaseCreationException;
use PDO;
use PDOException;

class PDODatabase extends PDO implements Database
{
    private $dsn        = '';
    private $username   = '';
    private $password   = '';

    public function __construct() {}

    public function connect(array $config)
    {
        $this->setDsn($config)
             ->setUsername($config)
             ->setPassword($config);

        try {
            $db = parent::__construct($this->dsn, $this->username, $this->password);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return true;
        } catch (PDOException $e) {
            throw new DatabaseConnectionException(
                sprintf(
                    'Unable to connect to database because: %s',
                    $e->getMessage()
                )
            );
        }
    }

    private function setDsn(array $config)
    {
        if (!isset($config['dsn'])) {
            throw new DatabaseCreationException('No DSN provided in the config array');
        }

        $this->dsn = $config['dsn'];

        return $this;
    }

    private function setUsername(array $config)
    {
        if (!isset($config['username'])) {
            throw new DatabaseCreationException('No Username provided in the config array');
        }

        $this->username = $config['username'];

        return $this;
    }

    private function setPassword(array $config)
    {
        if (!isset($config['password'])) {
            throw new DatabaseCreationException('No Password provided in the config array');
        }

        $this->password = $config['password'];

        return $this;
    }
}
