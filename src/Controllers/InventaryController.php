<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Repository\InventaryRepository;

class InventaryController {
    
    public static function getById(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $inventaryRepo = new InventaryRepository();
        $item = $inventaryRepo->getById($id);
        
        if (!$item) {
            $response->getBody()->write(json_encode(['message' => 'Item not found']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        
        $response->getBody()->write(json_encode($item));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
    
}