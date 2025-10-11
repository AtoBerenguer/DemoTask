<?php 

namespace App\Repository;

use App\Connection\dbConnection;
use PDO;
use Error;

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

    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM Brand");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function update(array $data)
    {
        $stmt = $this->db->prepare("UPDATE Brand SET Brand_Name = :Brand_Name WHERE Id = :Id");
        if (empty($data['Brand_Name'])){
            throw new Error('Todos los campos son requeridos');}

            $stmt->bindParam(':Id',$data['Id']);
            $stmt->bindParam(':Brand_Name', $data['Brand_Name']);

            $stmt->execute();
        
    }

    public function delete(array $data)
    {
        $stmt = $this->db->prepare("DELETE FROM Brand WHERE Id = :Id");
        $stmt->bindParam(':Id', $data['Id']);
        $stmt->execute();
    }

}