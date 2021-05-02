<?php

namespace App\Model;

use App\Core\Model;

class Student extends Model {
    
    public function __construct()
    {
        Model::$table_name = "student";
        Model::$fields = ["name", "grade", "image", "dob", "address", "city", "country"];
        $this->primary_key = "id";
        $this->allowFiles = ["jpg", "png", "gif"];
    }

    public function validateRule() {
        return [
            "name" => [self::RULE_REQUIRED],
            'grade' => [self::RULE_REQUIRED],
            'dob' => [self::RULE_REQUIRED],
            'address' => [self::RULE_REQUIRED],
            'city' => [self::RULE_REQUIRED],
            'country' => [self::RULE_REQUIRED],
            'image' => [self::RULE_FILE_EXT]
        ];
    }
}