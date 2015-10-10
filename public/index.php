<?php

namespace DbExample;

use App\PreparedStatements\Products as PreparedStatement;
use App\PreparedStatements\ProductsException as PreparedStatementsException;

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