<?php
// Incluimos los archivos de configuración y la parte superior del layout
include ('../app/config.php');
include ('../layout/sesion.php');
include ('../layout/parte1.php');

// Incluimos los controladores necesarios (asegúrate de que las rutas son correctas)
include ('../app/controllers/almacen/listado_de_productos.php'); // Podría no ser estrictamente necesario para show.php, pero lo dejamos si lo usas en modales ocultos
include ('../app/controllers/proveedores/listado_de_proveedores.php'); // Ídem
include ('../app/controllers/compras/cargar_compra.php'); // Este es el controlador crucial para obtener los datos

// Verificar si la compra se cargó correctamente desde cargar_compra.php
// Asumimos que cargar_compra.php recibe el ID de la URL ($_GET['id'])
// y popula $compra_detalle con las claves 'general' y 'productos_en_compra'.
// Si $compra_detalle['general'] está vacío, significa que la compra no existe o hubo un error.
if (empty($compra_detalle['general'])) {
    // Asegurarse de que la sesión esté iniciada antes de usar $_SESSION
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['mensaje'] = "Error: La compra no existe o no se pudo cargar.";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/compras/index.php');
    exit;
}

// Asignar los datos de la compra a variables más fáciles de usar en la vista
$compra_general = $compra_detalle['general'];
$productos_de_la_compra = $compra_detalle['productos_en_compra'];

// Variables para cálculos adicionales si son necesarios (ya no se usan en el HTML directamente, pero se mantienen si los necesitas)
// $primer_producto_compra = !empty($productos_de_la_compra) ? $productos_de_la_compra[0] : null;
// $cantidad_total_compra = 0;
// foreach ($productos_de_la_compra as $producto_item) {
//     $cantidad_total_compra += (int)($producto_item['cantidad_producto_compra'] ?? 0);
// }

?>

<!-- Contenido del wrapper -->
<div class="content-wrapper">
    <!-- Encabezado de la página -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Detalles de la Compra Nro: <?php echo htmlspecialchars($compra_general['nro_compra'] ?? ''); ?></h1>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Información General de la Compra</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Número de Compra:</label>
                                <p><?php echo htmlspecialchars($compra_general['nro_compra'] ?? ''); ?></p>
                            </div>
                            <div class="form-group">
                                <label>Fecha de Compra:</label>
                                <p><?php echo htmlspecialchars($compra_general['fecha_compra'] ?? ''); ?></p>
                            </div>
                            <div class="form-group">
                                <label>Proveedor:</label>
                                <p><?php echo htmlspecialchars($compra_general['nombre_proveedor'] ?? ''); ?></p>
                            </div>
                            <div class="form-group">
                                <label>Comprobante:</label>
                                <p><?php echo htmlspecialchars($compra_general['comprobante'] ?? ''); ?></p>
                            </div>
                            <div class="form-group">
                                <label>Total de la Compra:</label>
                                <p><strong>$<?php echo htmlspecialchars(number_format($compra_general['total_compra'] ?? 0, 2)); ?></strong></p>
                            </div>
                            <!-- Otros campos generales de la compra -->

                            <hr>
                            <h3 class="card-title">Productos Incluidos en esta Compra</h3>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>P. Unitario Compra</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($productos_de_la_compra)): ?>
                                            <?php foreach ($productos_de_la_compra as $producto_compra): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($producto_compra['codigo'] ?? ''); ?></td>
                                                    <td><?php echo htmlspecialchars($producto_compra['nombre'] ?? ''); ?></td>
                                                    <td><?php echo htmlspecialchars($producto_compra['cantidad'] ?? ''); ?></td>
                                                    <td>$<?php echo htmlspecialchars(number_format($producto_compra['precio_unitario'] ?? 0, 2)); ?></td>
                                                    <td>$<?php echo htmlspecialchars(number_format($producto_compra['subtotal'] ?? 0, 2)); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5">No hay productos registrados para esta compra.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="card-footer">
                            <a href="<?php echo $URL;?>/compras/index.php" class="btn btn-primary">Volver al Listado</a>
                            <a href="<?php echo $URL;?>/compras/update.php?id=<?php echo htmlspecialchars($compra_general['id_compra'] ?? ''); ?>" class="btn btn-info">Editar Compra</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include ('../layout/mensajes.php'); ?>
<?php include ('../layout/parte2.php'); ?>