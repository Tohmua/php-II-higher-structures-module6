<?php

namespace App\ActiveRecord;

use App\ActiveRecord\ModelException;
use App\Database\Database;
use PDO;

abstract class Model
{
    private $db;
    private $exists = false;
    protected $fields = [];
    protected $originalValues = [];
    protected $values = [];
    protected $table = '';

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function __get($field)
    {
        if (!$this->isField($field)) {
            throw new ModelException('Cant get a field that does not exist.');
        }

        return $this->values[$field];
    }

    public function __set($field, $value)
    {
        if (!$this->isField($field)) {
            throw new ModelException('Cant set a field that does not exist.');
        }

        $this->values[$field] = $value;

        return $this;
    }

    public function save()
    {
        if ($this->exists) {
            return $this->runUpdateQuery();
        }

        return $this->runInsertQuery();
    }

    public function load(array $where)
    {
        if (!$this->checkFields(array_keys($where))) {
            throw new ModelException('Trying to load a model with values that don\'t exist.');
        }

        $this->loadInValues(
            $this->runSelectQuery($where)
        );

        $this->exists = true;
    }

    private function loadInValues(array $fieldsAndValues)
    {
        array_walk($fieldsAndValues, function($value, $field){
            $this->$field = $value;
            $this->originalValues[$field] = $value;
        });
    }

    private function isField($field)
    {
        return in_array($field, $this->fields);
    }

    private function checkFields(array $fields)
    {
        foreach ($fields as $field) {
            if (!$this->isField($field)) {
                return false;
            }
        }

        return true;
    }

    private function selectQuery(array $where)
    {
        if (empty($where)) {
            throw new ModelException('selectQuery() expects an array with values');
        }

        return sprintf(
            'SELECT `%s` FROM `%s` WHERE `%s` = ?',
            implode('`, `', $this->fields),
            $this->table,
            implode('` = ? AND `', array_keys($where))
        );
    }

    private function insertQuery()
    {
        return sprintf(
            'INSERT INTO `%s`(`%s`) VALUES (%s)',
            $this->table,
            implode('`, `', array_keys($this->values)),
            implode(', ', array_fill(0, count($this->values), '?'))
        );
    }

    private function updateQuery()
    {
        return sprintf(
            'UPDATE `%s` SET %s WHERE %s',
            $this->table,
            implode(', ', $this->updateSubQuery($this->values)),
            implode(' AND ', $this->updateSubQuery($this->originalValues))
        );
    }

    private function updateSubQuery(array $fields)
    {
        return array_map(function($field) {
            return sprintf('`%s` = ?', $field);
        }, array_keys($fields));
    }

    private function runSelectQuery(array $where)
    {
        $statement = $this->db->prepare($this->selectQuery($where));
        $statement->execute(array_values($where));

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    private function runInsertQuery()
    {
        $statement = $this->db->prepare($this->insertQuery());
        return $statement->execute(array_values($this->values));
    }

    private function runUpdateQuery()
    {
        $statement = $this->db->prepare($this->updateQuery());

        return $statement->execute(
            array_merge(array_values($this->values), array_values($this->originalValues))
        );
    }
}