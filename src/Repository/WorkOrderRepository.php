<?php
namespace App\Repository;
use App\Connection\dbConnection;
use PDO;

class WorkOrderRepository{
    private $db;

    public function __construct() {
        $this->db = dbConnection::getConnection();
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT 
            w.Id AS WorkOrderId,
            c.Company AS CustomerName,
            i.Typology AS EquipmentTypology,
            i.Id AS EquipmentId,
            i.SerialNumber AS EquipmentSerialNumber,
            b.Brand_Name AS BrandName,
            m.Model_Name AS ModelName,
            w.Fault,
            w.StartDate,
            w.EndDate,
            w.State
        FROM WorkOrder w
        INNER JOIN Customer c ON w.Customer_Id = c.Id
        INNER JOIN Inventary i ON w.Inv_Id = i.Id
        INNER JOIN Brand b ON i.Brand_Id = b.Id
        INNER JOIN Model m ON i.Model_Id = m.Id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
            $stmt = $this->db->prepare("
                INSERT INTO WorkOrder (Customer_Id, Inv_Id, Fault, StartDate, EndDate, State)
                VALUES (:customer_id, :inv_id, :fault, :start_date, :end_date, :state)
            ");

            $stmt->bindParam(':customer_id', $data['customer_id']);
            $stmt->bindParam(':inv_id', $data['inv_id']);
            $stmt->bindParam(':fault', $data['fault']);
            $stmt->bindParam(':start_date', $data['start_date']);
            $stmt->bindParam(':end_date', $data['end_date']);
            $stmt->bindParam(':state', $data['state']);

            if ($stmt->execute()) {
                return true;
            }

    return false;
}

    




}