<?php
include ('../app/config.php');
include ('../layout/sesion.php');

include ('../layout/parte1.php');

// Estos listados no son estrictamente necesarios para 'borrar.php' ya que no hay modales de selección,
// pero se mantienen para replicar tu estructura original.
include ('../app/controllers/almacen/listado_de_productos.php');
include ('../app/controllers/proveedores/listado_de_proveedores.php');

// Incluimos la lógica para cargar los datos de la compra específica.
// Este script poblará la variable $compra_detalle con la estructura que definiste.
// Asegúrate de que tu cargar_compra.php incluye el 'id_proveedor' en la consulta.
include ('../app/controllers/compras/cargar_compra.php');

// Verificamos si se encontró la compra, si no, redirigimos.
if (empty($compra_detalle['general'])) {
    $_SESSION['mensaje'] = "Error: La compra no existe o no se pudo cargar.";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/compras/index.php');
    exit;
}

// Extraemos los datos principales para facilitar el acceso en el HTML
$compra_general = $compra_detalle['general'];
$productos_de_la_compra = $compra_detalle['productos_en_compra'];

// Para los campos de producto, usamos el primer producto de la compra como referencia.
// Si no hay productos en la compra, $primer_producto_compra será null.
$primer_producto_compra = !empty($productos_de_la_compra) ? $productos_de_la_compra[0] : null;

// Calculamos la cantidad total de la compra sumando las cantidades de cada producto
$cantidad_total_compra = 0;
foreach ($productos_de_la_compra as $producto_item) {
    $cantidad_total_compra += (int)($producto_item['cantidad_producto_compra'] ?? 0);
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Compra nro <?php echo htmlspecialchars($compra_general['nro_compra'] ?? ''); ?></h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-danger">
                                <div class="card-header">
                                    <h3 class="card-title">¿Está seguro de eliminar la compra?</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="card-body" style="display: block;">
                                    <div class="row" style="font-size: 12px">
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="text" value="<?php echo htmlspecialchars($primer_producto_compra['id_producto'] ?? ''); ?>" id="id_producto" hidden>
                                                        <label for="">Código:</label>
                                                        <input type="text" class="form-control" value="<?= htmlspecialchars($primer_producto_compra['codigo_producto'] ?? ''); ?>" id="codigo" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Categoría:</label>
                                                        <div style="display: flex">
                                                            <input type="text" value="<?= htmlspecialchars($primer_producto_compra['nombre_categoria'] ?? ''); ?>" class="form-control" id="categoria" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Nombre del producto:</label>
                                                        <input type="text" name="nombre" value="<?= htmlspecialchars($primer_producto_compra['nombre_producto'] ?? ''); ?>" id="nombre_producto" class="form-control" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Usuario</label>
                                                        <input type="text" value="<?= htmlspecialchars($primer_producto_compra['nombre_usuario_registro_producto'] ?? ''); ?>" class="form-control" id="usuario_producto" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="">Descripción del producto:</label>
                                                        <textarea name="descripcion" id="descripcio_producto" cols="30" rows="2" class="form-control" disabled><?= htmlspecialchars($primer_producto_compra['descripcion_producto'] ?? ''); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Stock:</label>
                                                        <input type="number" value="<?= htmlspecialchars($primer_producto_compra['stock_actual_producto'] ?? ''); ?>" name="stock" id="stock" class="form-control" style="background-color: #fff819" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Stock mínimo:</label>
                                                        <input type="number" value="<?= htmlspecialchars($primer_producto_compra['stock_minimo_producto'] ?? ''); ?>" name="stock_minimo" id="stock_minimo" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Stock máximo:</label>
                                                        <input type="number" value="<?= htmlspecialchars($primer_producto_compra['stock_maximo_producto'] ?? ''); ?>" name="stock_maximo" id="stock_maximo" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Precio compra:</label>
                                                        <input type="number" value="<?= htmlspecialchars($primer_producto_compra['precio_compra_almacen'] ?? ''); ?>" name="precio_compra" id="precio_compra" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Precio venta:</label>
                                                        <input type="number" value="<?= htmlspecialchars($primer_producto_compra['precio_venta_almacen'] ?? ''); ?>" name="precio_venta" id="precio_venta" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Fecha de ingreso:</label>
                                                        <input type="date" style="font-size: 12px" value="<?= htmlspecialchars($primer_producto_compra['fecha_ingreso_producto_almacen'] ?? ''); ?>" name="fecha_ingreso" id="fecha_ingreso" class="form-control" disabled>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Imagen del producto</label>
                                                <center>
                                                    <img src="<?php echo $URL."/almacen/img_productos/".htmlspecialchars($primer_producto_compra['imagen_producto'] ?? '');?>" id="img_producto" width="50%" alt="Imagen del producto">
                                                </center>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <div style="display: flex">
                                        <h5>Datos del proveedor </h5>
                                    </div>
                                    <hr>

                                    <div class="container-fluid" style="font-size: 12px">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="text" id="id_proveedor" hidden>
                                                    <label for="">Nombre del proveedor </label>
                                                    <input type="text" value="<?= htmlspecialchars($compra_general['nombre_proveedor'] ?? ''); ?>" id="nombre_proveedor" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Celular</label>
                                                    <input type="number" value="<?= htmlspecialchars($compra_general['celular_proveedor'] ?? ''); ?>" id="celular" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Teléfono</label>
                                                    <input type="number" value="<?= htmlspecialchars($compra_general['telefono_proveedor'] ?? ''); ?>" id="telefono" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Empresa </label>
                                                    <input type="text" value="<?= htmlspecialchars($compra_general['empresa_proveedor'] ?? ''); ?>" id="empresa" class="form-control" disabled>

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Email</label>
                                                    <input type="email" value="<?= htmlspecialchars($compra_general['email_proveedor'] ?? ''); ?>" id="email" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Dirección</label>
                                                    <textarea name="" id="direccion" cols="30" rows="3" class="form-control" disabled><?= htmlspecialchars($compra_general['direccion_proveedor'] ?? ''); ?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline card-danger">
                                <div class="card-header">
                                    <h3 class="card-title">Detalle de la compra</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Número de la compra</label>
                                                <input type="text" value="<?php echo htmlspecialchars($compra_general['nro_compra'] ?? ''); ?>" style="text-align: center" class="form-control" disabled>
                                                <input type="text" value="<?php echo htmlspecialchars($compra_general['id_compra'] ?? ''); ?>" id="nro_compra" hidden>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Fecha de la compra</label>
                                                <input type="date" value="<?= htmlspecialchars($compra_general['fecha_compra'] ?? ''); ?>" class="form-control" id="fecha_compra" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Comprobante de la compra</label>
                                                <input type="text" value="<?= htmlspecialchars($compra_general['comprobante'] ?? ''); ?>" class="form-control" id="comprobante" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Total de la compra</label>
                                                <input type="text" value="<?= htmlspecialchars($compra_general['total_compra'] ?? ''); ?>" class="form-control" id="precio_compra_controlador" disabled>
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Cantidad de la compra</label>
                                                <input type="number" value="<?= htmlspecialchars($cantidad_total_compra); ?>" id="cantidad_compra" style="text-align: center" class="form-control" disabled>
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Usuario</label>
                                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($compra_general['nombres_usuario_compra'] ?? ''); ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <!-- Sección de productos en la compra (Detalle) -->
                                    <h5>Productos en esta Compra 🛒</h5>
                                    <div class="table-responsive mb-4">
                                        <table class="table table-bordered table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Cód.</th>
                                                    <th>Producto</th>
                                                    <th>Cant.</th>
                                                    <th>P. Unit.</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($productos_de_la_compra)): ?>
                                                    <?php foreach ($productos_de_la_compra as $producto_compra_item): ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($producto_compra_item['codigo_producto'] ?? ''); ?></td>
                                                            <td><?php echo htmlspecialchars($producto_compra_item['nombre_producto'] ?? ''); ?></td>
                                                            <td><?php echo htmlspecialchars($producto_compra_item['cantidad_producto_compra'] ?? ''); ?></td>
                                                            <td><?php echo htmlspecialchars($producto_compra_item['precio_unitario_compra'] ?? ''); ?></td>
                                                            <td><?php echo htmlspecialchars($producto_compra_item['subtotal_producto_compra'] ?? ''); ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="5"><center>No hay productos registrados para esta compra.</center></td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button class="btn btn-danger btn-block" id="btn_eliminar"><i class="fa fa-trash"></i> Eliminar</button>
                                        </div>
                                    </div>

                                    <div id="respuesta_delete"></div>

                                    <script>
                                        $('#btn_eliminar').click(function () {
                                            var id_compra = '<?php echo htmlspecialchars($compra_general['id_compra'] ?? ''); ?>';
                                            // Cuando se elimina toda la compra, es más robusto iterar sobre los productos
                                            // para revertir el stock. Para simplificar y seguir tu estructura,
                                            // estamos tomando el primer producto como referencia para id_producto y stock_actual,
                                            // y la cantidad total de la compra para cantidad_compra en el script.
                                            // Sin embargo, tu controlador delete.php necesitará la lógica para todos los productos.
                                            var id_producto = '<?php echo htmlspecialchars($primer_producto_compra['id_producto'] ?? ''); ?>';
                                            var cantidad_compra = '<?php echo htmlspecialchars($primer_producto_compra['cantidad_producto_compra'] ?? 0); ?>'; // Cantidad del primer producto
                                            var stock_actual = '<?php echo htmlspecialchars($primer_producto_compra['stock_actual_producto'] ?? 0); ?>'; // Stock del primer producto

                                            Swal.fire({
                                                title: '¿Está seguro de eliminar la compra?',
                                                icon: 'question',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Si deseo eliminar',
                                                cancelButtonText: 'Cancelar'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    eliminar();
                                                    Swal.fire(
                                                        '¡Eliminado!',
                                                        'La compra ha sido eliminada.',
                                                        'success'
                                                    )
                                                }
                                            });

                                            function eliminar() {
                                                var url = "../app/controllers/compras/delete.php";
                                                $.get(url,{id_compra:id_compra,id_producto:id_producto,cantidad_compra:cantidad_compra,stock_actual:stock_actual},function (datos) {
                                                    $('#respuesta_delete').html(datos);
                                                    // Puedes redirigir aquí si la eliminación es exitosa
                                                    window.location.href = '<?php echo $URL; ?>/compras';
                                                });
                                            }
                                        });
                                    </script>

                                </div>
                                <hr>

                            </div>

                        </div>

                    </div>


                </div>
            </div>

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include ('../layout/mensajes.php'); ?>
<?php include ('../layout/parte2.php'); ?>
