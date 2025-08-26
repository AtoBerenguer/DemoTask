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

    public static function create(Request $request, Response $response)
    {
        $data = $request ->getParsedBody();
        (new CustomerRepository())->create($data);

        $response->getBody()->write(json_encode(['message'=> 'Customer created successfully']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);

    }

    public static function update(Request $request, Response $response){
        $data = $request ->getParsedBody();
        (new CustomerRepository())->update($data);

        $response->getBody()->write(json_encode(['message'=>'Customer update succesfully']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
 
    }

    public static function delete (Request $request, Response $response)
    
    {
        $data = $request ->getParsedBody();
        (new CustomerRepository())->delete($data);

        $response->getBody()->write(json_encode(['message'=> 'Customer deleted successfully']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);

    }

    
    
}