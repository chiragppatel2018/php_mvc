<?php

namespace App\Core;

class Database {
	protected static $db_connect_obj;
	public $queryTime;
	private $debug = false;
    private $type;
    private $username;
    private $password;
    private $database;
    private $host;
    private $port;

    function __construct(array $config)
    {
        $this->type=$config["type"];
        $this->username=$config["username"];
        $this->password=$config["password"];
        $this->database=$config["database"];
        $this->host=$config["host"];
        $this->port=$config["port"];

        $this->connectDb();
    }

    protected function connectDb() {
        try {
            $connection_string = "$this->type:host=$this->host;dbname=$this->database";
            if(!empty(self::$db_connect_obj)) {
    			$connection = self::$db_connect_obj;
    			return ;
    		}

            $connection = new \PDO($connection_string, $this->username, $this->password, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));

            self::$db_connect_obj = $connection;
        } catch (\PDOException $e) {
            die('can not connect to db :'.$e->getMessage());
        }
    }

    public function getConnection() {
        return self::$db_connect_obj;
    }
    public static function prepare($sql): \PDOStatement {
        return self::$db_connect_obj->prepare($sql);
    }
}