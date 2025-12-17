<?php
// Devuelve: { status, productos, clientes, formas_pago, data (ventas) }

include('../../app/config.php');
header('Content-Type: application/json; charset=utf-8');

try {
    //Productos (activos)
    $stmt = $pdo->prepare("
        SELECT id_producto, codigo, nombre, precio_venta, stock, imagen
        FROM tb_almacen
        WHERE IFNULL(activo,1) = 1
        ORDER BY nombre ASC
    ");
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //Clientes
    $stmt = $pdo->prepare("
        SELECT id_cliente, nombre_cliente, nit_ci_cliente, celular_cliente, email_cliente
        FROM tb_clientes
        ORDER BY nombre_cliente ASC
    ");
    $stmt->execute();
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //Formas de pago
    $stmt = $pdo->prepare("
        SELECT id_forma_pago, nombre_forma_pago
        FROM tb_formas_pago
        ORDER BY id_forma_pago ASC
    ");
    $stmt->execute();
    $formas_pago = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //Ventas (cabecera)
    $stmt = $pdo->prepare("
        SELECT v.id_venta, v.nro_venta, v.total_pagado, v.fyh_creacion AS fecha_venta,
               v.id_cliente, c.nombre_cliente, v.id_forma_pago, v.id_estado
        FROM tb_ventas v
        LEFT JOIN tb_clientes c ON v.id_cliente = c.id_cliente
        ORDER BY v.fyh_creacion DESC
    ");
    $stmt->execute();
    $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //Para cada venta, traer los productos desde tb_detalle_ventas
    $stmtDetalle = $pdo->prepare("
        SELECT d.id_detalle_venta, d.id_producto, a.nombre AS nombre_producto,
               d.cantidad, d.precio_unitario, d.subtotal
        FROM tb_detalle_ventas d
        LEFT JOIN tb_almacen a ON d.id_producto = a.id_producto
        WHERE d.id_venta = :id_venta
    ");

    foreach ($ventas as &$venta) {
        $stmtDetalle->execute([':id_venta' => $venta['id_venta']]);
        $venta['productos'] = $stmtDetalle->fetchAll(PDO::FETCH_ASSOC);
    }
    unset($venta); //buena practica

    //Respuesta final 
    echo json_encode([
        "status" => "success",
        "productos" => $productos,
        "clientes" => $clientes,
        "formas_pago" => $formas_pago,
        //kept 'data' con las ventas para compatibilidad con vistas antiguas
        "data" => $ventas
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Error en la API: " . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
