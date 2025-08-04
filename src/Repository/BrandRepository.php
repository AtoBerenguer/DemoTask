<?php 

namespace App\Repository;

use App\Connection\dbConnection;
use PDO;

class BrandRepository{
private $db;

    public function __construct() {
        $this->db = dbConnection::getConnection();
    }

    public function create(array $data) {
        $stmt = $this->db->prepare("INSERT INTO Brand (Brand_Name) VALUES (:Brand_Name)");
        $stmt->bindParam(':Brand_Name', $data['Brand_Name']);
        $stmt->execute();
    }
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Brand WHERE ID = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}