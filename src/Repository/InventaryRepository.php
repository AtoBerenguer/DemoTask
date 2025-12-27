<?php

namespace App\Repository;

use App\Connection\dbConnection;
use PDO;

class InventaryRepository
{
    private $db;

    public function __construct()
    {
        $this->db = dbConnection::getConnection();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT 
            i.Id AS ItemId,
            i.Typology AS Typology,
            i.SerialNumber AS SerialNumber
            
        FROM Inventary i WHERE i.Cust_Id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
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

    public function create($data)
    {   
        
        $stmt = $this->db->prepare(

            "INSERT INTO 
                Inventary 
                (Typology,SerialNumber,Brand_Id,Model_Id,Cust_Id,IsActive) 
            VALUES 
                (:typology,:serialNumber,:brandId,:modelId,:clientId,:isActive)");

        $stmt->bindValue(':typology', $data['typology']);
        $stmt->bindValue(':serialNumber', $data['serialNumber']);
        $stmt->bindValue(':brandId', $data['brandId']);
        $stmt->bindValue(':modelId', $data['modelId']);
        $stmt->bindValue(':clientId', $data['clientId']);
        $stmt->bindValue(':isActive', 1);
        $stmt->execute();
    }
}
