<?php

// Obtener el ID de la venta desde la URL. show.php lo enviará como 'id'.
$id_venta_get = $_GET['id'] ?? null;

// Validar que el ID de la venta sea un número entero y esté presente
if (!$id_venta_get || !is_numeric($id_venta_get)) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['mensaje'] = "Error: ID de venta no especificado o inválido para ver detalles. ❌";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/ventas/index.php'); // Redirige al listado de ventas
    exit;
}

// Estructura para almacenar los detalles de la venta de manera organizada
$venta_detalle = [
    'general' => [],
    'cliente' => [],
    'productos_en_venta' => []
];

try {
    // Consulta SQL para obtener los detalles completos de una venta, incluyendo:
    // - Información general de la venta (de tb_ventas)
    // - Datos del cliente (de tb_clientes)
    // - Detalles de los productos vendidos (de tb_detalle_ventas y tb_almacen)
    // - Nombre de la categoría del producto (de tb_categorias)
    // Nota: Se asume que id_usuario no está directamente en tb_ventas según tus consultas previas.
    // Por ello, 'nombres_usuario_venta' se setea a 'N/A' si no se puede obtener de otra tabla.
    $sql_venta_detalle = "SELECT
                            v.id_venta,
                            v.nro_venta,
                            v.fyh_creacion AS fecha_venta,
                            v.total_pagado,
                            v.fyh_actualizacion AS ultima_actualizacion_venta,
                            cl.id_cliente,
                            cl.nombre_cliente,
                            cl.nit_ci_cliente,
                            cl.celular_cliente,
                            cl.email_cliente,
                            fp.descripcion AS forma_pago,
                            es.descripcion AS estado_venta,
                            dv.id_detalle_venta,
                            dv.cantidad AS cantidad_producto_venta,
                            dv.precio_unitario AS precio_unitario_venta,
                            dv.subtotal AS subtotal_producto_venta,
                            a.id_producto,
                            a.codigo AS codigo_producto,
                            a.nombre AS nombre_producto,
                            a.descripcion AS descripcion_producto,
                            a.stock AS stock_actual_almacen,
                            a.precio_venta AS precio_venta_almacen,
                            a.imagen AS imagen_producto,
                            cat.nombre_categoria
                        FROM tb_ventas AS v
                        INNER JOIN tb_clientes AS cl ON v.id_cliente = cl.id_cliente
                        INNER JOIN tb_formas_pago AS fp ON v.id_forma_pago = fp.id_forma_pago
                        INNER JOIN tb_estados_venta AS es ON v.id_estado = es.id_estado
                        INNER JOIN tb_detalle_ventas AS dv ON v.id_venta = dv.id_venta
                        INNER JOIN tb_almacen AS a ON dv.id_producto = a.id_producto
                        INNER JOIN tb_categorias AS cat ON a.id_categoria = cat.id_categoria
                        WHERE v.id_venta = :id_venta_get
                        ORDER BY dv.id_detalle_venta ASC";

    $query_venta_detalle = $pdo->prepare($sql_venta_detalle);
    $query_venta_detalle->bindParam(':id_venta_get', $id_venta_get, PDO::PARAM_INT);
    $query_venta_detalle->execute();
    $venta_datos_raw = $query_venta_detalle->fetchAll(PDO::FETCH_ASSOC);

    // Si se encontraron datos, se organizan en la estructura $venta_detalle
    if (!empty($venta_datos_raw)) {
        $first_row = $venta_datos_raw[0]; // Tomamos la primera fila para datos generales y del cliente

        $venta_detalle['general'] = [
            'id_venta' => $first_row['id_venta'],
            'nro_venta' => $first_row['nro_venta'],
            'fecha_venta' => $first_row['fecha_venta'],
            'total_pagado' => $first_row['total_pagado'],
            'forma_pago' => $first_row['forma_pago'],
            'estado_venta' => $first_row['estado_venta'],
            'nombres_usuario_venta' => 'N/A', // Se muestra N/A ya que id_usuario no está en tb_ventas
            'ultima_actualizacion_venta' => $first_row['ultima_actualizacion_venta'],
        ];

        $venta_detalle['cliente'] = [
            'id_cliente' => $first_row['id_cliente'],
            'nombre_cliente' => $first_row['nombre_cliente'],
            'nit_ci_cliente' => $first_row['nit_ci_cliente'],
            'celular_cliente' => $first_row['celular_cliente'],
            'email_cliente' => $first_row['email_cliente'],
        ];

        // Recorrer todas las filas para obtener los detalles de cada producto
        foreach ($venta_datos_raw as $producto_data) {
            $venta_detalle['productos_en_venta'][] = [
                'id_detalle_venta' => $producto_data['id_detalle_venta'],
                'id_producto' => $producto_data['id_producto'],
                'cantidad_producto_venta' => $producto_data['cantidad_producto_venta'],
                'precio_unitario_venta' => $producto_data['precio_unitario_venta'],
                'subtotal_producto_venta' => $producto_data['subtotal_producto_venta'],
                'codigo_producto' => $producto_data['codigo_producto'],
                'nombre_producto' => $producto_data['nombre_producto'],
                'descripcion_producto' => $producto_data['descripcion_producto'],
                'stock_actual_almacen' => $producto_data['stock_actual_almacen'],
                'precio_venta_almacen' => $producto_data['precio_venta_almacen'],
                'imagen_producto' => $producto_data['imagen_producto'],
                'nombre_categoria' => $producto_data['nombre_categoria'],
            ];
        }
    } else {
        // Si no se encuentra la venta, redirige con un mensaje de error
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['mensaje'] = "Error: No se encontró la venta con ID: " . htmlspecialchars($id_venta_get) . " ❌";
        $_SESSION['icono'] = "error";
        header('Location: ' . $URL . '/ventas/index.php');
        exit;
    }

} catch (PDOException $e) {
    // Manejo de errores de base de datos
    error_log("Error PDO en cargar_venta.php: " . $e->getMessage()); // Para depuración en logs
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['mensaje'] = "Error en la base de datos al cargar la venta: " . $e->getMessage() . " ❌";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/ventas/index.php');
    exit;
}
?>
