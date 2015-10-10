<?php

namespace App\Database;

use App\Database\DatabaseCreationException;
use App\Database\Database;

class DatabaseConnector
{
    private $db;
    private $config = [];

    public function __construct(Database $db, array $config)
    {
        $this->setDb($db);

        $this->config = $config;
    }

    private function setDb(Database $db)
    {
        $this->db = $db;

        return $this;
    }

    public function connect()
    {
        try {
            $this->db->connect($this->config);
            return $this->db;
        } catch (DatabaseCreationException $e) {
            throw new DatabaseCreationException($e->getMessage());
        }
    }
}