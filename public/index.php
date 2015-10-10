<?php

namespace DbExample;

use App\Database\DatabaseConnector;
use App\Database\DatabaseCreationException;
use App\Database\PDODatabase;

require_once __DIR__ . '/bootstrap.php';

try {
    $dbConfig = $serviceLocator->get('config')['database'];

    $serviceLocator->set(
        'database',
        new DatabaseConnector(
            new PDODatabase(),
            $dbConfig
        )
    );
} catch (DatabaseCreationException $e) {
    echo $e->getMessage();
    exit();
}

var_dump($dbConfig);
