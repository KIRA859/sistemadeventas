<?php
include ('../app/config.php');
include ('../layout/sesion.php');

include ('../layout/parte1.php');

// Incluimos los listados de productos y proveedores para los modales de búsqueda
include ('../app/controllers/almacen/listado_de_productos.php');
include ('../app/controllers/proveedores/listado_de_proveedores.php');

// Incluimos la lógica para cargar los datos de la compra específica.
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

// Para pre-llenar la sección principal de 'Datos del producto', usamos el primer producto de la compra.
$primer_producto_compra = !empty($productos_de_la_compra) ? $productos_de_la_compra[0] : null;
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Actualización de la compra #<?php echo htmlspecialchars($compra_general['nro_compra'] ?? ''); ?></h1>
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
                    <div class="card card-success card-tabs"> <!-- Changed to card-tabs for tabbed interface -->
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="datos-compra-tab" data-toggle="pill" href="#datos-compra" role="tab" aria-controls="datos-compra" aria-selected="true">Datos de Compra</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="proveedor-tab" data-toggle="pill" href="#proveedor" role="tab" aria-controls="proveedor" aria-selected="false">Proveedor</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="producto-tab" data-toggle="pill" href="#producto" role="tab" aria-controls="producto" aria-selected="false">Producto</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <form action="../app/controllers/compras/update.php" method="POST">
                                <input type="hidden" name="id_compra" value="<?php echo htmlspecialchars($compra_general['id_compra'] ?? ''); ?>">
                                
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <!-- Pestaña 1: Datos de Compra -->
                                    <div class="tab-pane fade show active" id="datos-compra" role="tabpanel" aria-labelledby="datos-compra-tab">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="nro_compra">Nro de Compra:</label>
                                                    <input type="text" name="nro_compra" id="nro_compra" class="form-control" value="<?php echo htmlspecialchars($compra_general['nro_compra'] ?? ''); ?>" required disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="fecha_compra">Fecha de Compra:</label>
                                                    <input type="date" name="fecha_compra" id="fecha_compra" class="form-control" value="<?php echo htmlspecialchars($compra_general['fecha_compra'] ?? ''); ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="comprobante">Comprobante:</label>
                                                    <input type="text" name="comprobante" id="comprobante" class="form-control" value="<?php echo htmlspecialchars($compra_general['comprobante'] ?? ''); ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="total_compra">Total de la Compra:</label>
                                                    <input type="text" name="total_compra" id="total_compra" class="form-control" value="<?php echo htmlspecialchars($compra_general['total_compra'] ?? ''); ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="usuario_compra">Usuario que realizó la compra:</label>
                                                    <input type="text" id="usuario_compra" class="form-control" value="<?php echo htmlspecialchars($compra_general['nombres_usuario_compra'] ?? ''); ?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Pestaña 2: Datos del Proveedor -->
                                    <div class="tab-pane fade" id="proveedor" role="tabpanel" aria-labelledby="proveedor-tab">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="mb-0">Datos del proveedor</h5>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-buscar_proveedor">
                                                <i class="fa fa-search"></i> Buscar proveedor
                                            </button>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="hidden" name="id_proveedor" value="<?php echo htmlspecialchars($compra_general['id_proveedor'] ?? ''); ?>" id="id_proveedor">
                                                    <label for="nombre_proveedor">Nombre del proveedor</label>
                                                    <input type="text" value="<?php echo htmlspecialchars($compra_general['nombre_proveedor'] ?? ''); ?>" id="nombre_proveedor" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="celular">Celular</label>
                                                    <input type="number" value="<?php echo htmlspecialchars($compra_general['celular_proveedor'] ?? ''); ?>" id="celular" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="telefono">Teléfono</label>
                                                    <input type="number" value="<?php echo htmlspecialchars($compra_general['telefono_proveedor'] ?? ''); ?>" id="telefono" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="empresa">Empresa</label>
                                                    <input type="text" value="<?php echo htmlspecialchars($compra_general['empresa_proveedor'] ?? ''); ?>" id="empresa" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" value="<?php echo htmlspecialchars($compra_general['email_proveedor'] ?? ''); ?>" id="email" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="direccion">Dirección</label>
                                                    <input type="text" value="<?php echo htmlspecialchars($compra_general['direccion_proveedor'] ?? ''); ?>" id="direccion" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="text-center mt-2">
                                            <a href="https://wa.me/591<?php echo htmlspecialchars($compra_general['celular_proveedor'] ?? '');?>" target="_blank" class="btn btn-success" id="celular_proveedor_link">
                                                <i class="fa fa-whatsapp"></i> Contactar por WhatsApp
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- Pestaña 3: Datos del Producto -->
                                    <div class="tab-pane fade" id="producto" role="tabpanel" aria-labelledby="producto-tab">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="mb-0">Datos del producto</h5>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-buscar_producto">
                                                <i class="fa fa-search"></i> Buscar producto
                                            </button>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($primer_producto_compra['id_producto'] ?? ''); ?>" id="id_producto_main">
                                                            <label for="codigo">Código:</label>
                                                            <input type="text" value="<?php echo htmlspecialchars($primer_producto_compra['codigo_producto'] ?? ''); ?>" class="form-control" id="codigo" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="categoria">Categoría:</label>
                                                            <input type="text" value="<?php echo htmlspecialchars($primer_producto_compra['nombre_categoria'] ?? ''); ?>" class="form-control" id="categoria" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="nombre_producto">Nombre del producto:</label>
                                                            <input type="text" value="<?php echo htmlspecialchars($primer_producto_compra['nombre_producto'] ?? ''); ?>" name="nombre" id="nombre_producto" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="descripcio_producto">Descripción del producto:</label>
                                                            <textarea name="descripcion" id="descripcio_producto" cols="30" rows="2" class="form-control" disabled><?php echo htmlspecialchars($primer_producto_compra['descripcion_producto'] ?? ''); ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="stock">Stock:</label>
                                                            <input type="number" value="<?php echo htmlspecialchars($primer_producto_compra['stock_actual_producto'] ?? ''); ?>" name="stock" id="stock" class="form-control" style="background-color: #fff819" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="precio_unitario_compra">Precio compra (ítem):</label>
                                                            <input type="number" value="<?php echo htmlspecialchars($primer_producto_compra['precio_unitario_compra'] ?? ''); ?>" name="precio_unitario_compra" id="precio_unitario_compra" class="form-control" step="0.01">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="cantidad_producto_compra">Cantidad (ítem):</label>
                                                            <input type="number" value="<?php echo htmlspecialchars($primer_producto_compra['cantidad_producto_compra'] ?? ''); ?>" name="cantidad_producto_compra" id="cantidad_producto_compra" class="form-control" min="1">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="text-center">
                                                    <div class="form-group">
                                                        <label>Imagen del producto</label>
                                                        <div>
                                                            <img src="<?php echo $URL."/almacen/img_productos/".htmlspecialchars($primer_producto_compra['imagen_producto'] ?? '');?>" id="img_producto" class="img-fluid" style="max-height: 200px;" alt="Imagen del producto">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="usuario_producto">Usuario registro</label>
                                                        <input type="text" value="<?php echo htmlspecialchars($primer_producto_compra['nombre_usuario_registro_producto'] ?? ''); ?>" class="form-control form-control-sm" id="usuario_producto" disabled>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="fecha_ingreso">Fecha de ingreso:</label>
                                                        <input type="date" value="<?php echo htmlspecialchars($primer_producto_compra['fecha_ingreso_producto_almacen'] ?? ''); ?>" name="fecha_ingreso" id="fecha_ingreso" class="form-control form-control-sm" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Información adicional en acordeón -->
                                        <div class="mt-3">
                                            <div class="accordion" id="productoInfoAccordion">
                                                <div class="card">
                                                    <div class="card-header" id="headingOne">
                                                        <h2 class="mb-0">
                                                            <button class="btn btn-link btn-sm text-decoration-none" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                                Más información del producto
                                                            </button>
                                                        </h2>
                                                    </div>

                                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#productoInfoAccordion">
                                                        <div class="card-body py-2">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="form-group mb-1">
                                                                        <label for="stock_minimo" class="mb-0">Stock mínimo:</label>
                                                                        <input type="number" value="<?php echo htmlspecialchars($primer_producto_compra['stock_minimo_producto'] ?? ''); ?>" name="stock_minimo" id="stock_minimo" class="form-control form-control-sm" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group mb-1">
                                                                        <label for="stock_maximo" class="mb-0">Stock máximo:</label>
                                                                        <input type="number" value="<?php echo htmlspecialchars($primer_producto_compra['stock_maximo_producto'] ?? ''); ?>" name="stock_maximo" id="stock_maximo" class="form-control form-control-sm" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group mb-1">
                                                                        <label for="precio_compra" class="mb-0">Precio compra (almacén):</label>
                                                                        <input type="number" value="<?php echo htmlspecialchars($primer_producto_compra['precio_compra_almacen'] ?? ''); ?>" name="precio_compra_almacen" id="precio_compra" class="form-control form-control-sm" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group mb-1">
                                                                        <label for="precio_venta" class="mb-0">Precio venta:</label>
                                                                        <input type="number" value="<?php echo htmlspecialchars($primer_producto_compra['precio_venta_almacen'] ?? ''); ?>" name="precio_venta" id="precio_venta" class="form-control form-control-sm" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <hr>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="form-group mb-0">
                                            <button type="submit" class="btn btn-success">Actualizar Compra</button>
                                            <a href="<?php echo $URL;?>/compras" class="btn btn-default">Cancelar</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modales (mantener igual que en el código original) -->
<!-- Modal para búsqueda de proveedor -->
<div class="modal fade" id="modal-buscar_proveedor">
    <!-- ... (mantener el contenido del modal igual) ... -->
</div>

<!-- Modal para búsqueda de producto -->
<div class="modal fade" id="modal-buscar_producto">
    <!-- ... (mantener el contenido del modal igual) ... -->
</div>

<?php include ('../layout/mensajes.php'); ?>
<?php include ('../layout/parte2.php'); ?>

<!-- Scripts (mantener igual) -->
<script>
    $(function () {
        // Inicialización del DataTable para el modal de búsqueda de productos
        $("#example1").DataTable({
            // ... (configuración igual) ...
        });

        // Inicialización del DataTable para el modal de búsqueda de proveedores
        $("#example2").DataTable({
            // ... (configuración igual) ...
        });
    });
</script>