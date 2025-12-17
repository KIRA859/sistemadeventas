<?php
include('../../app/config.php'); 

header('Content-Type: application/json');

try {
    // Traer productos activos con toda la información
    $sql = "SELECT 
                al.id_producto,
                al.codigo,
                al.nombre,
                al.descripcion,
                al.stock,
                al.stock_minimo,
                al.stock_maximo,
                al.precio_compra,
                al.precio_venta,
                al.fecha_ingreso,
                al.imagen,
                cat.nombre_categoria AS categoria,
                usu.nombres AS nombres_usuario
            FROM tb_almacen AS al
            JOIN tb_categorias AS cat ON al.id_categoria = cat.id_categoria
            JOIN tb_usuarios AS usu ON al.id_usuario = usu.id_usuario
            WHERE al.activo = 1";

    $stmt = $pdo->query($sql);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($productos);
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Error al obtener productos: " . $e->getMessage()
    ]);
}
