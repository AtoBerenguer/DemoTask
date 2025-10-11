<?php 

namespace App\Repository;

use App\Connection\dbConnection;
use PDO;
use Error;

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

    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM Model");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function update(array $data)
    {
        $stmt = $this->db->prepare("UPDATE Model SET Model_Name = :Model_Name WHERE Id = :Id");
        if (empty($data['Model_Name'])){
            throw new Error('Todos los campos son requeridos');}

            $stmt->bindParam(':Id',$data['Id']);
            $stmt->bindParam(':Model_Name', $data['Model_Name']);

            $stmt->execute();
        
    }

    public function delete(array $data)
    {
        $stmt = $this->db->prepare("DELETE FROM Model WHERE Id = :Id");
        $stmt->bindParam(':Id', $data['Id']);
        $stmt->execute();
    }
   

}