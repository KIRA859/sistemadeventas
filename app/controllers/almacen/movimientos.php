<?php

try {
    // Consulta con JOIN para traer datos relacionados
    $sql_movimientos = "SELECT 
                            m.id_movimiento,
                            m.id_producto,
                            p.nombre,
                            m.tipo_movimiento,
                            m.cantidad,
                            m.descripcion,
                            m.fecha_movimiento,
                            m.id_usuario,
                            u.email as usuario_email
                        FROM tb_movimientos_inventario m
                        INNER JOIN tb_almacen p ON m.id_producto = p.id_producto
                        INNER JOIN tb_usuarios u ON m.id_usuario = u.id_usuario
                        ORDER BY m.fecha_movimiento DESC";

    $query_movimientos = $pdo->prepare($sql_movimientos);
    $query_movimientos->execute();
    $movimientos_datos = $query_movimientos->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error al obtener los movimientos: " . $e->getMessage();
    $movimientos_datos = [];
}
