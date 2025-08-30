<?php
include ('../../config.php');
include ('../../layout/sesion.php');
include ('../../app/controllers/usuarios/verificar_sesion.php');

// Obtener los datos del formulario POST
$nro_venta = $_POST['nro_venta'] ?? null;
$fecha_venta = $_POST['fecha_venta'] ?? null;
$id_cliente = $_POST['id_cliente'] ?? null;
$id_forma_pago = $_POST['id_forma_pago'] ?? 1; // Default a Efectivo si no se envía
$id_estado = $_POST['id_estado'] ?? 1; // Default a Pendiente si no se envía
$total_pagado = $_POST['total_pagado_final'] ?? 0.00; // Total calculado desde PHP/JS de la tabla carrito
$monto_recibido = $_POST['monto_recibido'] ?? 0.00; // Monto que el cliente entrega
$id_usuario = $_POST['id_usuario'] ?? null; // ID del usuario que registra la venta (desde sesión)

$fyh_creacion = date('Y-m-d H:i:s');
$fyh_actualizacion = date('Y-m-d H:i:s'); // Puede ser NULL o la misma fecha al inicio

// --- INICIO DEPURACIÓN PHP (create.php) ---
error_log("create.php - Datos recibidos del formulario POST:");
error_log("nro_venta: " . var_export($nro_venta, true));
error_log("fecha_venta: " . var_export($fecha_venta, true));
error_log("id_cliente: " . var_export($id_cliente, true));
error_log("id_forma_pago: " . var_export($id_forma_pago, true));
error_log("id_estado: " . var_export($id_estado, true));
error_log("total_pagado: " . var_export($total_pagado, true));
error_log("monto_recibido: " . var_export($monto_recibido, true));
error_log("id_usuario: " . var_export($id_usuario, true));
// --- FIN DEPURACIÓN PHP ---


// Validaciones básicas antes de proceder con la BD
if (!$id_usuario || !$id_cliente || empty($nro_venta)) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['mensaje'] = "Error: Faltan datos esenciales para registrar la venta (usuario, cliente o número de venta).";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/ventas/create.php');
    exit;
}

// Validar que el monto recibido sea suficiente
if ($monto_recibido < $total_pagado) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['mensaje'] = "Error: El monto recibido es insuficiente para cubrir el total de la venta.";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/ventas/create.php');
    exit;
}

try {
    // Iniciar transacción para asegurar atomicidad
    $pdo->beginTransaction();
    error_log("create.php - Transacción iniciada.");

    // 1. Obtener los productos del carrito temporal para este nro_venta
    $sql_productos_carrito = "SELECT carr.id_producto, carr.cantidad, pro.precio_venta, pro.stock as stock_actual_almacen FROM tb_carrito AS carr
                            INNER JOIN tb_almacen AS pro ON carr.id_producto = pro.id_producto
                            WHERE carr.nro_venta = :nro_venta";
    $query_productos_carrito = $pdo->prepare($sql_productos_carrito);
    $query_productos_carrito->bindParam(':nro_venta', $nro_venta, PDO::PARAM_INT);
    $query_productos_carrito->execute();
    $productos_vendidos = $query_productos_carrito->fetchAll(PDO::FETCH_ASSOC);

    if (empty($productos_vendidos)) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['mensaje'] = "Error: No hay productos en el carrito para registrar la venta.";
        $_SESSION['icono'] = "error";
        header('Location: ' . $URL . '/ventas/create.php');
        exit;
    }
    error_log("create.php - Productos del carrito obtenidos: " . count($productos_vendidos) . " items.");


    // 2. Insertar la venta principal en tb_ventas
    $sql_ventas = "INSERT INTO tb_ventas (nro_venta, id_cliente, id_forma_pago, id_estado, total_pagado, fyh_creacion, fyh_actualizacion)
                    VALUES (:nro_venta, :id_cliente, :id_forma_pago, :id_estado, :total_pagado, :fyh_creacion, :fyh_actualizacion)";

    $query_ventas = $pdo->prepare($sql_ventas);
    $query_ventas->bindParam(':nro_venta', $nro_venta, PDO::PARAM_INT);
    $query_ventas->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
    $query_ventas->bindParam(':id_forma_pago', $id_forma_pago, PDO::PARAM_INT);
    $query_ventas->bindParam(':id_estado', $id_estado, PDO::PARAM_INT);
    $query_ventas->bindParam(':total_pagado', $total_pagado); // DECIMAL
    $query_ventas->bindParam(':fyh_creacion', $fyh_creacion, PDO::PARAM_STR);
    $query_ventas->bindParam(':fyh_actualizacion', $fyh_creacion, PDO::PARAM_STR);

    $query_ventas->execute();
    $id_nueva_venta = $pdo->lastInsertId(); // Obtener el ID de la venta recién insertada
    error_log("create.php - Venta principal insertada con ID: " . $id_nueva_venta);


    // 3. Insertar detalles de productos en tb_detalle_ventas y actualizar stock/movimientos
    foreach ($productos_vendidos as $producto) {
        $id_producto_actual = (int)$producto['id_producto'];
        $cantidad_vendida = (int)$producto['cantidad'];
        $precio_unitario_venta = (float)$producto['precio_venta'];
        $subtotal_detalle = $cantidad_vendida * $precio_unitario_venta;
        $stock_actual_almacen = (int)$producto['stock_actual_almacen'];

        // Pre-validación de stock por si acaso (aunque ya se hizo en registrar_carrito)
        if ($cantidad_vendida > $stock_actual_almacen) {
            $pdo->rollBack();
            if (session_status() == PHP_SESSION_NONE) { session_start(); }
            $_SESSION['mensaje'] = "Error: Stock insuficiente para el producto ID " . $id_producto_actual . ". Se intentó vender " . $cantidad_vendida . " pero solo quedan " . $stock_actual_almacen . ".";
            $_SESSION['icono'] = "error";
            header('Location: ' . $URL . '/ventas/create.php');
            exit;
        }

        // Insertar en tb_detalle_ventas
        $sql_detalle = "INSERT INTO tb_detalle_ventas (id_venta, id_producto, cantidad, precio_unitario, subtotal)
                        VALUES (:id_venta, :id_producto, :cantidad, :precio_unitario, :subtotal)";
        $query_detalle = $pdo->prepare($sql_detalle);
        $query_detalle->bindParam(':id_venta', $id_nueva_venta, PDO::PARAM_INT);
        $query_detalle->bindParam(':id_producto', $id_producto_actual, PDO::PARAM_INT);
        $query_detalle->bindParam(':cantidad', $cantidad_vendida, PDO::PARAM_INT);
        $query_detalle->bindParam(':precio_unitario', $precio_unitario_venta);
        $query_detalle->bindParam(':subtotal', $subtotal_detalle);
        $query_detalle->execute();
        error_log("create.php - Detalle de venta insertado para producto ID " . $id_producto_actual);

        // 4. Actualizar stock en tb_almacen (RESTAR stock)
        $sql_update_stock = "UPDATE tb_almacen SET stock = stock - :cantidad, fyh_actualizacion = :fyh_actualizacion WHERE id_producto = :id_producto";
        $query_update_stock = $pdo->prepare($sql_update_stock);
        $query_update_stock->bindParam(':cantidad', $cantidad_vendida, PDO::PARAM_INT);
        $query_update_stock->bindParam(':fyh_actualizacion', $fyh_creacion, PDO::PARAM_STR);
        $query_update_stock->bindParam(':id_producto', $id_producto_actual, PDO::PARAM_INT);
        $query_update_stock->execute();
        error_log("create.php - Stock actualizado para producto ID " . $id_producto_actual);


        // 5. Registrar movimiento en tb_movimientos_inventario (tipo SALIDA)
        $sql_nombre_producto = "SELECT nombre FROM tb_almacen WHERE id_producto = :id_producto";
        $query_nombre_producto = $pdo->prepare($sql_nombre_producto);
        $query_nombre_producto->bindParam(':id_producto', $id_producto_actual, PDO::PARAM_INT);
        $query_nombre_producto->execute();
        $nombre_producto = $query_nombre_producto->fetchColumn();

        $descripcion_movimiento = "Salida por venta #{$nro_venta} (Producto: {$nombre_producto})";
        $sql_movimiento = "INSERT INTO tb_movimientos_inventario (id_producto, tipo_movimiento, cantidad, descripcion, fecha_movimiento, id_usuario)
                           VALUES (:id_producto, 'SALIDA', :cantidad, :descripcion, :fecha_movimiento, :id_usuario)";
        $query_movimiento = $pdo->prepare($sql_movimiento);
        $query_movimiento->bindParam(':id_producto', $id_producto_actual, PDO::PARAM_INT);
        $query_movimiento->bindParam(':cantidad', $cantidad_vendida, PDO::PARAM_INT);
        $query_movimiento->bindParam(':descripcion', $descripcion_movimiento, PDO::PARAM_STR);
        $query_movimiento->bindParam(':fecha_movimiento', $fyh_creacion, PDO::PARAM_STR);
        $query_movimiento->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $query_movimiento->execute();
        error_log("create.php - Movimiento de inventario registrado para producto ID " . $id_producto_actual);

    }

    // 6. Vaciar el carrito temporal para esta nro_venta
    $sql_vaciar_carrito = "DELETE FROM tb_carrito WHERE nro_venta = :nro_venta";
    $query_vaciar_carrito = $pdo->prepare($sql_vaciar_carrito);
    $query_vaciar_carrito->bindParam(':nro_venta', $nro_venta, PDO::PARAM_INT);
    $query_vaciar_carrito->execute();
    error_log("create.php - Carrito temporal vaciado para nro_venta: " . $nro_venta);

    // Confirmar transacción
    $pdo->commit();
    error_log("create.php - Transacción confirmada exitosamente.");

    if (session_status() == PHP_SESSION_NONE) { session_start(); }
    $_SESSION['mensaje'] = "La venta se ha registrado exitosamente. 🎉 Cambio a devolver: " . number_format($monto_recibido - $total_pagado, 2);
    $_SESSION['icono'] = "success";
    // Redirige al detalle de la venta (necesitarás crear ventas/show.php)
    header('Location: ' . $URL . '/ventas/show.php?id=' . $id_nueva_venta);
    exit;

} catch (PDOException $e) {
    // Revertir transacción en caso de error
    $pdo->rollBack();
    error_log("create.php - Transacción revertida debido a un error: " . $e->getMessage());
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['mensaje'] = "Error al registrar la venta: " . $e->getMessage() . " ❌";
    $_SESSION['icono'] = "error";
    error_log("Error al registrar venta: " . $e->getMessage());
    header('Location: ' . $URL . '/ventas/create.php'); // Redirige de vuelta a la creación con el error
    exit;
}
?>
