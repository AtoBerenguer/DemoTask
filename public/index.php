<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use App\Controllers\BrandController;
use App\Controllers\WorkOrderController;
use App\Controllers\CustomerController;
use App\Controllers\InventaryController;
use App\Controllers\ModelController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;

$app = AppFactory::create();

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();

$app->add(function (Request $request, RequestHandlerInterface $handler): Response {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*') 
        ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT,PATCH, DELETE, OPTIONS');
});

$app->options('/{routes:.+}', function (Request $request, Response $response): Response {
    return $response;
});

// RUTAS
$app->post('/newBrand', [BrandController::class, 'create']); //CREAR MARCA
$app->get('/brand/{id}', [BrandController::class, 'getById']); //OBTENER MARCA POR ID
$app->get('/workorders', [WorkOrderController::class, 'getAll']); //OBTENER TODAS LAS ORDENES DE TRABAJO
$app->get('/customers', [CustomerController::class, 'getAll']); //OBTENER TODOS LOS CLIENTES 
$app->get('/inv/{id}', [InventaryController::class, 'getById']);
$app->post('/newOrder', [WorkOrderController::class, 'create']);
$app->post('/newCustomer', [CustomerController::class, 'create']);
$app->patch('/updateCustomer',[CustomerController::class, 'update']);
$app->delete('/deleteCustomer',[CustomerController::class,'delete']);
$app->patch('/WO',[WorkOrderController::class,'getById']);
$app->get('/inv',[InventaryController::class,'getAll']);
$app->post('/newModel',[ModelController::class,'create']);
$app->patch('/WO/newComment',[WorkOrderController::class,'newComment']);

// $app->get('/tasks', [BrandController::class, 'getAll']);
// $app->get('/tasks/{id}', [BrandController::class, 'getById']);
// $app->put('/tasks/{id}', [BrandController::class, 'update']);
// $app->delete('/tasks/{id}', [BrandController::class, 'delete']);

$app->run();
