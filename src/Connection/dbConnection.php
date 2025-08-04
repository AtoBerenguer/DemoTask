<?php 

namespace App\Connection;
use PDO;
use PDOException;

class dbConnection {
    private $host = "127.0.0.1";
    private $dbname = "DBSergio";
    private $username = "root";
    private $password = "";
    private $connection;

    public static function getConnection() {
        try {
            $instance = new self();
            $instance->connection = new PDO(
                "mysql:host={$instance->host};dbname={$instance->dbname}",
                $instance->username,
                $instance->password
            );
            $instance->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $instance->connection;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit;
        }
        
    }
}



