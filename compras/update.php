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
                                                    <input type="text" name="nro_compra" id="nro_compra" class="form-control" required disabled>
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
                                                    <input type="text" name="total_compra" id="total_compra" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="usuario_compra">Usuario que realizó la compra:</label>
                                                    <input type="text" id="usuario_compra" class="form-control" disabled>
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
                                                    <input type="text" id="nombre_proveedor" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="celular">Celular</label>
                                                    <input type="number" id="celular" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="telefono">Teléfono</label>
                                                    <input type="number" id="telefono" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="empresa">Empresa</label>
                                                    <input type="text" id="empresa" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" id="email" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="direccion">Dirección</label>
                                                    <input type="text" id="direccion" class="form-control" disabled>
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
                                                            <input type="text" class="form-control" id="codigo" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="categoria">Categoría:</label>
                                                            <input type="text" class="form-control" id="categoria" disabled>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="nombre_producto">Nombre del producto:</label>
                                                            <input type="text" name="nombre" id="nombre_producto" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="descripcio_producto">Descripción del producto:</label>
                                                            <textarea name="descripcion" id="descripcio_producto" cols="30" rows="2" class="form-control" disabled></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="stock">Stock:</label>
                                                            <input type="number" name="stock" id="stock" class="form-control" style="background-color: #fff819" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="precio_unitario_compra">Precio compra (ítem):</label>
                                                            <input type="number" name="precio_unitario_compra" id="precio_unitario_compra" class="form-control" step="0.01">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="cantidad_producto_compra">Cantidad (ítem):</label>
                                                            <input type="number" name="cantidad_producto_compra" id="cantidad_producto_compra" class="form-control" min="1">
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
                                                        <input type="text" class="form-control form-control-sm" id="usuario_producto" disabled>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="fecha_ingreso">Fecha de ingreso:</label>
                                                        <input type="date" name="fecha_ingreso" id="fecha_ingreso" class="form-control form-control-sm" disabled>
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
                                                                        <input type="number" name="stock_minimo" id="stock_minimo" class="form-control form-control-sm" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group mb-1">
                                                                        <label for="stock_maximo" class="mb-0">Stock máximo:</label>
                                                                        <input type="number" name="stock_maximo" id="stock_maximo" class="form-control form-control-sm" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group mb-1">
                                                                        <label for="precio_compra" class="mb-0">Precio compra (almacén):</label>
                                                                        <input type="number" name="precio_compra_almacen" id="precio_compra" class="form-control form-control-sm" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group mb-1">
                                                                        <label for="precio_venta" class="mb-0">Precio venta:</label>
                                                                        <input type="number" name="precio_venta" id="precio_venta" class="form-control form-control-sm" disabled>
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
    const API_COMPRAS = "../api/compras/index.php";
    const API_PROVEEDORES = "../api/compras/proveedores.php";
    const API_PRODUCTOS = "../api/compras/productos.php";
    const API_PRODUCTOS_BUSCAR = "../api/compras/buscar_productos.php";
    const idCompra = "<?php echo $id_compra_get; ?>";

    document.addEventListener("DOMContentLoaded", () => {
        cargarCompra();
        configurarModalProveedores();
        configurarModalProductos();

        document.getElementById("form-actualizar-compra").addEventListener("submit", function(e) {
            e.preventDefault();
            actualizarCompra();
        });
    });

    /*  CARGAR COMPRA  */
    function cargarCompra() {
        fetch(`${API_COMPRAS}?id=${idCompra}`)
            .then(res => res.json())
            .then(data => {
                if (data.success && data.data) {
                    llenarFormulario(data.data);
                } else {
                    Swal.fire("Error", data.error || "No se pudo cargar la compra", "error");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                Swal.fire("Error", "No se pudo cargar la compra", "error");
            });
    }

    function llenarFormulario(compra) {
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
            document.getElementById("celular_proveedor_link").href = `https://wa.me/57${compra.celular_proveedor || ''}`;
        

        if (compra.productos && compra.productos.length > 0) {
            const producto_compra = compra.productos[0];
            fetch(`${API_PRODUCTOS_BUSCAR}?id_producto=${producto_compra.id_producto}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success' && data.data) {
                        llenarDatosProducto(data.data, producto_compra);
                    } else {
                        Swal.fire("Error", "No se pudo cargar el producto", "error");
                    }
                })
                .catch(() => {
                    Swal.fire("Error", "Error al conectar con la API de productos", "error");
                });
        }
    }

    function llenarDatosProducto(producto, producto_compra) {
        document.getElementById("id_producto_main").value = producto.id_producto || '';
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
        document.getElementById("precio_unitario_compra").value = producto_compra.precio_compra || '';

        const fechaIngreso = producto.fyh_creacion || '';
        document.getElementById("fecha_ingreso").value = fechaIngreso ? fechaIngreso.substring(0, 10) : '';

        document.getElementById("img_producto").src = producto.imagen ?
            `../almacen/img_productos/${producto.imagen}` :
            "";
    }

    /*  MODALES  */
    function configurarModalProveedores() {
        $('#modal-buscar_proveedor').on('show.bs.modal', function() {
            if ($.fn.DataTable.isDataTable('#example2')) {
                $('#example2').DataTable().destroy();
            }
            fetch(API_PROVEEDORES)
                .then(res => res.json())
                .then(data => {
                    let tbody = $('#example2 tbody');
                    tbody.empty();
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
                    $('#example2').DataTable({
                        "responsive": true,
                        "autoWidth": false
                    });
                })
                .catch(error => console.error("Error al cargar proveedores:", error));
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
            document.getElementById("celular_proveedor_link").href =
                `https://wa.me/57${button.data('celular')}`;

            $('#modal-buscar_proveedor').modal('hide');
        });
    }

    $(document).ready(function() {
        let triggerElement;
        $('#modal-buscar_producto').on('show.bs.modal', function(event) {
            triggerElement = event.relatedTarget;
        });
        $('#modal-buscar_producto').on('hidden.bs.modal', function() {
            if (triggerElement) $(triggerElement).focus();
        });
    });

    function configurarModalProductos() {
        $('#modal-buscar_producto').on('show.bs.modal', function() {
            if ($.fn.DataTable.isDataTable('#example1')) {
                $('#example1').DataTable().destroy();
            }
            fetch(API_PRODUCTOS)
                .then(res => res.json())
                .then(data => {
                    let tbody = $('#example1 tbody');
                    tbody.empty();
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
                                    data-fecha-ingreso="${prod.fecha_ingreso || ''}"
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
                    $('#example1').DataTable({
                        "responsive": true,
                        "autoWidth": false
                    });
                })
                .catch(error => console.error("Error al cargar productos:", error));
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

            // Ahora se usa fecha_ingreso en vez de fyh_creacion
            const fechaIngreso = button.data('fecha-ingreso') || '';
            document.getElementById("fecha_ingreso").value = fechaIngreso ? fechaIngreso.substring(0, 10) : '';

            const imagen = button.data('imagen');
            document.getElementById("img_producto").src = imagen ? `../almacen/img_productos/${imagen}` : "";

            $('#modal-buscar_producto').modal('hide');
        });
    }

    /*  ACTUALIZAR COMPRA  */
    function actualizarCompra() {
        const formData = {
            id_compra: idCompra,
            nro_compra: document.getElementById("nro_compra").value,
            fecha_compra: document.getElementById("fecha_compra").value,
            comprobante: document.getElementById("comprobante").value,
            total_compra: document.getElementById("total_compra").value,
            id_proveedor: document.getElementById("id_proveedor").value,
            productos: [{
                id_producto: document.getElementById("id_producto_main").value,
                cantidad: document.getElementById("cantidad_producto_compra").value,
                precio_compra: document.getElementById("precio_unitario_compra").value
            }]
        };
        console.log(" formData enviado:", formData);

        fetch(API_COMPRAS, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(formData)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Actualizado",
                        text: "La compra fue actualizada correctamente",
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = "index.php"; // Redirección al listado
                    });
                } else {
                    Swal.fire("Error", data.error || "No se pudo actualizar la compra", "error");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                Swal.fire("Error", "Error al conectar con la API", "error");
            });
    }
</script>