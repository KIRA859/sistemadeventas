<?php
include('../../app/config.php');
header("Content-Type: application/json; charset=UTF-8");

$method = $_SERVER['REQUEST_METHOD'];

try {
    if ($method === 'GET') {
        // 1. Generar próximo código de producto
        $stmt = $pdo->query("SELECT MAX(codigo) as max_codigo FROM tb_almacen");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $next_code = ($row && $row['max_codigo']) ? 'P-' . str_pad((intval(substr($row['max_codigo'], 2)) + 1), 5, '0', STR_PAD_LEFT) : 'P-00001';

        // 2. Obtener categorías
        $stmtCat = $pdo->query("SELECT id_categoria, nombre_categoria FROM tb_categorias ORDER BY nombre_categoria ASC");
        $categories = $stmtCat->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "success" => true,
            "next_code" => $next_code,
            "categories" => $categories
        ]);
        exit;
    }

    if ($method === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data) {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "No se recibió JSON válido"]);
            exit;
        }

        // Validar campos obligatorios
        if (empty($data['codigo']) || empty($data['nombre']) || empty($data['id_categoria']) || empty($data['id_usuario'])) {
            http_response_code(422);
            echo json_encode(["success" => false, "error" => "Faltan campos obligatorios"]);
            exit;
        }

        // Insertar producto
        $stmt = $pdo->prepare("
            INSERT INTO tb_almacen 
            (codigo, nombre, descripcion, stock, stock_minimo, stock_maximo, precio_compra, precio_venta, fecha_ingreso, imagen, id_usuario, id_categoria, fyh_creacion, activo)
            VALUES (:codigo, :nombre, :descripcion, :stock, :stock_minimo, :stock_maximo, :precio_compra, :precio_venta, :fecha_ingreso, :imagen, :id_usuario, :id_categoria, NOW(), 1)
        ");

        $stmt->execute([
            ":codigo"        => $data['codigo'],
            ":nombre"        => $data['nombre'],
            ":descripcion"   => $data['descripcion'] ?? null,
            ":stock"         => $data['stock'] ?? 0,
            ":stock_minimo"  => $data['stock_minimo'] ?? 0,
            ":stock_maximo"  => $data['stock_maximo'] ?? 0,
            ":precio_compra" => $data['precio_compra'] ?? 0,
            ":precio_venta"  => $data['precio_venta'] ?? 0,
            ":fecha_ingreso" => $data['fecha_ingreso'],
            ":imagen"        => $data['imagen'] ?? null,
            ":id_usuario"    => $data['id_usuario'],
            ":id_categoria"  => $data['id_categoria']
        ]);

        $id_producto = $pdo->lastInsertId();

        echo json_encode([
            "success" => true,
            "message" => "Producto registrado con éxito",
            "id_producto" => $id_producto
        ]);
        exit;
    }

    // Si no es GET ni POST
    http_response_code(405);
    echo json_encode(["success" => false, "error" => "Método no permitido"]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
