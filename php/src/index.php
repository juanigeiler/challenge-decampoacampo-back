<?php

require_once __DIR__ . '/core/Router.php';
require_once __DIR__ . '/controllers/ProductoController.php';
require_once __DIR__ . '/config/env.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

Router::route('GET', '/productos/{id}', [ProductoController::class, 'getProductoxId']);
Router::route('PUT', '/productos/{id}', [ProductoController::class, 'actualizarProducto']);
Router::route('DELETE', '/productos/{id}', [ProductoController::class, 'eliminarProducto']);
Router::route('GET', '/productos', [ProductoController::class, 'getProductos']);
Router::route('POST', '/productos', [ProductoController::class, 'crearProducto']);

http_response_code(404);
echo json_encode(['error' => 'Endpoint not found']);
