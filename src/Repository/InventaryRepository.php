<?php
namespace App\Repository;
use App\Connection\dbConnection;
use PDO;

class InventaryRepository {
    private $db;

    public function __construct() {
        $this->db = dbConnection::getConnection();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT 
            i.Id AS ItemId,
            i.Typology AS Typology,
            i.SerialNumber AS SerialNumber
            
        FROM Inventary i WHERE i.Cust_Id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}