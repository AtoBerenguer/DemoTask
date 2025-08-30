<?php 

namespace App\Repository;

use App\Connection\dbConnection;
use PDO;

class ModelRepository{
private $db;

    public function __construct() {
        $this->db = dbConnection::getConnection();
    }

    public function create(array $data) {
        $stmt = $this->db->prepare("INSERT INTO Model (Model_Name) VALUES (:Model_Name)");
        $stmt->bindParam(':Model_Name', $data['Model_Name']);
        $stmt->execute();
    }
   

}