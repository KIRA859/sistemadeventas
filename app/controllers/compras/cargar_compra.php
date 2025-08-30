<?php
// Asegúrate de que config.php esté incluido para tener la conexión $pdo
if (!isset($pdo)) {
    include ('../../config.php');
}

// Obtener el ID de la compra desde la URL
$id_compra_get = $_GET['id'] ?? null;

// Asegurarse de que el ID de la compra esté presente
if (!$id_compra_get) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['mensaje'] = "Error: ID de compra no especificado.";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/compras/index.php');
    exit;
}


// Prepara la consulta SQL para obtener los detalles de una compra específica,
// incluyendo todos sus productos y la información del proveedor y el usuario que realizó la compra.
$sql_compra_detalle = "SELECT
                            co.id_compra,
                            co.nro_compra,
                            co.fecha_compra,
                            co.total_compra,
                            co.comprobante,
                            u_compra.nombres AS nombres_usuario_compra, -- Usuario que realizó la compra
                            pr.id_proveedor, -- ID del proveedor
                            pr.nombre_proveedor,
                            pr.celular AS celular_proveedor,
                            pr.telefono AS telefono_proveedor,
                            pr.empresa AS empresa_proveedor,
                            pr.email AS email_proveedor,
                            pr.direccion AS direccion_proveedor,
                            dc.id_detalle_compra,
                            dc.cantidad AS cantidad, -- <-- CLAVE CORREGIDA
                            dc.precio_unitario AS precio_unitario, -- <-- CLAVE CORREGIDA
                            dc.subtotal AS subtotal, -- <-- CLAVE CORREGIDA
                            a.id_producto,
                            a.codigo AS codigo, -- <-- CLAVE CORREGIDA
                            a.nombre AS nombre, -- <-- CLAVE CORREGIDA
                            a.descripcion AS descripcion_producto,
                            a.stock AS stock_actual_producto, -- Stock actual en almacén (no de esta compra)
                            a.stock_minimo AS stock_minimo_producto,
                            a.stock_maximo AS stock_maximo_producto,
                            a.precio_compra AS precio_compra_almacen, -- Precio de compra general del producto en almacén
                            a.precio_venta AS precio_venta_almacen, -- Precio de venta general del producto
                            a.fecha_ingreso AS fecha_ingreso_producto_almacen,
                            a.imagen AS imagen_producto,
                            cat.nombre_categoria,
                            u_prod.nombres AS nombre_usuario_registro_producto -- Usuario que registró el producto en almacén
                        FROM tb_compras AS co
                        INNER JOIN tb_usuarios AS u_compra ON co.id_usuario = u_compra.id_usuario
                        INNER JOIN tb_proveedores AS pr ON co.id_proveedor = pr.id_proveedor
                        INNER JOIN tb_detalle_compras AS dc ON co.id_compra = dc.id_compra
                        INNER JOIN tb_almacen AS a ON dc.id_producto = a.id_producto
                        INNER JOIN tb_categorias AS cat ON a.id_categoria = cat.id_categoria
                        INNER JOIN tb_usuarios AS u_prod ON a.id_usuario = u_prod.id_usuario
                        WHERE co.id_compra = :id_compra_get
                        ORDER BY dc.id_detalle_compra ASC"; // Ordena por ID de detalle para consistencia

$query_compra_detalle = $pdo->prepare($sql_compra_detalle);
$query_compra_detalle->bindParam(':id_compra_get', $id_compra_get, PDO::PARAM_INT);
$query_compra_detalle->execute();
$compra_datos_raw = $query_compra_detalle->fetchAll(PDO::FETCH_ASSOC);

// Estructura para almacenar los detalles de la compra
$compra_detalle = [
    'general' => [],
    'productos_en_compra' => []
];

if (!empty($compra_datos_raw)) {
    // Extraer los detalles generales de la compra (de la primera fila, ya que se repiten para cada producto)
    $first_row = $compra_datos_raw[0];
    $compra_detalle['general'] = [
        'id_compra' => $first_row['id_compra'],
        'nro_compra' => $first_row['nro_compra'],
        'fecha_compra' => $first_row['fecha_compra'],
        'total_compra' => $first_row['total_compra'],
        'comprobante' => $first_row['comprobante'],
        'nombres_usuario_compra' => $first_row['nombres_usuario_compra'],
        'id_proveedor' => $first_row['id_proveedor'],
        'nombre_proveedor' => $first_row['nombre_proveedor'],
        'celular_proveedor' => $first_row['celular_proveedor'],
        'telefono_proveedor' => $first_row['telefono_proveedor'],
        'empresa_proveedor' => $first_row['empresa_proveedor'],
        'email_proveedor' => $first_row['email_proveedor'],
        'direccion_proveedor' => $first_row['direccion_proveedor'],
    ];

    // Recorrer todas las filas para obtener los detalles de cada producto en la compra
    foreach ($compra_datos_raw as $producto_data) {
        $compra_detalle['productos_en_compra'][] = [
            'id_detalle_compra' => $producto_data['id_detalle_compra'],
            'id_producto' => $producto_data['id_producto'],
            // Las siguientes claves coinciden con lo que espera la vista
            'cantidad' => $producto_data['cantidad'], // <-- CORREGIDO
            'precio_unitario' => $producto_data['precio_unitario'], // <-- CORREGIDO
            'subtotal' => $producto_data['subtotal'], // <-- CORREGIDO
            'codigo' => $producto_data['codigo'], // <-- CORREGIDO
            'nombre' => $producto_data['nombre'], // <-- CORREGIDO
            // Otros datos que no se usan directamente en la tabla de show.php pero pueden ser útiles
            'descripcion_producto' => $producto_data['descripcion_producto'],
            'stock_actual_producto' => $producto_data['stock_actual_producto'],
            'stock_minimo_producto' => $producto_data['stock_minimo_producto'],
            'stock_maximo_producto' => $producto_data['stock_maximo_producto'],
            'precio_compra_almacen' => $producto_data['precio_compra_almacen'],
            'precio_venta_almacen' => $producto_data['precio_venta_almacen'],
            'fecha_ingreso_producto_almacen' => $producto_data['fecha_ingreso_producto_almacen'],
            'imagen_producto' => $producto_data['imagen_producto'],
            'nombre_categoria' => $producto_data['nombre_categoria'],
            'nombre_usuario_registro_producto' => $producto_data['nombre_usuario_registro_producto']
        ];
    }
} else {
    // Si no se encuentra la compra, puedes redirigir o mostrar un mensaje de error.
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['mensaje'] = "Error: No se encontró ninguna compra con el ID: " . htmlspecialchars($id_compra_get);
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/compras/index.php');
    exit;
}
?>