<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Repository\BrandRepository;

    class BrandController{
        public static function create(Request $request, Response $response)
        {
            $data = $request->getParsedBody();

            (new BrandRepository())->create($data);

            $response->getBody()->write(json_encode(['message' => 'Brand created successfully']));

            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        }
        
        public static function getById(Request $request, Response $response, array $args) {
            $id = $args['id'];
            $Brand_name = (new BrandRepository())->getById($id)['Brand_Name'];

            if (!$Brand_name) {
                $response->getBody()->write(json_encode(['error' => 'Brand not found']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
            }
            $response->getBody()->write(json_encode(['Brand_Name' => $Brand_name]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        }
        
    };