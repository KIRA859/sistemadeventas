<?php
include ('../../app/config.php');

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

try {
    $sql = "SELECT 
                mov.id_movimiento,
                mov.id_producto,
                prod.nombre AS producto_nombre,
                mov.tipo_movimiento,
                mov.cantidad,
                mov.descripcion,
                mov.fecha_movimiento,
                usr.email AS usuario_email
            FROM 
                tb_movimientos_inventario AS mov
            LEFT JOIN 
                tb_almacen AS prod ON mov.id_producto = prod.id_producto
            LEFT JOIN 
                tb_usuarios AS usr ON mov.id_usuario = usr.id_usuario
            ORDER BY 
                mov.fecha_movimiento DESC";

    $sentencia = $pdo->prepare($sql);
    $sentencia->execute();
    
    // Obtenemos todos los resultados
    $movimientos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $movimientos
    ]);

} catch (Exception $e) {
    //En caso de algun error
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error en el servidor: ' . $e->getMessage()
    ]);
}
?>