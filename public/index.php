<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use App\Controllers\BrandController;
use App\Controllers\WorkOrderController;
use App\Controllers\CustomerController;
use App\Controllers\InventaryController;

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
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

$app->options('/{routes:.+}', function (Request $request, Response $response): Response {
    return $response;
});

// RUTAS
$app->post('/brand', [BrandController::class, 'create']);
$app->get('/brand/{id}', [BrandController::class, 'getById']);
$app->get('/workorders', [WorkOrderController::class, 'getAll']);
$app->get('/customers', [CustomerController::class, 'getAll']);
$app->get('/inv/{id}', [InventaryController::class, 'getById']);
$app->post('/newOrder', [WorkOrderController::class, 'create']);
$app->post('/newCustomer', [CustomerController::class, 'create']);



// $app->get('/tasks', [BrandController::class, 'getAll']);
// $app->get('/tasks/{id}', [BrandController::class, 'getById']);
// $app->put('/tasks/{id}', [BrandController::class, 'update']);
// $app->delete('/tasks/{id}', [BrandController::class, 'delete']);

$app->run();
