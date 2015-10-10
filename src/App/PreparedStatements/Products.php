<?php

namespace App\PreparedStatements;

use App\Database\Database;
use App\PreparedStatements\ProductsException as PreparedStatementsException;
use PDO;
use PDOException;

class Products
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function fetchAll()
    {
        try {
            $sql = 'SELECT name, price, description FROM products';
            $statement = $this->db->prepare($sql);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PreparedStatementsException($e->getMessage());
        }
    }

    public function updateName($name, $id)
    {
        try {
            $sql = 'UPDATE products SET name = :name WHERE id = :id';
            $statement = $this->db->prepare($sql);

            $statement->bindParam(':name', $name, PDO::PARAM_STR, 50);
            $statement->bindParam(':id', $id, PDO::PARAM_INT, 9);
            return $statement->execute();
        } catch (PDOException $e) {
            throw new PreparedStatementsException($e->getMessage());
        }
    }

    public function fetch(array $where)
    {
        try {
            $sql = sprintf(
                'SELECT name, price, description FROM products WHERE `%s',
                implode('` = ? AND `', array_keys($where)) . '` = ?'
            );

            $statement = $this->db->prepare($sql);
            $statement->execute(array_values($where));

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PreparedStatementsException($e->getMessage());
        }
    }
}