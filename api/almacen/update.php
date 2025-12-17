<?php
include('../../app/config.php');
header("Content-Type: application/json; charset=UTF-8");

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'PUT' && $method !== 'POST') {
    http_response_code(405);
    echo json_encode(["success" => false, "error" => "Método no permitido"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['id_producto'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "Falta id_producto o datos"]);
    exit;
}

try {
    // 1. Procesar imagen si viene en base64
    $nombre_imagen = null;
    if (!empty($data['imagen']) && is_string($data['imagen'])) {
        // Verificar si es base64
        if (preg_match('/^data:image\/(\w+);base64,/', $data['imagen'], $type)) {
            $image_data = substr($data['imagen'], strpos($data['imagen'], ',') + 1);
            $image_type = strtolower($type[1]);
            
            // Validar tipo de imagen
            if (!in_array($image_type, ['jpg', 'jpeg', 'png', 'gif'])) {
                http_response_code(400);
                echo json_encode(["success" => false, "error" => "Formato de imagen no válido"]);
                exit;
            }
            
            // Decodificar y guardar
            $image_data = base64_decode($image_data);
            $nombre_imagen = uniqid() . '.' . $image_type;
            $ruta_imagen = "../../almacen/img_productos/" . $nombre_imagen;
            
            if (!file_put_contents($ruta_imagen, $image_data)) {
                http_response_code(500);
                echo json_encode(["success" => false, "error" => "Error al guardar la imagen"]);
                exit;
            }
        }
    }
    
    // 2. Construir consulta dinámica
    $campos = [
        "nombre = :nombre",
        "descripcion = :descripcion", 
        "stock = :stock",
        "stock_minimo = :stock_minimo",
        "stock_maximo = :stock_maximo",
        "precio_compra = :precio_compra",
        "precio_venta = :precio_venta",
        "fecha_ingreso = :fecha_ingreso",
        "id_categoria = :id_categoria",
        "fyh_actualizacion = NOW()"
    ];
    
    $params = [
        ":nombre"        => $data['nombre'],
        ":descripcion"   => $data['descripcion'] ?? null,
        ":stock"         => $data['stock'],
        ":stock_minimo"  => $data['stock_minimo'],
        ":stock_maximo"  => $data['stock_maximo'],
        ":precio_compra" => $data['precio_compra'],
        ":precio_venta"  => $data['precio_venta'],
        ":fecha_ingreso" => $data['fecha_ingreso'],
        ":id_categoria"  => $data['id_categoria'],
        ":id_producto"   => $data['id_producto']
    ];
    
    // 3. Agregar imagen si se subió una nueva
    if ($nombre_imagen) {
        $campos[] = "imagen = :imagen";
        $params[":imagen"] = $nombre_imagen;
        
        // Opcional: eliminar anterior imagen
        if (!empty($data['imagen_actual'])) {
            $ruta_anterior = "../../almacen/img_productos/" . $data['imagen_actual'];
            if (file_exists($ruta_anterior)) {
                unlink($ruta_anterior);
            }
        }
    }
    
    // 4. Ejecutar actualización
    $sql = "UPDATE tb_almacen SET " . implode(", ", $campos) . " WHERE id_producto = :id_producto";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    echo json_encode([
        "success" => true,
        "message" => "Producto actualizado correctamente",
        "imagen" => $nombre_imagen // Opcional: devolver nombre de la nueva imagen
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}