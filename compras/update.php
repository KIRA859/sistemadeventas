<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

$id_compra_get = $_GET['id'] ?? null;
if (!$id_compra_get) {
    $_SESSION['mensaje'] = "Error: No se recibió el ID de la compra.";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/compras/index.php');
    exit;
}
// CORREGIDO: Eliminé la doble barra //
$api_url = $URL . "/api/compras/index.php?id=" . $id_compra_get;
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Actualización de la compra #<span id="nro_compra_header"></span></h1>
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
                    <div class="card card-success card-tabs">
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
                            <form id="form-actualizar-compra" method="POST">
                                <input type="hidden" name="id_compra" id="id_compra" value="<?php echo htmlspecialchars($id_compra_get); ?>">

                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <!-- Pestaña 1: Datos de Compra -->
                                    <div class="tab-pane fade show active" id="datos-compra" role="tabpanel" aria-labelledby="datos-compra-tab">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="nro_compra">Nro de Compra:</label>
                                                    <input type="text" name="nro_compra" id="nro_compra" class="form-control" required readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="fecha_compra">Fecha de Compra:</label>
                                                    <input type="date" name="fecha_compra" id="fecha_compra" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="comprobante">Comprobante:</label>
                                                    <input type="text" name="comprobante" id="comprobante" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="total_compra">Total de la Compra:</label>
                                                    <input type="text" name="total_compra" id="total_compra" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="usuario_compra">Usuario que realizó la compra:</label>
                                                    <input type="text" id="usuario_compra" class="form-control" readonly>
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
                                                    <input type="hidden" name="id_proveedor" id="id_proveedor">
                                                    <label for="nombre_proveedor">Nombre del proveedor</label>
                                                    <input type="text" id="nombre_proveedor" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="celular">Celular</label>
                                                    <input type="number" id="celular" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="telefono">Teléfono</label>
                                                    <input type="number" id="telefono" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="empresa">Empresa</label>
                                                    <input type="text" id="empresa" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" id="email" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="direccion">Dirección</label>
                                                    <input type="text" id="direccion" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-center mt-2">
                                            <a href="#" target="_blank" class="btn btn-success" id="celular_proveedor_link">
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
                                                            <input type="hidden" name="id_producto" id="id_producto_main">
                                                            <label for="codigo">Código:</label>
                                                            <input type="text" class="form-control" id="codigo" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="categoria">Categoría:</label>
                                                            <input type="text" class="form-control" id="categoria" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="nombre_producto">Nombre del producto:</label>
                                                            <input type="text" name="nombre" id="nombre_producto" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="descripcio_producto">Descripción del producto:</label>
                                                            <textarea name="descripcion" id="descripcio_producto" cols="30" rows="2" class="form-control" readonly></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="stock">Stock:</label>
                                                            <input type="number" name="stock" id="stock" class="form-control" style="background-color: #fff819" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="precio_unitario_compra">Precio compra (ítem):</label>
                                                            <input type="number" name="precio_unitario_compra" id="precio_unitario_compra" class="form-control" step="0.01" min="0">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="cantidad_producto_compra">Cantidad (ítem):</label>
                                                            <input type="number" name="cantidad_producto_compra" id="cantidad_producto_compra" class="form-control" min="1" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="text-center">
                                                    <div class="form-group">
                                                        <label>Imagen del producto</label>
                                                        <div>
                                                            <img src="" id="img_producto" class="img-fluid" style="max-height: 200px;" alt="Imagen del producto">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="usuario_producto">Usuario registro</label>
                                                        <input type="text" class="form-control form-control-sm" id="usuario_producto" readonly>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="fecha_ingreso">Fecha de ingreso:</label>
                                                        <input type="date" name="fecha_ingreso" id="fecha_ingreso" class="form-control form-control-sm" readonly>
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
                                                                        <input type="number" name="stock_minimo" id="stock_minimo" class="form-control form-control-sm" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group mb-1">
                                                                        <label for="stock_maximo" class="mb-0">Stock máximo:</label>
                                                                        <input type="number" name="stock_maximo" id="stock_maximo" class="form-control form-control-sm" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group mb-1">
                                                                        <label for="precio_compra" class="mb-0">Precio compra (almacén):</label>
                                                                        <input type="number" name="precio_compra_almacen" id="precio_compra" class="form-control form-control-sm" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group mb-1">
                                                                        <label for="precio_venta" class="mb-0">Precio venta:</label>
                                                                        <input type="number" name="precio_venta" id="precio_venta" class="form-control form-control-sm" readonly>
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
                                            <a href="<?php echo $URL; ?>/compras" class="btn btn-default">Cancelar</a>
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

<!-- Modales -->
<!-- Modal para búsqueda de proveedor -->
<div class="modal fade" id="modal-buscar_proveedor">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Buscar proveedor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="example2" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Acción</th>
                            <th>Nombre</th>
                            <th>Empresa</th>
                            <th>Celular</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para búsqueda de producto -->
<div class="modal fade" id="modal-buscar_producto">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Buscar producto</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Acción</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Stock</th>
                            <th>Precio compra</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Los datos se cargarán via API -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>

<script>
    const API_ROOT = "https://sistemadeventas.infinityfree.me/api/compras";

    const API_COMPRAS = `${API_ROOT}/index.php`;
    const API_PROVEEDORES = `${API_ROOT}/proveedores.php`;
    const API_PRODUCTOS = `${API_ROOT}/productos.php`;
    const API_PRODUCTOS_BUSCAR = `${API_ROOT}/buscar_productos.php`;
    const idCompra = "<?php echo $id_compra_get; ?>";

    document.addEventListener("DOMContentLoaded", () => {
        cargarCompra();
        configurarModalProveedores();
        configurarModalProductos();

        document.getElementById("form-actualizar-compra").addEventListener("submit", function(e) {
            e.preventDefault();
            actualizarCompra();
        });

        // Calcular total automáticamente
        document.getElementById("cantidad_producto_compra").addEventListener("input", calcularTotal);
        document.getElementById("precio_unitario_compra").addEventListener("input", calcularTotal);
    });

    function calcularTotal() {
        const cantidad = parseFloat(document.getElementById("cantidad_producto_compra").value) || 0;
        const precio = parseFloat(document.getElementById("precio_unitario_compra").value) || 0;
        const total = cantidad * precio;
        document.getElementById("total_compra").value = total.toFixed(2);
    }

    /*  CARGAR COMPRA  */
    function cargarCompra() {
        console.log("Cargando compra con ID:", idCompra);

        // Agregar timestamp para evitar cache
        const timestamp = new Date().getTime();
        fetch(`${API_COMPRAS}?id=${idCompra}&t=${timestamp}`)
            .then(res => {
                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }
                return res.json();
            })
            .then(data => {
                console.log("Respuesta API:", data);
                if (data.success && data.data) {
                    llenarFormulario(data.data);
                } else {
                    Swal.fire("Error", data.error || "No se pudo cargar la compra", "error");
                }
            })
            .catch(error => {
                console.error("Error cargando compra:", error);
                Swal.fire("Error", "No se pudo cargar la compra: " + error.message, "error");
            });
    }

    function llenarFormulario(compra) {
        console.log("Llenando formulario con:", compra);

        document.getElementById("nro_compra_header").textContent = compra.nro_compra || '';
        document.getElementById("nro_compra").value = compra.nro_compra || '';
        document.getElementById("fecha_compra").value = compra.fecha_compra || '';
        document.getElementById("comprobante").value = compra.comprobante || '';
        document.getElementById("total_compra").value = compra.total_compra || '';
        document.getElementById("usuario_compra").value = compra.nombres_usuario || 'N/A';
        document.getElementById("id_proveedor").value = compra.id_proveedor || '';
        document.getElementById("nombre_proveedor").value = compra.nombre_proveedor || '';
        document.getElementById("celular").value = compra.celular_proveedor || '';
        document.getElementById("telefono").value = compra.telefono_proveedor || '';
        document.getElementById("empresa").value = compra.empresa_proveedor || '';
        document.getElementById("email").value = compra.email_proveedor || '';
        document.getElementById("direccion").value = compra.direccion_proveedor || '';

        if (compra.celular_proveedor) {
            document.getElementById("celular_proveedor_link").href = `https://wa.me/57${compra.celular_proveedor}`;
            document.getElementById("celular_proveedor_link").style.display = 'inline-block';
        } else {
            document.getElementById("celular_proveedor_link").style.display = 'none';
        }

        if (compra.productos && compra.productos.length > 0) {
            const producto_compra = compra.productos[0];
            console.log("Cargando producto:", producto_compra.id_producto);

            // Agregar timestamp para evitar cache
            const timestamp = new Date().getTime();
            fetch(`${API_PRODUCTOS_BUSCAR}?id_producto=${producto_compra.id_producto}&t=${timestamp}`)
                .then(res => {
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    return res.json();
                })
                .then(data => {
                    console.log("Respuesta API producto:", data);
                    if (data.status === 'success' && data.data) {
                        llenarDatosProducto(data.data, producto_compra);
                    } else {
                        console.warn("No se pudo cargar el producto:", data);
                        llenarDatosProductoBasico(producto_compra);
                    }
                })
                .catch(error => {
                    console.error("Error cargando producto:", error);
                    llenarDatosProductoBasico(producto_compra);
                });
        } else {
            Swal.fire("Advertencia", "Esta compra no tiene productos asociados", "warning");
        }
    }

    function llenarDatosProducto(producto, producto_compra) {
        console.log("Llenando datos producto completo:", producto);

        document.getElementById("id_producto_main").value = producto.id_producto || producto_compra.id_producto || '';
        document.getElementById("codigo").value = producto.codigo || '';
        document.getElementById("nombre_producto").value = producto.nombre || '';
        document.getElementById("descripcio_producto").value = producto.descripcion || '';
        document.getElementById("stock").value = producto.stock || '';
        document.getElementById("stock_minimo").value = producto.stock_minimo || '';
        document.getElementById("stock_maximo").value = producto.stock_maximo || '';
        document.getElementById("precio_compra").value = producto.precio_compra || '';
        document.getElementById("precio_venta").value = producto.precio_venta || '';
        document.getElementById("cantidad_producto_compra").value = producto_compra.cantidad || '';
        document.getElementById("categoria").value = producto.categoria || '';
        document.getElementById("usuario_producto").value = producto.nombres_usuario || '';
        document.getElementById("precio_unitario_compra").value = producto_compra.precio_compra || producto.precio_compra || '';

        const fechaIngreso = producto.fyh_creacion || producto.fecha_ingreso || '';
        document.getElementById("fecha_ingreso").value = fechaIngreso ? fechaIngreso.substring(0, 10) : '';

        if (producto.imagen) {
            document.getElementById("img_producto").src = `../almacen/img_productos/${producto.imagen}`;
            document.getElementById("img_producto").style.display = 'block';
        } else {
            document.getElementById("img_producto").src = '';
            document.getElementById("img_producto").style.display = 'none';
        }

        // Calcular total inicial
        calcularTotal();
    }

    function llenarDatosProductoBasico(producto_compra) {
        console.log("Llenando datos producto básico:", producto_compra);

        document.getElementById("id_producto_main").value = producto_compra.id_producto || '';
        document.getElementById("cantidad_producto_compra").value = producto_compra.cantidad || '';
        document.getElementById("precio_unitario_compra").value = producto_compra.precio_compra || '';

        // Calcular total inicial
        calcularTotal();
    }

    /*  MODALES  */
    function configurarModalProveedores() {
        $('#modal-buscar_proveedor').on('show.bs.modal', function() {
            if ($.fn.DataTable.isDataTable('#example2')) {
                $('#example2').DataTable().destroy();
            }

            const timestamp = new Date().getTime();
            fetch(`${API_PROVEEDORES}?t=${timestamp}`)
                .then(res => {
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    return res.json();
                })
                .then(data => {
                    console.log("Proveedores cargados:", data);
                    let tbody = $('#example2 tbody');
                    tbody.empty();

                    if (data.length === 0) {
                        tbody.append('<tr><td colspan="5" class="text-center">No hay proveedores disponibles</td></tr>');
                    } else {
                        data.forEach(prov => {
                            tbody.append(`
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm select-proveedor"
                                        data-id-proveedor="${prov.id_proveedor}"
                                        data-nombre="${prov.nombre_proveedor}"
                                        data-empresa="${prov.empresa || ''}"
                                        data-celular="${prov.celular || ''}"
                                        data-telefono="${prov.telefono || ''}"
                                        data-email="${prov.email || ''}"
                                        data-direccion="${prov.direccion || ''}">
                                        Seleccionar
                                    </button>
                                </td>
                                <td>${prov.nombre_proveedor}</td>
                                <td>${prov.empresa || ''}</td>
                                <td>${prov.celular || ''}</td>
                                <td>${prov.email || ''}</td>
                            </tr>
                        `);
                        });
                    }

                    $('#example2').DataTable({
                        "responsive": true,
                        "autoWidth": false,
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                        }
                    });
                })
                .catch(error => {
                    console.error("Error al cargar proveedores:", error);
                    $('#example2 tbody').html('<tr><td colspan="5" class="text-center text-danger">Error al cargar proveedores</td></tr>');
                });
        });

        $('#example2 tbody').on('click', '.select-proveedor', function() {
            const button = $(this);
            document.getElementById("id_proveedor").value = button.data('id-proveedor');
            document.getElementById("nombre_proveedor").value = button.data('nombre');
            document.getElementById("celular").value = button.data('celular');
            document.getElementById("telefono").value = button.data('telefono');
            document.getElementById("empresa").value = button.data('empresa');
            document.getElementById("email").value = button.data('email');
            document.getElementById("direccion").value = button.data('direccion');

            // WhatsApp
            if (button.data('celular')) {
                document.getElementById("celular_proveedor_link").href = `https://wa.me/57${button.data('celular')}`;
                document.getElementById("celular_proveedor_link").style.display = 'inline-block';
            } else {
                document.getElementById("celular_proveedor_link").style.display = 'none';
            }

            $('#modal-buscar_proveedor').modal('hide');
        });
    }

    function configurarModalProductos() {
        $('#modal-buscar_producto').on('show.bs.modal', function() {
            if ($.fn.DataTable.isDataTable('#example1')) {
                $('#example1').DataTable().destroy();
            }

            const timestamp = new Date().getTime();
            fetch(`${API_PRODUCTOS}?t=${timestamp}`)
                .then(res => {
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    return res.json();
                })
                .then(data => {
                    console.log("Productos cargados:", data);
                    let tbody = $('#example1 tbody');
                    tbody.empty();

                    if (data.length === 0) {
                        tbody.append('<tr><td colspan="5" class="text-center">No hay productos disponibles</td></tr>');
                    } else {
                        data.forEach(prod => {
                            tbody.append(`
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm select-producto"
                                        data-id-producto="${prod.id_producto}"
                                        data-codigo="${prod.codigo}"
                                        data-nombre="${prod.nombre}"
                                        data-descripcion="${prod.descripcion || ''}"
                                        data-stock="${prod.stock}"
                                        data-stock-minimo="${prod.stock_minimo || ''}"
                                        data-stock-maximo="${prod.stock_maximo || ''}"
                                        data-precio-compra="${prod.precio_compra}"
                                        data-precio-venta="${prod.precio_venta}"
                                        data-fecha-ingreso="${prod.fecha_ingreso || prod.fyh_creacion || ''}"
                                        data-imagen="${prod.imagen || ''}"
                                        data-categoria="${prod.categoria || ''}"
                                        data-usuario="${prod.nombres_usuario || ''}">
                                        Seleccionar
                                    </button>
                                </td>
                                <td>${prod.codigo}</td>
                                <td>${prod.nombre}</td>
                                <td>${prod.stock}</td>
                                <td>${prod.precio_compra}</td>
                            </tr>
                        `);
                        });
                    }

                    $('#example1').DataTable({
                        "responsive": true,
                        "autoWidth": false,
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                        }
                    });
                })
                .catch(error => {
                    console.error("Error al cargar productos:", error);
                    $('#example1 tbody').html('<tr><td colspan="5" class="text-center text-danger">Error al cargar productos</td></tr>');
                });
        });

        $('#example1 tbody').on('click', '.select-producto', function() {
            const button = $(this);
            document.getElementById("id_producto_main").value = button.data('id-producto');
            document.getElementById("codigo").value = button.data('codigo');
            document.getElementById("nombre_producto").value = button.data('nombre');
            document.getElementById("descripcio_producto").value = button.data('descripcion');
            document.getElementById("categoria").value = button.data('categoria');
            document.getElementById("usuario_producto").value = button.data('usuario');
            document.getElementById("stock").value = button.data('stock');
            document.getElementById("stock_minimo").value = button.data('stock-minimo');
            document.getElementById("stock_maximo").value = button.data('stock-maximo');
            document.getElementById("precio_compra").value = button.data('precio-compra');
            document.getElementById("precio_venta").value = button.data('precio-venta');
            document.getElementById("precio_unitario_compra").value = button.data('precio-compra');

            const fechaIngreso = button.data('fecha-ingreso') || '';
            document.getElementById("fecha_ingreso").value = fechaIngreso ? fechaIngreso.substring(0, 10) : '';

            const imagen = button.data('imagen');
            if (imagen) {
                document.getElementById("img_producto").src = `../almacen/img_productos/${imagen}`;
                document.getElementById("img_producto").style.display = 'block';
            } else {
                document.getElementById("img_producto").src = '';
                document.getElementById("img_producto").style.display = 'none';
            }

            $('#modal-buscar_producto').modal('hide');

            // Calcular total
            calcularTotal();
        });
    }

    /*  ACTUALIZAR COMPRA  */
    function actualizarCompra() {
        const idProveedor = document.getElementById("id_proveedor").value;
        const idProducto = document.getElementById("id_producto_main").value;
        const cantidad = document.getElementById("cantidad_producto_compra").value;
        const precioUnitario = document.getElementById("precio_unitario_compra").value;

        // Validaciones
        if (!idProveedor) {
            Swal.fire("Error", "Debe seleccionar un proveedor", "error");
            document.getElementById("proveedor-tab").click();
            return;
        }

        if (!idProducto) {
            Swal.fire("Error", "Debe seleccionar un producto", "error");
            document.getElementById("producto-tab").click();
            return;
        }

        if (!cantidad || cantidad <= 0) {
            Swal.fire("Error", "La cantidad debe ser mayor a 0", "error");
            document.getElementById("cantidad_producto_compra").focus();
            return;
        }

        if (!precioUnitario || precioUnitario <= 0) {
            Swal.fire("Error", "El precio unitario debe ser mayor a 0", "error");
            document.getElementById("precio_unitario_compra").focus();
            return;
        }

        const formData = {
            id_compra: idCompra,
            nro_compra: document.getElementById("nro_compra").value,
            fecha_compra: document.getElementById("fecha_compra").value,
            comprobante: document.getElementById("comprobante").value,
            total_compra: document.getElementById("total_compra").value,
            id_proveedor: idProveedor,
            productos: [{
                id_producto: idProducto,
                cantidad: cantidad,
                precio_compra: precioUnitario
            }]
        };

        console.log("Datos a enviar:", formData);

        Swal.fire({
            title: '¿Actualizar compra?',
            text: "¿Está seguro de actualizar esta compra?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(API_COMPRAS, {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify(formData)
                    })
                    .then(res => {
                        if (!res.ok) {
                            throw new Error(`HTTP error! status: ${res.status}`);
                        }
                        return res.json();
                    })
                    .then(data => {
                        console.log("Respuesta actualización:", data);
                        if (data.success) {
                            Swal.fire({
                                icon: "success",
                                title: "Actualizado",
                                text: "La compra fue actualizada correctamente",
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = "index.php";
                            });
                        } else {
                            Swal.fire("Error", data.error || "No se pudo actualizar la compra", "error");
                        }
                    })
                    .catch(error => {
                        console.error("Error en actualización:", error);
                        Swal.fire("Error", "Error al conectar con la API: " + error.message, "error");
                    });
            }
        });
    }
</script>