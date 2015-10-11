<?php

namespace DbExample;

use App\PreparedStatements\Products as PreparedStatement;
use App\PreparedStatements\ProductsException as PreparedStatementsException;

use App\ActiveRecord\Products as ActiveRecord;
use App\ActiveRecord\ProductsException as ActiveRecordException;

require_once 'bootstrap.php';

/**
 * Prepared Statements
 */
try {
    $preparedStatement = new PreparedStatement($serviceLocator->get('database'));

    /**
     * Prepared Statements
     * Fetch All using PDO::FETCH_ASSOC
     */
    foreach ($preparedStatement->fetchAll() as $book) {
        echo '<pre>', var_dump($book), '</pre>';
    }

    /**
     * Prepared Statements
     * Update Row using PDO::bindParam()
     */
    $preparedStatement->updateName('Cleaner Code', 1);

    /**
     * Prepared Statements
     * Fetch Row(s) using dynamic query
     */
    foreach ($preparedStatement->fetch(['id' => 3, 'name' => 'Domain-driven Design']) as $book) {
        echo '<pre>', var_dump($book), '</pre>';
    }
} catch (PreparedStatementsException $e) {
    echo $e->getMessage();
}

/**
 * Active Record
 */
try {
    /**
     * Active Record
     * New Active Record
     */
    $activeRecord = new ActiveRecord($serviceLocator->get('database'));
    $activeRecord->name = 'Advanced PHP Programming';
    $activeRecord->price = 1099;
    $activeRecord->description = 'A Practical Guide to Developing Large-scale Web Sites and Applications with PHP 5';
    $activeRecord->save();

    /**
     * Active Record
     * Load Record
     */
    $activeRecord = new ActiveRecord($serviceLocator->get('database'));
    $activeRecord->load(['name' => 'Advanced PHP Programming', 'price' => 1099]);
    echo $activeRecord->price() . PHP_EOL;

    /**
     * Active Record
     * Update Record
     */
    $activeRecord = new ActiveRecord($serviceLocator->get('database'));
    $activeRecord->load(['name' => 'Advanced PHP Programming', 'price' => 1099]);
    $activeRecord->price = 1199;
    $activeRecord->save();
    echo $activeRecord->price() . PHP_EOL;
} catch (ActiveRecordException $e) {
    echo $e->getMessage();
}