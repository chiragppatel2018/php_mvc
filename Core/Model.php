<?php

namespace App\Core;

class Model extends Database {

    const RULE_REQUIRED = 'required';
    const RULE_FILE_EXT =  'file_ext';

    public $errors = [];
    public $allowFiles = [];

    static $fields = [];
    static $table_name;
    public $primary_key;
    private $where_condition;
    private $where_field_data = [];
    private $set_limit;
    private $set_order;


    public function validateRule() {
        return [];
    }

    public function loadData($data) {
        foreach ($data as $key => $value) {
            $this->{$key} = "";
            if(in_array($key, self::$fields)){
                $this->{$key} = $value;
            }
        }
    }
    public function dataValidate() {
        foreach ($this->validateRule() as $field => $rules) {
            $value = $this->{$field};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($rule)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addErrorByRule($field, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_FILE_EXT) {
                    $fileName = explode(".", $value);
                    $fileExtension = strtolower(end($fileName));
                    if(!in_array($fileExtension, $this->allowFiles)) {
                        $this->addErrorByRule($field, self::RULE_FILE_EXT);
                    }
                }
            }
        }

        return empty($this->errors);
    }

    public function errorMessages() {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_FILE_EXT => "Please upload valid image"
        ];
    }

    public function errorMessage($rule) {
        return $this->errorMessages()[$rule];
    }

    protected function addErrorByRule($fields, $rule, $params = []) {
        $params['field'] ??= $fields;
        $errorMessage = $this->errorMessage($rule);
        foreach ($params as $key => $value) {
            $errorMessage = str_replace("{{$key}}", $value, $errorMessage);
        }
        $this->errors[$fields][] = $errorMessage;
    }

    public function addError($fields, $message) {
        $this->errors[$fields][] = $message;
    }

    public function hasError($fields) {
        return $this->errors[$fields] ?? false;
    }

    public function getFirstError($fields) {
        $errors = $this->errors[$fields] ?? [];
        return $errors[0] ?? '';
    }

    public function save() {
        $table_name = Model::$table_name;
        $fields = Model::$fields;
        $params = array_map(fn($field) => ":$field", $fields);
        try {
            $statement = self::prepare("INSERT INTO $table_name (" . implode(",", $fields) . ") VALUES (" . implode(",", $params) . ")");
            foreach ($fields as $field) {
                $statement->bindValue(":$field", $this->{$field});
            }
            $statement->execute();
            return $this->getLastInsertedId();
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    public function delete($id) {
        $table_name = Model::$table_name;
        try {
            $statement = self::prepare("DELETE FROM $table_name WHERE {$this->primary_key} = :id");
            $statement->bindValue(":id", $id);
            $statement->execute();
            return $statement->rowCount();
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    public function getLastInsertedId() {
        return Database::$db_connect_obj->lastInsertId();
    }

    public function setWhere($condition, $field) {
        $this->where_condition .= " $condition ";
        $this->where_field_data = array_merge($this->where_field_data, $field);
    }

    public function setLimit($string) {
        $this->set_limit = " $string";
    }

    public function setOrder($string) {
        $this->set_order .= " $string";
    }

    public function findAll() {
        $whereCond = ltrim(strtolower(trim($this->where_condition)),"and");
        $whereCond = ltrim($whereCond, "or");
        if(!empty($whereCond)) {
            $whereCond = " WHERE $whereCond"; 
        } else {
            $whereCond = "";
        }
        
        if(!empty($this->set_order)) $whereCond .= " ORDER BY $this->set_order";

        if(!empty($this->set_limit)) $whereCond .= " $this->set_limit";

        $tableName = static::$table_name;
        $statement = self::prepare("SELECT * FROM $tableName $whereCond");

        foreach ($this->where_field_data as $key => $item) {
            $statement->bindValue($key, $item);
        }
        
        $statement->execute();
        $Records = $statement->fetchAll(\PDO::FETCH_CLASS, static::class);
        $totalRecords = $this->getTotalRecords();
        $this->unsetRecoredSet();
        return [
            "Records"=>$Records,
            "TotalRecords"=>$totalRecords->TotalRecords
        ];
    }

    public function getTotalRecords() {
        $whereCond = ltrim(strtolower(trim($this->where_condition)),"and");
        $whereCond = ltrim($whereCond, "or");
        if(!empty($whereCond)) {
            $whereCond = " WHERE $whereCond"; 
        } else {
            $whereCond = "";
        }

        $tableName = static::$table_name;
        $statement = self::prepare("SELECT count(*) AS TotalRecords FROM $tableName $whereCond");
        
        foreach ($this->where_field_data as $key => $item) {
            $statement->bindValue($key, $item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    private function unsetRecoredSet() {
        unset($this->where_condition);
        unset($this->where_field_data);
        unset($this->set_limit);
        unset($this->set_order);
    }
    public function findOne($where) {
        $tableName = static::$table_name;
        $fields = array_keys($where);

        $whereCond = implode("AND", array_map(fn($field) => "$field = :$field", $fields));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $whereCond");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }
}