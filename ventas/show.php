<?php
include ('../app/config.php');
include ('../layout/sesion.php'); // Asegura que la sesión esté iniciada y variables como $nombres_sesion estén disponibles
include ('../layout/parte1.php'); // Ya incluye ob_start() al inicio

// Incluimos el controlador para cargar los datos de la venta específica
// Esto poblará la variable $venta_detalle
include ('../app/controllers/ventas/cargar_venta.php');

// Extraer los datos para facilitar el acceso en la vista
// El controlador 'cargar_venta.php' ya maneja las redirecciones si no se encuentra la venta
$venta_general = $venta_detalle['general'];
$cliente_detalle = $venta_detalle['cliente'];
$productos_de_la_venta = $venta_detalle['productos_en_venta'];
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Detalle de Venta Nro: <?php echo htmlspecialchars($venta_general['nro_venta'] ?? 'N/A'); ?></h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
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
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($venta_general['fecha_venta'] ?? ''); ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Forma de Pago:</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($venta_general['forma_pago'] ?? ''); ?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Estado de la Venta:</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($venta_general['estado_venta'] ?? ''); ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Total Pagado:</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars(number_format($venta_general['total_pagado'] ?? 0, 2)); ?>" disabled style="font-weight: bold;">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Registrado por:</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($venta_general['nombres_usuario_venta'] ?? 'N/A'); ?>" disabled>
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
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($cliente_detalle['nombre_cliente'] ?? ''); ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>NIT/CI:</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($cliente_detalle['nit_ci_cliente'] ?? ''); ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Celular:</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($cliente_detalle['celular_cliente'] ?? ''); ?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Email:</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($cliente_detalle['email_cliente'] ?? ''); ?>" disabled>
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
                                            <th>Código</th>
                                            <th>Producto</th>
                                            <th>Descripción</th>
                                            <th>Categoría</th>
                                            <th>Cantidad</th>
                                            <th>Precio Unitario</th>
                                            <th>Subtotal</th>
                                            <th>Imagen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $contador_productos = 0; ?>
                                        <?php if (!empty($productos_de_la_venta)): ?>
                                            <?php foreach ($productos_de_la_venta as $producto): ?>
                                                <tr>
                                                    <td><?php echo ++$contador_productos; ?></td>
                                                    <td><?php echo htmlspecialchars($producto['codigo_producto'] ?? ''); ?></td>
                                                    <td><?php echo htmlspecialchars($producto['descripcion_producto'] ?? ''); ?></td>
                                                    <td><?php echo htmlspecialchars($producto['nombre_producto'] ?? ''); ?></td>
                                                    <td><?php echo htmlspecialchars($producto['nombre_categoria'] ?? ''); ?></td>
                                                    <td><?php echo htmlspecialchars($producto['cantidad_producto_venta'] ?? ''); ?></td>
                                                    <td><?php echo htmlspecialchars(number_format($producto['precio_unitario_venta'] ?? 0, 2)); ?></td>
                                                    <td><?php echo htmlspecialchars(number_format($producto['subtotal_producto_venta'] ?? 0, 2)); ?></td>
                                                    <td>
                                                        <?php if (!empty($producto['imagen_producto'])): ?>
                                                            <img src="<?php echo $URL . "/almacen/img_productos/" . htmlspecialchars($producto['imagen_producto']); ?>" width="50px" alt="imagen producto">
                                                        <?php else: ?>
                                                            N/A
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="9">No hay productos registrados para esta venta.</td>
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

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include ('../layout/mensajes.php'); ?>
<?php include ('../layout/parte2.php'); ?>
