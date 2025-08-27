<?php

namespace App\Repository;

use App\Connection\dbConnection;
use PDO;

class WorkOrderRepository
{
    private $db;

    public function __construct()
    {
        $this->db = dbConnection::getConnection();
    }

    public function getAll()
    {
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

    public function create($data)
    {
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

    public function getById(array $data)
    {
        $stmt = $this->db->prepare("
        SELECT 
            w.Id AS WorkOrderId,
            w.Fault,
            w.StartDate,
            w.EndDate,
            w.State,
            
            -- Datos del cliente
            c.Id AS CustomerId,
            c.Company AS CustomerName,
            c.PhoneNumber AS CustomerPhone,
            c.Email AS CustomerEmail,

            -- Datos del inventario
            i.Id AS EquipmentId,
            i.Typology AS EquipmentTypology,
            i.SerialNumber AS EquipmentSerialNumber,
            i.IsActive AS EquipmentIsActive,
            
            -- Marca y modelo
            b.Brand_Name AS BrandName,
            m.Model_Name AS ModelName,

            -- Comentarios (relacionados con la orden de trabajo, no inventario)
            cm.Id AS CommentId,
            cm.Message AS CommentMessage,
            cm.Date AS CommentDate

        FROM workorder w
        INNER JOIN customer c 
            ON w.Customer_Id = c.Id
        INNER JOIN inventary i 
            ON w.Inv_Id = i.Id
        INNER JOIN brand b 
            ON i.Brand_Id = b.Id
        INNER JOIN model m 
            ON i.Model_Id = m.Id
        LEFT JOIN comments cm 
            ON cm.Wo_Id = w.Id

        WHERE w.Id = :Id
    ");
        $stmt->bindParam(':Id', $data['WorkOrderId'], PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
