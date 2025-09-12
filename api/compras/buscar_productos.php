<?php

include('../../app/config.php'); 
header('Content-Type: application/json');

// Verificar si se ha enviado el id_producto
if (isset($_GET['id_producto'])) {
    $id_producto = $_GET['id_producto'];

    // Consulta SQL para seleccionar todos los campos de la tabla tb_almacen
    $sentencia = $pdo->prepare("SELECT 
    al.id_producto, al.codigo, al.nombre, al.descripcion,
    al.stock, al.stock_minimo, al.stock_maximo,
    al.precio_compra, al.precio_venta, 
    al.fecha_ingreso, 
    al.imagen, 
    cat.nombre_categoria as categoria, 
    usu.nombres as nombres_usuario
    FROM tb_almacen AS al
    JOIN tb_categorias AS cat ON al.id_categoria = cat.id_categoria
    JOIN tb_usuarios AS usu ON al.id_usuario = usu.id_usuario
    WHERE al.id_producto = :id_producto AND al.activo = '1'");

    // Vincular el parámetro y ejecutar la consulta
    $sentencia->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
    $sentencia->execute();

    // Obtener los datos del producto
    $producto = $sentencia->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontró el producto
    if ($producto) {
        $response = [
            'status' => 'success',
            'message' => 'Producto encontrado.',
            'data' => $producto
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Producto no encontrado.'
        ];
    }
    echo json_encode($response);
} else {
    // Si no se proporcionó el id_producto
    $response = [
        'status' => 'error',
        'message' => 'Falta el parámetro id_producto.'
    ];
    echo json_encode($response);
}
