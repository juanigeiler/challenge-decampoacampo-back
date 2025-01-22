<?php

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../helpers/Response.php';

class ProductoController
{
    public static function getProductos()
    {
        try {
            $db = Database::getInstance();
            $stmt = $db->query("SELECT id, nombre, descripcion, precio as precio_ars, created_at, updated_at FROM productos");
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $precio_dolar = getenv('PRECIO_USD');
            if(!$precio_dolar || $precio_dolar == 0) {
                throw new Exception("El valor del dólar no está configurado o no es válido");
            }

            foreach ($productos as &$producto) {
                $producto['precio_usd'] = round($producto['precio_ars'] / $precio_dolar, 2);
            }

            Response::json(['error' => 0, 'productos' => $productos]);
        } catch (Exception $e) {
            Response::json(['error' => 1, 'message' => $e->getMessage()], 500);
        }
    }

    public static function crearProducto() {
        try {

            $input = json_decode(file_get_contents('php://input'), true);

            if (!isset($input['nombre']) || !isset($input['precio'])) {
                throw new Exception("El nombre y el precio son requeridos.");
            }

            $pdo = Database::getInstance();
            $stmt = $pdo->prepare("INSERT INTO productos (nombre, precio, descripcion, created_at) VALUES (:nombre, :precio, :descripcion, now() )");
            $stmt->execute([
                ':nombre' => $input['nombre'],
                ':precio' => $input['precio'],
                ':descripcion' => array_key_exists('descripcion', $input ) ? $input['descripcion'] : null,
            ]);

            Response::json(['error' => 0, 'message' => 'Producto creado exitosamente.']);
        } catch (Exception $e) {
            Response::json(['error' => 1, 'message' => $e->getMessage()], 500);
        }
    }

    public static function getProductoxId($id) {
        try {
            $db = Database::getInstance();
            $stmt = $db->prepare("SELECT id, nombre, descripcion, precio as precio_ars, created_at, updated_at FROM productos WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$producto) {
                throw new Exception("Producto no encontrado.");
                return;
            }
    
            $precio_dolar = getenv('PRECIO_USD');
            if(!$precio_dolar || $precio_dolar == 0) {
                throw new Exception("El valor del dólar no está configurado o no es válido");
            }

            $producto['precio_usd'] = round($producto['precio_ars'] / $precio_dolar, 2);
    
            Response::json(['error' => 0, 'producto' => $producto]);
        } catch (Exception $e) {
            Response::json(['error' => 1, 'message' => $e->getMessage()], 500);
        }
    }

    public static function actualizarProducto($id) {
        
        try {
            $input = json_decode(file_get_contents('php://input'), true);

            if (!isset($input['nombre']) || !isset($input['precio'])) {
                throw new Exception("El nombre y el precio son requeridos.");
            }

            $pdo = Database::getInstance();
    
            $stmt = $pdo->prepare("UPDATE productos SET nombre = :nombre, precio = :precio, descripcion = :descripcion, updated_at = now() WHERE id = :id");
            $stmt->execute([
                ':id' => $id,
                ':nombre' => $input['nombre'],
                ':precio' => $input['precio'],
                ':descripcion' => array_key_exists('descripcion', $input ) ? $input['descripcion'] : null,
            ]);
    
            if ($stmt->rowCount() === 0) {
                throw new Exception("Producto no encontrado o no actualizado");
            }
    
            Response::json(['error' => 0, 'message' => 'Producto actualizado exitosamente.']);
        } catch (Exception $e) {
            Response::json(['error' => 1, 'message' => $e->getMessage()], 500);
        }
    }

    public static function eliminarProducto($id) {
        try {
            $pdo = Database::getInstance();
            $stmt = $pdo->prepare("DELETE FROM productos WHERE id = :id");
            $stmt->execute([':id' => $id]);
    
            if ($stmt->rowCount() === 0) {
                throw new Exception("Producto no encontrado");
            }
    
            Response::json(['error' => 0, 'message' => 'Producto eliminado exitosamente.']);
        } catch (Exception $e) {
            Response::json(['error' => 1, 'message' => $e->getMessage()], 500);
        }
    }
    
}
