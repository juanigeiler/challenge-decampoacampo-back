<?php

require_once __DIR__ . '/core/Router.php';
require_once __DIR__ . '/controllers/ProductoController.php';
require_once __DIR__ . '/config/env.php';

Router::route('GET', '/productos/{id}', [ProductoController::class, 'getProductoxId']);
Router::route('PUT', '/productos/{id}', [ProductoController::class, 'actualizarProducto']);
Router::route('DELETE', '/productos/{id}', [ProductoController::class, 'eliminarProducto']);
Router::route('GET', '/productos', [ProductoController::class, 'getProductos']);
Router::route('POST', '/productos', [ProductoController::class, 'crearProducto']);

http_response_code(404);
echo json_encode(['error' => 'Endpoint not found']);
