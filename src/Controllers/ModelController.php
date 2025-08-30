<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Repository\ModelRepository;

    class ModelController{
        public static function create(Request $request, Response $response)
        {
            $data = $request->getParsedBody();

            (new ModelRepository())->create($data);

            $response->getBody()->write(json_encode(['message' => 'Model created successfully']));

            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        }
        
        
        
    };