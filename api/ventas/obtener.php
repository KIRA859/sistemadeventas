<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '../../../app/config.php';

// Validar que la solicitud sea un método GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(["status" => "error", "message" => "Método no permitido. Solo se acepta GET."]);
    exit;
}

$id_venta = isset($_GET['id_venta']) ? intval($_GET['id_venta']) : 0;
if ($id_venta <= 0) {
    echo json_encode(["status" => "error", "message" => "ID de venta inválido"]);
    exit;
}

try {
    // Cabecera venta
    $sql = "SELECT v.id_venta, v.nro_venta, v.total_pagado, v.fyh_creacion,
                   c.nombre_cliente, c.nit_ci_cliente, c.celular_cliente,
                   fp.nombre_forma_pago
            FROM tb_ventas v
            LEFT JOIN tb_clientes c ON v.id_cliente = c.id_cliente
            LEFT JOIN tb_formas_pago fp ON v.id_forma_pago = fp.id_forma_pago
            WHERE v.id_venta = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":id" => $id_venta]);
    $venta = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$venta) {
        echo json_encode(["status" => "error", "message" => "Venta no encontrada"]);
        exit;
    }

    // Detalle
    $sqlDet = "SELECT d.id_producto, a.nombre, d.cantidad, d.precio_unitario, d.subtotal
               FROM tb_detalle_ventas d
               INNER JOIN tb_almacen a ON d.id_producto = a.id_producto
               WHERE d.id_venta = :id_venta";
    $stmt = $pdo->prepare($sqlDet);
    $stmt->execute([":id_venta" => $id_venta]);
    $detalle = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => "success",
        "venta" => $venta,
        "detalle" => $detalle
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
