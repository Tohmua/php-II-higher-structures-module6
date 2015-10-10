<?php

use App\DependencyInjection\ServiceLocator;
use App\Database\DatabaseConnector;
use App\Database\DatabaseCreationException;
use App\Database\PDODatabase;

// Change the directory to the root of the application not the public folder.
// Should make requiring easier
chdir(dirname(__DIR__));

require_once 'vendor/autoload.php';

$serviceLocator = new ServiceLocator();

if (file_exists('src/App/Config/application.config.php')) {
    $serviceLocator->set('config', require 'src/App/Config/application.config.php');
} else {
    echo 'Missing App/Config/application.config.php file';
}

try {
    $dbConfig = $serviceLocator->get('config')['database'];

    $serviceLocator->set(
        'database',
        (new DatabaseConnector(
            new PDODatabase(),
            $dbConfig
        ))->connect()
    );
} catch (DatabaseCreationException $e) {
    echo $e->getMessage();
    exit();
}
