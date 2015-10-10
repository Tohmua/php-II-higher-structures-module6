<?php

namespace App\Database;

use App\Database\DatabaseCreationException;
use App\Database\Database;

class DatabaseConnector
{
    private $db;
    private $dsn        = '';
    private $username   = '';
    private $password   = '';

    public function __construct(Database $db, array $config)
    {
        $this->setDb($db)
             ->setDsn($config)
             ->setUsername($config)
             ->setPassword($config);

        return $this->connect();
    }

    private function setDb(Database $db)
    {
        $this->db = $db;

        return $this;
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

    private function connect()
    {
        try {
            $this->db->connect($this->dsn, $this->username, $this->password);
            return $db;
        } catch (DatabaseCreationException $e) {
            throw new DatabaseCreationException(
                sprintf(
                    'Unable to connect to database with DSN: %s and Username: %s because: %s',
                    $this->dsn,
                    $this->username,
                    $e->getMessage()
                )
            );
        }
    }
}