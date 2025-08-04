<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Repository\WorkOrderRepository;

class WorkOrderController {
    
    public static function getAll(Request $request, Response $response) {
        $workOrders = (new WorkOrderRepository())->getAll();
        
        if (empty($workOrders)) {
            $response->getBody()->write(json_encode(['message' => 'No work orders found']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        
        $response->getBody()->write(json_encode($workOrders));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public static function create(Request $request, Response $response): Response {
        $data = json_decode($request->getBody()->getContents(), true);

        $data['customer_id'] = $data['customerId'];
        $data['inv_id'] = $data['ItemId'];
        $data['start_date'] = date('Y-m-d H:i:s'); 
        $data['end_date'] = null;
        $data['state'] = 'Pendiente';

        $workOrder = (new WorkOrderRepository())->create($data);

        if ($workOrder) {
            $response->getBody()->write(json_encode(['message' => 'Work order created successfully']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        }
        $response->getBody()->write(json_encode(['message' => 'Failed to create work order']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }

    
}