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
        
        public static function getAll(Request $request, Response $response)
        {
            $models = (new ModelRepository())->getAll();
            if (empty($models))
            {
                $response->getBody()->write(json_encode(['message' => 'No models found']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
            }
            $response->getBody()->write(json_encode($models));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        }
        public function update(Request $request, Response $response){
            $data = $request ->getParsedBody();
            (new ModelRepository())->update($data);

            $response->getBody()->write(json_encode(['message'=>'Modelo actualizada']));
            return $response->withHeader('Content-Type','application/json')->withStatus(201);
        }

        public function delete(Request $request, Response $response){
            $data = $request ->getParsedBody();
            (new ModelRepository())->delete($data);

            $response->getBody()->write(json_encode(['message'=>'Modelo borrada']));
            return $response->withHeader('Content-Type','application/json')->withStatus(201);
            
        }
        
        
    };