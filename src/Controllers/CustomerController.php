<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Repository\CustomerRepository;

class CustomerController {
    
    public static function getAll(Request $request, Response $response) {
        $customers = (new CustomerRepository())->getAll();
        
        if (empty($customers)) {
            $response->getBody()->write(json_encode(['message' => 'No customers found']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        
        $response->getBody()->write(json_encode($customers));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
    
}