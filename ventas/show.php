<?php
include ('../layout/sesion.php');
include ('../layout/parte1.php');
include ('../app/config.php');
$id_venta = isset($_GET['id_venta']) ? intval($_GET['id_venta']) : 0;

$url_api = "http://localhost/sistema_de_ventas/api/ventas/obtener.php?id_venta=" . $id_venta;

$response = @file_get_contents($url_api);
$data = json_decode($response, true);

if (isset($data['status']) && $data['status'] === 'success') {
    $venta_general = $data['venta'];
    $productos_de_la_venta = $data['detalle'];
} else {
    $venta_general = null;
    $productos_de_la_venta = [];
    $error_message = $data['message'] ?? 'Error al cargar los datos de la venta.';
    echo "<p style='color:red; font-size: 1.2em; text-align: center;'><strong>Error:</strong> " . htmlspecialchars($error_message) . "</p>";
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Detalle de Venta Nro: <?php echo htmlspecialchars($venta_general['nro_venta'] ?? 'N/A'); ?></h1>
                </div></div></div></div>
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-info-circle"></i> Información General de la Venta</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Nro. de Venta:</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($venta_general['nro_venta'] ?? ''); ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Fecha de Venta:</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($venta_general['fyh_creacion'] ?? ''); ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Forma de Pago:</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($venta_general['nombre_forma_pago'] ?? ''); ?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Total Pagado:</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars(number_format($venta_general['total_pagado'] ?? 0, 2)); ?>" disabled style="font-weight: bold;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-user"></i> Datos del Cliente</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Nombre del Cliente:</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($venta_general['nombre_cliente'] ?? 'Consumidor Final'); ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>NIT/CI:</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($venta_general['nit_ci_cliente'] ?? 'N/A'); ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Celular:</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($venta_general['celular_cliente'] ?? 'N/A'); ?>" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-boxes"></i> Productos Vendidos</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Nro</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio Unitario</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $contador_productos = 0; ?>
                                        <?php if (!empty($productos_de_la_venta)): ?>
                                            <?php foreach ($productos_de_la_venta as $producto): ?>
                                                <tr>
                                                    <td><?php echo ++$contador_productos; ?></td>
                                                    <td><?php echo htmlspecialchars($producto['nombre'] ?? ''); ?></td>
                                                    <td><?php echo htmlspecialchars($producto['cantidad'] ?? ''); ?></td>
                                                    <td><?php echo htmlspecialchars(number_format($producto['precio_unitario'] ?? 0, 2)); ?></td>
                                                    <td><?php echo htmlspecialchars(number_format($producto['subtotal'] ?? 0, 2)); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5">No hay productos registrados para esta venta.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <a href="<?php echo $URL; ?>/ventas" class="btn btn-default">Volver al Listado de Ventas</a>
                </div>
            </div>

        </div></div>
    </div>
<?php include ('../layout/mensajes.php'); ?>
<?php include ('../layout/parte2.php'); ?>