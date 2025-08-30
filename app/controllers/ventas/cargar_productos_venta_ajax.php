<?php
include ('../../../app/config.php');

header('Content-Type: application/json');

// Validar que el id_venta fue proporcionado
if (!isset($_GET['id_venta'])) {
    echo json_encode(['status' => 'error', 'message' => 'ID de venta no proporcionado.']);
    exit;
}

$id_venta = filter_input(INPUT_GET, 'id_venta', FILTER_VALIDATE_INT);

if ($id_venta === false) {
    echo json_encode(['status' => 'error', 'message' => 'ID de venta inválido.']);
    exit;
}

try {
    // CORRECCIÓN: Unimos tb_detalle_ventas con tb_almacen para obtener los datos del producto.
    // Esta es la forma correcta de obtener los productos de una venta ya guardada.
    $sql_productos = "
        SELECT 
            a.nombre as nombre_producto,
            a.descripcion as descripcion_producto,
            dv.cantidad as cantidad,
            dv.precio_unitario as precio_unitario
        FROM 
            tb_detalle_ventas as dv
        INNER JOIN
            tb_almacen as a ON dv.id_producto = a.id_producto
        WHERE 
            dv.id_venta = :id_venta
    ";
    
    $query_productos = $pdo->prepare($sql_productos);
    $query_productos->bindParam(':id_venta', $id_venta, PDO::PARAM_INT);
    $query_productos->execute();
    
    $productos = $query_productos->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['status' => 'success', 'data' => $productos]);

} catch (PDOException $e) {
    // En caso de error en la base de datos, devolver un JSON de error
    error_log("Error en AJAX: " . $e->getMessage()); // Guardar error real para depuración
    echo json_encode(['status' => 'error', 'message' => 'Error al consultar la base de datos.']);
}

?>