<?php
include('../../app/config.php');
header("Content-Type: application/json; charset=UTF-8");

try {
    $sql = "SELECT 
                c.id_compra,
                c.nro_compra,
                c.fecha_compra,
                c.comprobante,
                c.total_compra,
                p.id_proveedor,
                p.nombre_proveedor,
                u.nombres AS nombres_usuario_compra,
                d.id_producto,
                a.nombre AS nombre_producto,
                a.codigo AS codigo_producto,
                d.cantidad,
                d.precio_unitario
            FROM tb_compras c
            INNER JOIN tb_proveedores p ON c.id_proveedor = p.id_proveedor
            INNER JOIN tb_usuarios u ON c.id_usuario = u.id_usuario
            INNER JOIN tb_detalle_compras d ON c.id_compra = d.id_compra
            INNER JOIN tb_almacen a ON d.id_producto = a.id_producto
            ORDER BY c.fecha_compra DESC";
    
    $stmt = $pdo->query($sql);
    $compras = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($compras ?: []);
} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
