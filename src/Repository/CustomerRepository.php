<?php
namespace App\Repository;
use App\Connection\dbConnection;
use Error;
use PDO;


class CustomerRepository {
    private $db;

    public function __construct() {
        $this->db = dbConnection::getConnection();
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT 
            c.Id AS CustomerId,
            c.Company AS CompanyName,
            c.PhoneNumber AS PhoneNumber,
            c.Email AS Email
        FROM Customer c");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data){
        $stmt = $this->db->prepare("INSERT INTO customer (Company, PhoneNumber, Email)
        VALUES (:Company, :PhoneNumber, :Email)");
        if (empty($data['Company']) || empty($data['PhoneNumber']) || empty($data['Email'])){
            throw new Error('All fields are required');}
        $stmt->bindParam(':Company', $data['Company']);
        $stmt->bindParam(':PhoneNumber', $data['PhoneNumber']);
        $stmt->bindParam(':Email', $data['Email']);
        $stmt->execute();
        
    }

    public function update (array $data)
    {
        $stmt = $this->db->prepare("UPDATE customer SET Company = :CompanyName, PhoneNumber = :PhoneNumber, Email = :Email WHERE Id = :Id");
        if (empty($data['CompanyName']) || empty($data['PhoneNumber']) || empty($data['Email'])){
            throw new Error('All fields are required');}
            $stmt->bindParam(':Id', $data['CustomerId']);
            $stmt->bindParam(':CompanyName', $data['CompanyName']);
            $stmt->bindParam(':PhoneNumber', $data['PhoneNumber']);
            $stmt->bindParam(':Email', $data['Email']);
            $stmt->execute();
    }

    public function delete (array $data)
    {
        $stmt = $this->db->prepare("DELETE FROM customer WHERE Id = :Id");
        $stmt->bindParam(':Id', $data['CustomerId']);
        $stmt->execute();
    }
}