<?php

namespace App\Entity;
use PDO;

class Db {
    const DSN = 'mysql:host=mysql.studev.groept.be;dbname=a22web13';
    const USERNAME = 'a22web13';
    const PASSWORD = 'ghbC10RO';

    private PDO $connection;
    private static Db $instance;

    /**
     * A private constructor, the object can only be created by the getConnection method
     */
    private function __construct() {
        $this->connection = new PDO(self::DSN,self::USERNAME,self::PASSWORD);
    }

    /**
     * Initialises a new object if it does not exists yet and sets up the connection
     * @return PDO the connection to the mysql server
     */
    public static function getConnection(): PDO {
        if (!isset(self::$instance)) {
            self::$instance = new Db();
        }
        return self::$instance->connection;
    }

}
