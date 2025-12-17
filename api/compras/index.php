<?php
// Headers CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");
// Para peticiones OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

header("Content-Type: application/json");
require_once("../../app/config.php");

try {
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'GET') {
        // Endpoint para obtener el máximo número de compra
        if (isset($_GET['action']) && $_GET['action'] === 'get_max_nro') {
            try {
                $stmt = $pdo->prepare("SELECT MAX(nro_compra) as max_nro FROM tb_compras");
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                echo json_encode([
                    "success" => true,
                    "max_nro" => $row['max_nro'] ? (int)$row['max_nro'] : 0
                ]);
                exit;
                
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(["success" => false, "error" => "Error al obtener número de compra"]);
                exit;
            }
        }
        
        // Obtener compra específica por ID
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);

            $stmt = $pdo->prepare("
                SELECT c.*, 
                       p.nombre_proveedor, 
                       p.celular as celular_proveedor,
                       p.telefono as telefono_proveedor,
                       p.empresa as empresa_proveedor,
                       p.email as email_proveedor,
                       p.direccion as direccion_proveedor,
                       u.nombres as nombres_usuario
                FROM tb_compras c 
                LEFT JOIN tb_proveedores p ON c.id_proveedor = p.id_proveedor 
                LEFT JOIN tb_usuarios u ON c.id_usuario = u.id_usuario 
                WHERE c.id_compra = :id
            ");
            $stmt->execute([":id" => $id]);
            $compra = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Buscar los productos de esa compra con JOIN a productos
            $stmtDetalle = $pdo->prepare("
                SELECT dc.*, pr.nombre as nombre_producto 
                FROM tb_detalle_compras dc 
                LEFT JOIN tb_almacen pr ON dc.id_producto = pr.id_producto 
                WHERE dc.id_compra = :id
            ");
            $stmtDetalle->execute([":id" => $id]);
            $productos = $stmtDetalle->fetchAll(PDO::FETCH_ASSOC);

            $compra['productos'] = $productos;

            echo json_encode(["success" => true, "data" => $compra]);
            exit;
        } else {
            // Si no viene id, devolver todas las compras con JOIN
            $stmt = $pdo->query("
                SELECT c.*, 
                       p.nombre_proveedor, 
                       p.celular as celular_proveedor,
                       p.telefono as telefono_proveedor,
                       p.empresa as empresa_proveedor,
                       u.nombres as nombres_usuario 
                FROM tb_compras c 
                LEFT JOIN tb_proveedores p ON c.id_proveedor = p.id_proveedor 
                LEFT JOIN tb_usuarios u ON c.id_usuario = u.id_usuario 
                ORDER BY c.fecha_compra DESC
            ");
            $compras = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(["success" => true, "data" => $compras]);
            exit;
        }
    }

    if ($method === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);

        if (json_last_error() !== JSON_ERROR_NONE || !$data) {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "No se recibió JSON válido"]);
            exit;
        }

        // Validaciones mínimas
        if (empty($data['id_usuario']) || empty($data['id_proveedor']) || empty($data['productos']) || !is_array($data['productos'])) {
            http_response_code(422);
            echo json_encode(["success" => false, "error" => "Datos incompletos para registrar la compra"]);
            exit;
        }

        try {
            // Fecha/hora creación
            $fechaHora = date('Y-m-d H:i:s');

            // Iniciar transacción
            $pdo->beginTransaction();

            // Obtener el próximo número de compra
            $stmtMax = $pdo->prepare("SELECT MAX(nro_compra) as max_nro FROM tb_compras");
            $stmtMax->execute();
            $row = $stmtMax->fetch(PDO::FETCH_ASSOC);
            $nro_compra = ((int)($row['max_nro'] ?? 0)) + 1;

            // Insertar compra (cabecera)
            $sqlInsert = "
                INSERT INTO tb_compras 
                (nro_compra, fecha_compra, comprobante, id_usuario, id_proveedor, total_compra, fyh_creacion) 
                VALUES (:nro, :fecha_compra, :comprobante, :usuario, :proveedor, :total, :fyh_creacion)
            ";
            $stmt = $pdo->prepare($sqlInsert);
            $stmt->execute([
                ":nro"          => $nro_compra,
                ":fecha_compra"        => $data['fecha_compra'] ?? date('Y-m-d'),
                ":comprobante"  => $data['comprobante'] ?? null,
                ":usuario"      => $data['id_usuario'],
                ":proveedor"    => $data['id_proveedor'],
                ":total"        => $data['total_compra'] ?? 0,
                ":fyh_creacion" => $fechaHora
            ]);

            $id_compra = $pdo->lastInsertId();

            // Preparar inserción de detalle y actualización de stock
            $stmtDetalle = $pdo->prepare("
                INSERT INTO tb_detalle_compras 
                (id_compra, id_producto, cantidad, precio_unitario, subtotal) 
                VALUES (:compra, :producto, :cantidad, :precio, :subtotal)
            ");
            $stmtUpdateStock = $pdo->prepare("UPDATE tb_almacen SET stock = stock + :cantidad WHERE id_producto = :id_producto");

            // Insertar cada producto en detalle y actualizar stock
            foreach ($data['productos'] as $p) {
                $id_producto = isset($p['id_producto']) ? (int)$p['id_producto'] : 0;
                $cantidad = isset($p['cantidad']) ? (int)$p['cantidad'] : 0;
                $precio_unitario = isset($p['precio_unitario']) ? (float)$p['precio_unitario'] : (isset($p['precio']) ? (float)$p['precio'] : 0.0);

                if ($id_producto <= 0 || $cantidad <= 0) {
                    throw new Exception("Producto inválido en detalle (id: {$id_producto}, cantidad: {$cantidad})");
                }

                $subtotal = round($cantidad * $precio_unitario, 2);

                $stmtDetalle->execute([
                    ':compra'       => $id_compra,
                    ':producto'     => $id_producto,
                    ':cantidad'     => $cantidad,
                    ':precio'       => $precio_unitario,
                    ':subtotal'     => $subtotal,
                ]);

                // Actualizar stock (suma porque es compra)
                $stmtUpdateStock->execute([
                    ':cantidad'     => $cantidad,
                    ':id_producto' => $id_producto
                ]);
            }

            // Commit
            $pdo->commit();

            echo json_encode([
                "success" => true,
                "message" => "Compra registrada correctamente",
                "id_compra" => $id_compra,
                "nro_compra" => $nro_compra
            ]);
            exit;
        } catch (Exception $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            http_response_code(500);
            echo json_encode(["success" => false, "error" => $e->getMessage()]);
            exit;
        }
    }

    if ($method === 'PUT') {
        // Obtener y validar JSON
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "JSON inválido: " . json_last_error_msg()]);
            exit;
        }

        // Validaciones completas
        if (!$data || empty($data['id_compra'])) {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "Falta id_compra"]);
            exit;
        }

        if (empty($data['productos']) || !is_array($data['productos'])) {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "Datos incompletos: productos faltantes"]);
            exit;
        }
        
        // Validar cada producto
        foreach ($data['productos'] as $index => $prod) {
            if (empty($prod['id_producto']) || empty($prod['cantidad']) || empty($prod['precio_compra'])) {
                http_response_code(400);
                echo json_encode(["success" => false, "error" => "Producto en posición " . ($index + 1) . " incompleto"]);
                exit;
            }
        }

        // Si no viene proveedor, obtener el actual
        if (empty($data['id_proveedor'])) {
            $stmtProv = $pdo->prepare("SELECT id_proveedor FROM tb_compras WHERE id_compra = :id");
            $stmtProv->execute([":id" => $data['id_compra']]);
            $rowProv = $stmtProv->fetch(PDO::FETCH_ASSOC);
            $data['id_proveedor'] = $rowProv['id_proveedor'] ?? null;
        }

        try {
            $pdo->beginTransaction();

            // 1. Actualizar cabecera de compra
            $stmt = $pdo->prepare("UPDATE tb_compras 
                SET fecha_compra = :fecha, 
                    comprobante = :comprobante, 
                    id_proveedor = :proveedor, 
                    total_compra = :total 
                WHERE id_compra = :id");

            // Calcular total (suma de todos los productos)
            $total_compra = 0;
            foreach ($data['productos'] as $prod) {
                $subtotal = $prod['cantidad'] * $prod['precio_compra'];
                $total_compra += $subtotal;
            }

            $stmt->execute([
                ":fecha" => $data['fecha_compra'],
                ":comprobante" => $data['comprobante'] ?? null,
                ":proveedor" => $data['id_proveedor'],
                ":total" => $total_compra,
                ":id" => $data['id_compra']
            ]);

            // 2. Eliminar detalle anterior
            $pdo->prepare("DELETE FROM tb_detalle_compras WHERE id_compra = :id")
                ->execute([":id" => $data['id_compra']]);

            // 3. Insertar nuevo detalle
            $stmtDetalle = $pdo->prepare("INSERT INTO tb_detalle_compras 
                (id_compra, id_producto, cantidad, precio_unitario, subtotal) 
                VALUES (:compra, :producto, :cantidad, :precio, :subtotal)");

            foreach ($data['productos'] as $prod) {
                $subtotal = $prod['cantidad'] * $prod['precio_compra'];
                $stmtDetalle->execute([
                    ":compra" => $data['id_compra'],
                    ":producto" => $prod['id_producto'],
                    ":cantidad" => $prod['cantidad'],
                    ":precio" => $prod['precio_compra'],
                    ":subtotal" => $subtotal
                ]);
            }

            $pdo->commit();

            // Respuesta exitosa
            echo json_encode([
                "success" => true,
                "message" => "Compra actualizada correctamente",
                "total_compra" => $total_compra
            ]);
        } catch (Exception $e) {
            $pdo->rollBack();
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "error" => "Error en la actualización: " . $e->getMessage()
            ]);
        }
        exit;
    }

    if ($method === 'DELETE') {
        // Leer el ID de la query string
        $id = $_GET['id'] ?? null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "Falta el id de la compra"]);
            exit;
        }

        try {
            $pdo->beginTransaction();

            // Obtener los productos de esa compra para revertir stock
            $stmt = $pdo->prepare("SELECT id_producto, cantidad FROM tb_detalle_compras WHERE id_compra = :id");
            $stmt->execute([":id" => $id]);
            $detalles = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($detalles as $det) {
                $pdo->prepare("UPDATE tb_almacen SET stock = stock - :cantidad WHERE id_producto = :id_producto")
                    ->execute([
                        ":cantidad" => $det['cantidad'],
                        ":id_producto" => $det['id_producto']
                    ]);
            }

            // Eliminar detalle
            $pdo->prepare("DELETE FROM tb_detalle_compras WHERE id_compra = :id")->execute([":id" => $id]);
            // Eliminar compra
            $pdo->prepare("DELETE FROM tb_compras WHERE id_compra = :id")->execute([":id" => $id]);

            $pdo->commit();
            echo json_encode(["success" => true, "message" => "Compra eliminada"]);
        } catch (Exception $e) {
            $pdo->rollBack();
            http_response_code(500);
            echo json_encode(["success" => false, "error" => $e->getMessage()]);
        }
        exit;
    }

    http_response_code(405);
    echo json_encode(["success" => false, "error" => "Método no permitido"]);
    
} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) $pdo->rollBack();
    http_response_code(500);
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}