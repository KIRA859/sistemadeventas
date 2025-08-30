<?php
include ('../../config.php');

// Obtener los datos enviados por AJAX (GET en este caso)
$nro_venta = $_GET['nro_venta'] ?? null;
$id_producto = $_GET['id_producto'] ?? null;
$cantidad = $_GET['cantidad'] ?? null;

$fyh_creacion = date('Y-m-d H:i:s');
$fyh_actualizacion = date('Y-m-d H:i:s');

// --- INICIO DEPURACIÓN PHP (registrar_carrito.php) ---
// Estos mensajes aparecerán en el archivo de error de tu servidor web (e.g., error.log de Apache)
error_log("registrar_carrito.php - Valores recibidos:");
error_log("nro_venta: " . var_export($nro_venta, true));
error_log("id_producto: " . var_export($id_producto, true));
error_log("cantidad: " . var_export($cantidad, true));
// --- FIN DEPURACIÓN PHP ---

// Validaciones básicas
if (!$nro_venta || !$id_producto || !$cantidad || !is_numeric($cantidad) || $cantidad <= 0) {
    http_response_code(400); // Bad Request
    echo "Error: Faltan datos o son inválidos para añadir al carrito. nro_venta: " . var_export($nro_venta, true) . ", id_producto: " . var_export($id_producto, true) . ", cantidad: " . var_export($cantidad, true);
    exit;
}

try {
    // Convertir a tipos numéricos para seguridad
    $nro_venta = (int) $nro_venta;
    $id_producto = (int) $id_producto;
    $cantidad = (int) $cantidad;

    // Verificar si el producto ya existe en el carrito para esta nro_venta
    $sql_verificar_carrito = "SELECT * FROM tb_carrito WHERE nro_venta = :nro_venta AND id_producto = :id_producto";
    $query_verificar_carrito = $pdo->prepare($sql_verificar_carrito);
    $query_verificar_carrito->bindParam(':nro_venta', $nro_venta, PDO::PARAM_INT);
    $query_verificar_carrito->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
    $query_verificar_carrito->execute();
    $producto_en_carrito = $query_verificar_carrito->fetch(PDO::FETCH_ASSOC);

    if ($producto_en_carrito) {
        // Si el producto ya existe, actualizar la cantidad
        $nueva_cantidad = $producto_en_carrito['cantidad'] + $cantidad;

        // Validar stock disponible antes de actualizar
        $sql_stock = "SELECT stock FROM tb_almacen WHERE id_producto = :id_producto";
        $query_stock = $pdo->prepare($sql_stock);
        $query_stock->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
        $query_stock->execute();
        $stock_actual = $query_stock->fetchColumn();

        if ($nueva_cantidad > $stock_actual) {
            http_response_code(400);
            echo "Error: Cantidad total (" . $nueva_cantidad . ") excede el stock disponible (" . $stock_actual . ").";
            exit;
        }

        $sql_update_carrito = "UPDATE tb_carrito SET cantidad = :cantidad, fyh_actualizacion = :fyh_actualizacion
                               WHERE nro_venta = :nro_venta AND id_producto = :id_producto";
        $query_update_carrito = $pdo->prepare($sql_update_carrito);
        $query_update_carrito->bindParam(':cantidad', $nueva_cantidad, PDO::PARAM_INT);
        $query_update_carrito->bindParam(':fyh_actualizacion', $fyh_actualizacion, PDO::PARAM_STR);
        $query_update_carrito->bindParam(':nro_venta', $nro_venta, PDO::PARAM_INT);
        $query_update_carrito->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
        $query_update_carrito->execute();
        echo "Producto actualizado en el carrito exitosamente.";

    } else {
        // Validar stock disponible antes de insertar
        $sql_stock = "SELECT stock FROM tb_almacen WHERE id_producto = :id_producto";
        $query_stock = $pdo->prepare($sql_stock);
        $query_stock->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
        $query_stock->execute();
        $stock_actual = $query_stock->fetchColumn();

        if ($cantidad > $stock_actual) {
            http_response_code(400);
            echo "Error: Cantidad solicitada (" . $cantidad . ") excede el stock disponible (" . $stock_actual . ").";
            exit;
        }

        // Si el producto no existe, insertarlo
        $sql_insert_carrito = "INSERT INTO tb_carrito (id_producto, nro_venta, cantidad, fyh_creacion, fyh_actualizacion)
                               VALUES (:id_producto, :nro_venta, :cantidad, :fyh_creacion, :fyh_actualizacion)";
        $query_insert_carrito = $pdo->prepare($sql_insert_carrito);
        $query_insert_carrito->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
        $query_insert_carrito->bindParam(':nro_venta', $nro_venta, PDO::PARAM_INT);
        $query_insert_carrito->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $query_insert_carrito->bindParam(':fyh_creacion', $fyh_creacion, PDO::PARAM_STR);
        $query_insert_carrito->bindParam(':fyh_actualizacion', $fyh_actualizacion, PDO::PARAM_STR);
        $query_insert_carrito->execute();
        echo "Producto añadido al carrito exitosamente.";
    }

} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    error_log("Error PDO en registrar_carrito.php: " . $e->getMessage());
    echo "Error en la base de datos: " . $e->getMessage();
}
?>
