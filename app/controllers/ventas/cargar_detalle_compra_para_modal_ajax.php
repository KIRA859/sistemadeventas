<?php
// Incluimos la configuración principal y la sesión
// Asegúrate de que las rutas son correctas desde la perspectiva de este archivo
require_once('../../config.php'); // Asume que config.php está en app/
require_once('../../layout/sesion.php'); // Asume que sesion.php está en app/layout/

header('Content-Type: application/json'); // Indicar que la respuesta es JSON

$response = [
    'status' => 'error',
    'message' => 'Ocurrió un error desconocido.',
    'general' => [],
    'productos_en_compra' => []
];

if (isset($_GET['id'])) {
    $id_compra_get = (int)$_GET['id'];

    try {
        // Prepara la consulta SQL para obtener los detalles de una compra específica,
        // incluyendo todos sus productos y la información del proveedor y el usuario que realizó la compra.
        $sql_compra_detalle = "SELECT
                                co.id_compra,
                                co.nro_compra,
                                co.fecha_compra,
                                co.total_compra,
                                co.comprobante,
                                u_compra.nombres AS nombres_usuario_compra,
                                pr.nombre_proveedor,
                                pr.celular AS celular_proveedor,
                                pr.telefono AS telefono_proveedor,
                                pr.empresa AS empresa_proveedor,
                                pr.email AS email_proveedor,
                                pr.direccion AS direccion_proveedor,
                                dc.id_detalle_compra,
                                dc.cantidad AS cantidad_producto_compra,
                                dc.precio_unitario AS precio_unitario_compra,
                                dc.subtotal AS subtotal_producto_compra,
                                a.id_producto,
                                a.codigo AS codigo_producto,
                                a.nombre AS nombre_producto,
                                a.descripcion AS descripcion_producto,
                                a.stock AS stock_actual_producto,
                                a.stock_minimo AS stock_minimo_producto,
                                a.stock_maximo AS stock_maximo_producto,
                                a.precio_compra AS precio_compra_almacen,
                                a.precio_venta AS precio_venta_almacen,
                                a.fecha_ingreso AS fecha_ingreso_producto,
                                a.imagen AS imagen_producto,
                                cat.nombre_categoria,
                                u_prod.nombres AS nombre_usuario_registro_producto
                            FROM tb_compras AS co
                            INNER JOIN tb_usuarios AS u_compra ON co.id_usuario = u_compra.id_usuario
                            INNER JOIN tb_proveedores AS pr ON co.id_proveedor = pr.id_proveedor
                            INNER JOIN tb_detalle_compras AS dc ON co.id_compra = dc.id_compra
                            INNER JOIN tb_almacen AS a ON dc.id_producto = a.id_producto
                            INNER JOIN tb_categorias AS cat ON a.id_categoria = cat.id_categoria
                            INNER JOIN tb_usuarios AS u_prod ON a.id_usuario = u_prod.id_usuario
                            WHERE co.id_compra = :id_compra_get
                            ORDER BY dc.id_detalle_compra ASC";

        $query_compra_detalle = $pdo->prepare($sql_compra_detalle);
        $query_compra_detalle->bindParam(':id_compra_get', $id_compra_get, PDO::PARAM_INT);
        $query_compra_detalle->execute();
        $compra_datos_raw = $query_compra_detalle->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($compra_datos_raw)) {
            // Extraer los detalles generales de la compra (de la primera fila)
            $first_row = $compra_datos_raw[0];
            $response['general'] = [
                'id_compra' => $first_row['id_compra'],
                'nro_compra' => $first_row['nro_compra'],
                'fecha_compra' => $first_row['fecha_compra'],
                'total_compra' => $first_row['total_compra'],
                'comprobante' => $first_row['comprobante'],
                'nombres_usuario_compra' => $first_row['nombres_usuario_compra'],
                'nombre_proveedor' => $first_row['nombre_proveedor'],
                'celular_proveedor' => $first_row['celular_proveedor'],
                'telefono_proveedor' => $first_row['telefono_proveedor'],
                'empresa_proveedor' => $first_row['empresa_proveedor'],
                'email_proveedor' => $first_row['email_proveedor'],
                'direccion_proveedor' => $first_row['direccion_proveedor'],
                'cantidad_total_compra' => 0 // Inicializamos y luego sumamos
            ];

            // Recorrer todas las filas para obtener los detalles de cada producto en la compra
            foreach ($compra_datos_raw as $producto_data) {
                $response['productos_en_compra'][] = [
                    'id_detalle_compra' => $producto_data['id_detalle_compra'],
                    'id_producto' => $producto_data['id_producto'],
                    'cantidad_producto_compra' => $producto_data['cantidad_producto_compra'],
                    'precio_unitario_compra' => $producto_data['precio_unitario_compra'],
                    'subtotal_producto_compra' => $producto_data['subtotal_producto_compra'],
                    'codigo_producto' => $producto_data['codigo_producto'],
                    'nombre_producto' => $producto_data['nombre_producto'],
                    'descripcion_producto' => $producto_data['descripcion_producto'],
                    'stock_actual_producto' => $producto_data['stock_actual_producto'],
                    'stock_minimo_producto' => $producto_data['stock_minimo_producto'],
                    'stock_maximo_producto' => $producto_data['stock_maximo_producto'],
                    'precio_compra_almacen' => $producto_data['precio_compra_almacen'],
                    'precio_venta_almacen' => $producto_data['precio_venta_almacen'],
                    'fecha_ingreso_producto' => $producto_data['fecha_ingreso_producto'],
                    'imagen_producto' => $producto_data['imagen_producto'],
                    'nombre_categoria' => $producto_data['nombre_categoria'],
                    'nombre_usuario_registro_producto' => $producto_data['nombre_usuario_registro_producto']
                ];
                // Sumar la cantidad de cada producto para obtener la cantidad total de la compra
                $response['general']['cantidad_total_compra'] += (int)$producto_data['cantidad_producto_compra'];
            }

            $response['status'] = 'success';
            $response['message'] = 'Detalles de la compra cargados exitosamente.';

        } else {
            $response['message'] = 'No se encontró ninguna compra con el ID proporcionado.';
        }

    } catch (PDOException $e) {
        $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
        error_log("Error en cargar_detalle_compra_para_modal_ajax.php: " . $e->getMessage());
    }

} else {
    $response['message'] = 'ID de compra no proporcionado.';
}

echo json_encode($response);
exit; // Asegurarse de que no se envíe ningún otro contenido
?>
