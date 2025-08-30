<?php
include ('../../config.php');

$nro_venta = $_GET['nro_venta'];
$id_cliente = $_GET['id_cliente'];
$total_cancelar = $_GET['total_cancelar'];

try {
    $pdo->beginTransaction();

    // 1. Insertar la venta
    $sentencia = $pdo->prepare("INSERT INTO tb_ventas
        (nro_venta, id_cliente, total_pagado, fyh_creacion) 
        VALUES (:nro_venta, :id_cliente, :total_pagado, :fyh_creacion)");

    $sentencia->bindParam(':nro_venta', $nro_venta);
    $sentencia->bindParam(':id_cliente', $id_cliente);
    $sentencia->bindParam(':total_pagado', $total_cancelar);
    $sentencia->bindParam(':fyh_creacion', $fechaHora);

    if ($sentencia->execute()) {
        // 2. Obtener el ID de la venta recién creada
        $id_venta = $pdo->lastInsertId();

        // 3. Traer los productos del carrito
        $sql_carrito = "SELECT * FROM tb_carrito WHERE nro_venta = :nro_venta";
        $query_carrito = $pdo->prepare($sql_carrito);
        $query_carrito->bindParam(':nro_venta', $nro_venta);
        $query_carrito->execute();
        $carrito_datos = $query_carrito->fetchAll(PDO::FETCH_ASSOC);

        // 4. Insertar cada producto en tb_detalle_ventas
        foreach ($carrito_datos as $carrito) {
            $id_producto = $carrito['id_producto'];
            $cantidad = $carrito['cantidad'];

            // Obtener el precio actual del producto
            $sql_precio = "SELECT precio_venta FROM tb_almacen WHERE id_producto = :id_producto";
            $query_precio = $pdo->prepare($sql_precio);
            $query_precio->bindParam(':id_producto', $id_producto);
            $query_precio->execute();
            $precio = $query_precio->fetch(PDO::FETCH_ASSOC);
            $precio_unitario = $precio ? $precio['precio_venta'] : 0;

            $subtotal = $cantidad * $precio_unitario;

            $sql_detalle = "INSERT INTO tb_detalle_ventas 
                (id_venta, id_producto, cantidad, precio_unitario, subtotal) 
                VALUES (:id_venta, :id_producto, :cantidad, :precio_unitario, :subtotal)";
            $query_detalle = $pdo->prepare($sql_detalle);
            $query_detalle->bindParam(':id_venta', $id_venta);
            $query_detalle->bindParam(':id_producto', $id_producto);
            $query_detalle->bindParam(':cantidad', $cantidad);
            $query_detalle->bindParam(':precio_unitario', $precio_unitario);
            $query_detalle->bindParam(':subtotal', $subtotal);
            $query_detalle->execute();
        }

        // 5. Vaciar el carrito de esa venta
        $sql_delete = "DELETE FROM tb_carrito WHERE nro_venta = :nro_venta";
        $query_delete = $pdo->prepare($sql_delete);
        $query_delete->bindParam(':nro_venta', $nro_venta);
        $query_delete->execute();

        $pdo->commit();

        session_start();
        $_SESSION['mensaje'] = "✅ Se registró la venta y sus detalles correctamente";
        $_SESSION['icono'] = "success";
        ?>
        <script>
            location.href = "<?php echo $URL;?>/ventas/detalle_venta.php?id_venta=<?php echo $id_venta; ?>";
        </script>
        <?php
    } else {
        throw new Exception("Error al registrar la venta");
    }

} catch (Exception $e) {
    $pdo->rollBack();
    session_start();
    $_SESSION['mensaje'] = "❌ Error: " . $e->getMessage();
    $_SESSION['icono'] = "error";
    ?>
    <script>
        location.href = "<?php echo $URL;?>/ventas/create.php";
    </script>
    <?php
}


