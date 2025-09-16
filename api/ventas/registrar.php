<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

//depurar errores (Solo para mi)
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

try {
    require_once __DIR__ . '/../../app/config.php';

    // --- 1. Captura y valida JSON ---
    $json = file_get_contents('php://input');
    if (!$json) {
        throw new Exception("No se recibió ningún JSON");
    }

    $data = json_decode($json, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("JSON inválido: " . json_last_error_msg());
    }

    // --- 2. Normalizar entrada ---
    $productos      = $data['productos'] ?? [];
    $id_cliente     = !empty($data['id_cliente']) ? intval($data['id_cliente']) : 1; // 1 => Consumidor Final
    $id_forma_pago  = !empty($data['id_forma_pago']) ? intval($data['id_forma_pago']) : null;
    $total          = isset($data['total']) ? floatval($data['total']) : 0;

    if (count($productos) === 0) throw new Exception("No hay productos en la venta");
    if ($total <= 0) throw new Exception("Total inválido");

    // --- 3. Usuario autenticado ---
    $id_usuario = $_SESSION['sesion_id_usuario'] ?? $_SESSION['id_usuario'] ?? null;
    if (!$id_usuario) throw new Exception("Usuario no autenticado en la sesión");

    // --- 4. Obtener siguiente nro_venta ---
    $stmt = $pdo->query("SELECT MAX(nro_venta) AS max_nro FROM tb_ventas");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $siguiente_nro = ($row['max_nro'] ?? 0) + 1;

    // --- 5. Iniciar transacción ---
    $pdo->beginTransaction();

    // Insertar venta
    $sqlVenta = "INSERT INTO tb_ventas 
        (nro_venta, id_cliente, id_forma_pago, id_estado, total_pagado, id_usuario, fyh_creacion, fyh_actualizacion)
        VALUES (:nro, :id_cliente, :id_forma_pago, :id_estado, :total, :id_usuario, NOW(), NOW())";

    $stmt = $pdo->prepare($sqlVenta);
    $stmt->execute([
        ':nro'           => $siguiente_nro,
        ':id_cliente'    => $id_cliente,
        ':id_forma_pago' => $id_forma_pago,
        ':id_estado'     => 2, // 2 = Pagado
        ':total'         => $total,
        ':id_usuario'    => $id_usuario
    ]);

    $id_venta = $pdo->lastInsertId();

    // --- 6. Preparar statements ---
    $stmtDetalle = $pdo->prepare("INSERT INTO tb_detalle_ventas 
        (id_venta, id_producto, cantidad, precio_unitario, subtotal)
        VALUES (:id_venta, :id_producto, :cantidad, :precio_unitario, :subtotal)");

    $stmtStockSelect = $pdo->prepare("SELECT stock FROM tb_almacen WHERE id_producto = :id_producto FOR UPDATE");
    $stmtStockUpdate = $pdo->prepare("UPDATE tb_almacen SET stock = stock - :cantidad WHERE id_producto = :id_producto");

    $stmtMovimiento = $pdo->prepare("INSERT INTO tb_movimientos_inventario 
        (id_producto, tipo_movimiento, cantidad, descripcion, fecha_movimiento, id_usuario) 
        VALUES (:id_producto, :tipo_movimiento, :cantidad, :descripcion, NOW(), :id_usuario)");

    // --- 7. Procesar productos ---
    foreach ($productos as $p) {
        $id_producto = isset($p['id']) ? intval($p['id']) : (isset($p['id_producto']) ? intval($p['id_producto']) : 0);
        $cantidad    = isset($p['cantidad']) ? intval($p['cantidad']) : 0;
        $precio      = isset($p['precio']) ? floatval($p['precio']) : 0;
        $subtotal    = isset($p['total']) ? floatval($p['total']) : ($precio * $cantidad);

        if ($id_producto <= 0 || $cantidad <= 0) {
            throw new Exception("Producto inválido en detalle");
        }

        // Revisar stock
        $stmtStockSelect->execute([':id_producto' => $id_producto]);
        $rowStock = $stmtStockSelect->fetch(PDO::FETCH_ASSOC);
        if (!$rowStock) throw new Exception("Producto no encontrado (id: $id_producto)");
        if (intval($rowStock['stock']) < $cantidad) {
            throw new Exception("Stock insuficiente para el producto ID {$id_producto}");
        }

        // Insertar detalle
        $stmtDetalle->execute([
            ':id_venta'       => $id_venta,
            ':id_producto'    => $id_producto,
            ':cantidad'       => $cantidad,
            ':precio_unitario'=> $precio,
            ':subtotal'       => $subtotal
        ]);

        // Actualizar stock
        $stmtStockUpdate->execute([
            ':cantidad'    => $cantidad,
            ':id_producto' => $id_producto
        ]);

        // Insertar movimiento
        $descripcion = "Salida por venta #$siguiente_nro";
        $stmtMovimiento->execute([
            ':id_producto'    => $id_producto,
            ':tipo_movimiento'=> 'SALIDA',
            ':cantidad'       => $cantidad,
            ':descripcion'    => $descripcion,
            ':id_usuario'     => $id_usuario
        ]);
    }

    // --- 8. Confirmar transacción ---
    $pdo->commit();

    echo json_encode([
        "status"   => "success",
        "message"  => "Venta registrada",
        "id_venta" => $id_venta,
        "nro_venta"=> $siguiente_nro
    ], JSON_UNESCAPED_UNICODE);
    exit;

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) $pdo->rollBack();
    http_response_code(400);
    echo json_encode([
        "status"  => "error",
        "message" => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
