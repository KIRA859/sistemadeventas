<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
include('../app/controllers/ventas/listado_de_ventas.php');

$id_venta = $_GET['id_venta'];

// Traemos datos de la venta
$sql_venta = "SELECT v.*, c.nombre_cliente, f.descripcion AS forma_pago, e.descripcion AS estado
              FROM tb_ventas v
              INNER JOIN tb_clientes c ON v.id_cliente = c.id_cliente
              LEFT JOIN tb_formas_pago f ON v.id_forma_pago = f.id_forma_pago
              LEFT JOIN tb_estados_venta e ON v.id_estado = e.id_estado
              WHERE v.id_venta = :id_venta";

$query_venta = $pdo->prepare($sql_venta);
$query_venta->bindParam(':id_venta', $id_venta, PDO::PARAM_INT);
$query_venta->execute();
$venta = $query_venta->fetch(PDO::FETCH_ASSOC);

// Traemos los detalles de productos vendidos
$sql_detalle = "SELECT dv.*, p.nombre AS producto, p.descripcion
                FROM tb_detalle_ventas dv
                INNER JOIN tb_almacen p ON dv.id_producto = p.id_producto
                WHERE dv.id_venta = :id_venta";

$query_detalle = $pdo->prepare($sql_detalle);
$query_detalle->bindParam(':id_venta', $id_venta, PDO::PARAM_INT);
$query_detalle->execute();
$detalles = $query_detalle->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-wrapper">
    <!-- Encabezado -->
    <section class="content-header">
        <h1>Detalle de Venta #<?php echo $venta['nro_venta']; ?></h1>
    </section>

    <section class="content">
        <!-- Datos generales de la venta -->
        <div class="card">
            <div class="card-body">
                <p><strong>Cliente:</strong> <?php echo $venta['nombre_cliente']; ?></p>
                <p><strong>Total Pagado:</strong> $<?php echo number_format($venta['total_pagado'], 0, ',', '.'); ?></p>
                <p><strong>Forma de Pago:</strong> <?php echo $venta['forma_pago'] ?? 'No asignada'; ?></p>
                <p><strong>Estado:</strong> <?php echo $venta['estado'] ?? 'No definido'; ?></p>
                <p><strong>Fecha:</strong> <?php echo $venta['fyh_creacion']; ?></p>
            </div>
        </div>

        <!-- Detalle de productos -->
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Productos Vendidos</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $contador = 0;
                        foreach ($detalles as $detalle) {
                            $contador++;
                        ?>
                            <tr>
                                <td><?php echo $contador; ?></td>
                                <td><?php echo $detalle['producto']; ?></td>
                                <td><?php echo $detalle['descripcion']; ?></td>
                                <td><?php echo $detalle['cantidad']; ?></td>
                                <td>$<?php echo number_format($detalle['precio_unitario'], 0, ',', '.'); ?></td>
                                <td>$<?php echo number_format($detalle['subtotal'], 0, ',', '.'); ?></td>
                                <center><td><a href="factura.php?id_venta=<?php echo $id_venta ?>" class="btn btn-success"><i class="fa fa-print">Imprimir</i></a></td></center>
                            </tr>
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
        </div>

        <!-- Botón volver -->
        <div class="mt-3">
            <a href="index.php" class="btn btn-secondary">Volver a Ventas</a>
        </div>
    </section>
</div>

<?php include('../layout/parte2.php'); ?>