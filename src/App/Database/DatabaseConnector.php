<?php

namespace App\Database;

use App\Database\DatabaseCreationException;
use App\Database\Database;

class DatabaseConnector
{
    private $db;

    public function __construct(Database $db, array $config)
    {
        $this->setDb($db);

        return $this->connect($config);
    }

    private function setDb(Database $db)
    {
        $this->db = $db;

        return $this;
    }

    private function connect(array $config)
    {
        try {
            $this->db->connect($config);
            return $this->db;
        } catch (DatabaseCreationException $e) {
            throw new DatabaseCreationException($e->getMessage());
        }
    }
}