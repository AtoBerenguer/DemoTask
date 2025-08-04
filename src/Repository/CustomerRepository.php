<?php
namespace App\Repository;
use App\Connection\dbConnection;
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
}