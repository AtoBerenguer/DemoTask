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

    public function getAll() {
        $stmt = $this->db->prepare("SELECT 
        i.Id as ItemId,
        i.Typology as Typology,
        i.SerialNumber as SerialNumber,
        i.IsActive as Active,
        m.Model_Name AS ModelName,
        b.Brand_Name AS BrandName,
        c.Company AS CompanyName
        
        FROM Inventary i
        INNER JOIN Brand b ON i.Brand_Id = b.Id
        INNER JOIN Model m ON i.Model_Id = m.Id
        INNER JOIN Customer c ON i.Cust_Id = c.Id");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}