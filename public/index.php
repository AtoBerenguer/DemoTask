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

//WORK ORDERS
$app->get('/workorders', [WorkOrderController::class, 'getAll']); 
$app->post('/newOrder', [WorkOrderController::class, 'create']);
$app->patch('/WO',[WorkOrderController::class,'getById']);
$app->patch('/WO/newComment',[WorkOrderController::class,'newComment']);

//BRANDS
$app->post('/newBrand', [BrandController::class, 'create']); 
$app->get('/brand/getAll',[BrandController::class,'getAll']);
$app->patch('/brand/update',[BrandController::class,'update']);
$app->delete('/brand/delete',[BrandController::class,'delete']);

//MODELS
$app->post('/newModel',[ModelController::class,'create']);
$app->get('/model/getAll',[ModelController::class,'getAll']);
$app->patch('/model/update',[ModelController::class,'update']);
$app->delete('/model/delete',[ModelController::class,'delete']);

//CUSTOMERS
$app->get('/customers', [CustomerController::class, 'getAll']); 
$app->post('/newCustomer', [CustomerController::class, 'create']);
$app->patch('/updateCustomer',[CustomerController::class, 'update']);
$app->delete('/deleteCustomer',[CustomerController::class,'delete']);

//INVENTORY
$app->get('/inv/{id}', [InventaryController::class, 'getById']);
$app->get('/inv',[InventaryController::class,'getAll']);


// $app->get('/brand/{id}', [BrandController::class, 'getById']); 
// $app->get('/tasks', [BrandController::class, 'getAll']);
// $app->get('/tasks/{id}', [BrandController::class, 'getById']);
// $app->put('/tasks/{id}', [BrandController::class, 'update']);
// $app->delete('/tasks/{id}', [BrandController::class, 'delete']);

$app->run();
