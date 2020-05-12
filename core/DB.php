<?php


namespace Core;


class DB
{
    private static $instances = [];
    public $connection;

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): DB
    {
        $class = static::class;
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static;
        }

        return self::$instances[$class];
    }

    public function getConnection()
    {
        if(!$this->connection){
            $config = yaml_parse_file(BASE_PATH."config.yaml");
            $this->connection= new \PDO('mysql:host=localhost;dbname='.$config["db"]["name"], $config["db"]["user"], $config["db"]["password"]);
        }
        return $this->connection;
    }

}