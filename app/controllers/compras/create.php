<?php
// Asegúrate de que config.php esté incluido para tener la conexión $pdo
if (!isset($pdo)) {
    include ('../../config.php');
}

// Prepara la consulta SQL para obtener el listado de compras principales,
// incluyendo el nombre del proveedor y el nombre del usuario que registró la compra.
$sql_listado_compras = "SELECT
                            co.id_compra,
                            co.nro_compra,
                            co.fecha_compra,
                            co.total_compra,
                            co.comprobante,
                            pr.nombre_proveedor,
                            u.nombres AS nombre_usuario_compra
                        FROM tb_compras AS co
                        INNER JOIN tb_proveedores AS pr ON co.id_proveedor = pr.id_proveedor
                        INNER JOIN tb_usuarios AS u ON co.id_usuario = u.id_usuario
                        ORDER BY co.id_compra DESC"; // Ordena las compras de la más reciente a la más antigua

$query_listado_compras = $pdo->prepare($sql_listado_compras);
$query_listado_compras->execute();
$compras_consolidadas = $query_listado_compras->fetchAll(PDO::FETCH_ASSOC);

// La variable $compras_consolidadas contendrá ahora un array con cada compra como un elemento,
// listo para ser utilizado en la vista de listado.
?>
