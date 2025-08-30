<?php


// Prepara la consulta SQL para obtener el listado de compras con todos sus detalles.
// Ahora se une a tb_detalle_compras (dc) para obtener los productos de cada compra,
// y luego a tb_almacen (a), tb_categorias (cat) y tb_usuarios (u_prod) para los detalles del producto.
$sql_compras = "SELECT
                    co.id_compra,
                    co.nro_compra,
                    co.fecha_compra,
                    co.total_compra,
                    co.comprobante,
                    co.fyh_creacion AS fecha_registro_compra,
                    pr.nombre_proveedor,
                    pr.celular AS celular_proveedor,
                    pr.telefono AS telefono_proveedor,
                    pr.empresa AS empresa_proveedor,
                    pr.email AS email_proveedor,
                    pr.direccion AS direccion_proveedor,
                    u.nombres AS nombres_usuario_compra, -- Usuario que realizó la compra
                    dc.cantidad,
                    dc.precio_unitario, -- Precio de compra unitario para este detalle
                    dc.subtotal,
                    a.codigo AS codigo_producto,
                    a.nombre AS nombre_producto,
                    a.descripcion AS descripcion_producto,
                    a.stock AS stock_actual_producto,
                    a.stock_minimo AS stock_minimo_producto,
                    a.stock_maximo AS stock_maximo_producto,
                    a.precio_venta AS precio_venta_producto,
                    a.fecha_ingreso AS fecha_ingreso_producto,
                    a.imagen AS imagen_producto,
                    cat.nombre_categoria,
                    u_prod.nombres AS nombre_usuario_registro_producto -- Usuario que registró el producto en almacén
                FROM
                    tb_compras AS co
                INNER JOIN
                    tb_proveedores AS pr ON co.id_proveedor = pr.id_proveedor
                INNER JOIN
                    tb_usuarios AS u ON co.id_usuario = u.id_usuario
                INNER JOIN
                    tb_detalle_compras AS dc ON co.id_compra = dc.id_compra -- Unión clave para los detalles de los productos
                INNER JOIN
                    tb_almacen AS a ON dc.id_producto = a.id_producto     -- Obtener detalles del producto
                INNER JOIN
                    tb_categorias AS cat ON a.id_categoria = cat.id_categoria -- Obtener nombre de categoría del producto
                INNER JOIN
                    tb_usuarios AS u_prod ON a.id_usuario = u_prod.id_usuario -- Obtener usuario que registró el producto
                ORDER BY
                    co.nro_compra DESC";

$query_compras = $pdo->prepare($sql_compras);
$query_compras->execute();

$compras_datos = $query_compras->fetchAll(PDO::FETCH_ASSOC);


$compras_agrupadas = [];
foreach ($compras_datos as $item) {
    $compra_id = $item['id_compra'];
    if (!isset($compras_agrupadas[$compra_id])) {
        $compras_agrupadas[$compra_id] = [
            'id_compra' => $item['id_compra'],
            'nro_compra' => $item['nro_compra'],
            'fecha_compra' => $item['fecha_compra'],
            'total_compra' => $item['total_compra'],
            'comprobante' => $item['comprobante'],
            'fecha_registro_compra' => $item['fecha_registro_compra'],
            'nombre_proveedor' => $item['nombre_proveedor'],
            'celular_proveedor' => $item['celular_proveedor'],
            'telefono_proveedor' => $item['telefono_proveedor'],
            'empresa_proveedor' => $item['empresa_proveedor'],
            'email_proveedor' => $item['email_proveedor'],
            'direccion_proveedor' => $item['direccion_proveedor'],
            'nombres_usuario_compra' => $item['nombres_usuario_compra'],
            'productos' => []
        ];
    }
    $compras_agrupadas[$compra_id]['productos'][] = [
        'cantidad' => $item['cantidad'],
        'precio_unitario' => $item['precio_unitario'],
        'subtotal' => $item['subtotal'],
        'codigo_producto' => $item['codigo_producto'],
        'nombre_producto' => $item['nombre_producto'],
        'descripcion_producto' => $item['descripcion_producto'],
        'stock_actual_producto' => $item['stock_actual_producto'],
        'stock_minimo_producto' => $item['stock_minimo_producto'],
        'stock_maximo_producto' => $item['stock_maximo_producto'],
        'precio_venta_producto' => $item['precio_venta_producto'],
        'fecha_ingreso_producto' => $item['fecha_ingreso_producto'],
        'imagen_producto' => $item['imagen_producto'],
        'nombre_categoria' => $item['nombre_categoria'],
        'nombre_usuario_registro_producto' => $item['nombre_usuario_registro_producto']
    ];
}



?>

