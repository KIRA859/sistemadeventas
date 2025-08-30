<?php
include ('../../../app/config.php');
include ('../../../layout/sesion.php'); // Asumo que inicias la sesión aquí

// Validar que la solicitud sea POST y contenga el id_venta
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id_venta'])) {
    session_start();
    $_SESSION['mensaje'] = "Acceso no permitido.";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/ventas');
    exit;
}

$id_venta = filter_input(INPUT_POST, 'id_venta', FILTER_VALIDATE_INT);

// Iniciar transacción para asegurar la integridad de los datos
$pdo->beginTransaction();

try {
    // 1. Obtener los productos y cantidades del detalle de la venta (tb_detalle_ventas)
    $stmt_get_items = $pdo->prepare("SELECT id_producto, cantidad FROM tb_detalle_ventas WHERE id_venta = :id_venta");
    $stmt_get_items->bindParam(':id_venta', $id_venta, PDO::PARAM_INT);
    $stmt_get_items->execute();
    $items_venta = $stmt_get_items->fetchAll(PDO::FETCH_ASSOC);

    // 2. Devolver el stock a la tabla de productos (tb_almacen)
    $stmt_update_stock = $pdo->prepare("UPDATE tb_almacen SET stock = stock + :cantidad WHERE id_producto = :id_producto");
    foreach ($items_venta as $item) {
        $stmt_update_stock->bindParam(':cantidad', $item['cantidad'], PDO::PARAM_INT);
        $stmt_update_stock->bindParam(':id_producto', $item['id_producto'], PDO::PARAM_INT);
        $stmt_update_stock->execute();
    }
    
    // 3. Eliminar la venta de la tabla principal (tb_ventas).
    // Gracias a 'ON DELETE CASCADE' en tu base de datos, esto borrará automáticamente
    // los registros relacionados en 'tb_detalle_ventas'.
    $stmt_delete_venta = $pdo->prepare("DELETE FROM tb_ventas WHERE id_venta = :id_venta");
    $stmt_delete_venta->bindParam(':id_venta', $id_venta, PDO::PARAM_INT);
    $stmt_delete_venta->execute();

    // 4. Si todo fue bien, confirmar la transacción
    $pdo->commit();
    
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    $_SESSION['mensaje'] = "La venta se eliminó correctamente y el stock fue restaurado.";
    $_SESSION['icono'] = "success";
    header('Location: ' . $URL . '/ventas');
    exit;

} catch (Exception $e) {
    // Si algo falla, revertir todos los cambios
    $pdo->rollBack();

    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    $_SESSION['mensaje'] = "Error: No se pudo eliminar la venta. " . $e->getMessage();
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/ventas');
    exit;
}
?>