<?php
require_once('../app/config.php'); 

require_once('../layout/sesion.php'); // RUTA CORREGIDA para sesion.php
require_once('../layout/parte1.php'); // RUTA CORREGIDA para parte1.php

// Incluimos la lógica para listar productos y proveedores en los modales
require_once('../app/controllers/almacen/listado_de_productos.php');
require_once('../app/controllers/proveedores/listado_de_proveedores.php');
// El listado_de_compras no es necesario aquí para la creación

// Generar un número de compra para mostrar al usuario, puedes ajustar esta lógica
$query_max_nro_compra = $pdo->prepare("SELECT MAX(nro_compra) AS max_nro_compra FROM tb_compras");
$query_max_nro_compra->execute();
$resultado_max_nro_compra = $query_max_nro_compra->fetch(PDO::FETCH_ASSOC);
$max_nro_compra = $resultado_max_nro_compra['max_nro_compra'] ?? 0;
$siguiente_nro_compra = $max_nro_compra + 1;
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Registro de una nueva compra</h1>
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
                            <h3 class="card-title">Llene los datos con cuidado</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <!-- FORMULARIO DE CREACIÓN DE COMPRAS -->
                        <form action="../app/controllers/compras/create.php" method="POST">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nro_compra">Nro de Compra:</label>
                                            <input type="text" name="nro_compra" id="nro_compra" class="form-control" value="<?php echo htmlspecialchars($siguiente_nro_compra); ?>" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fecha_compra">Fecha de Compra:</label>
                                            <input type="date" name="fecha_compra" id="fecha_compra" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="comprobante">Comprobante:</label>
                                            <input type="text" name="comprobante" id="comprobante" class="form-control" placeholder="E.g. Factura A-123">
                                        </div>
                                    </div>
                                </div>

                                <!-- Campo oculto para el id_usuario (asumimos que viene de la sesión) -->
                                <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($_SESSION['id_usuario'] ?? ''); ?>">

                                <hr>
                                <!-- Sección de datos del proveedor -->
                                <div style="display: flex; align-items: center; margin-bottom: 15px;">
                                    <h5>Datos del proveedor </h5>
                                    <div style="width: 20px"></div>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-buscar_proveedor">
                                        <i class="fa fa-search"></i> Buscar proveedor
                                    </button>
                                </div>

                                <div class="container-fluid mb-4" style="font-size: 12px">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="hidden" name="id_proveedor" id="id_proveedor_input_hidden">
                                                <label for="nombre_proveedor_input">Nombre del proveedor </label>
                                                <input type="text" id="nombre_proveedor_input" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="celular_proveedor_input">Celular</label>
                                                <input type="number" id="celular_proveedor_input" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="telefono_proveedor_input">Teléfono</label>
                                                <input type="number" id="telefono_proveedor_input" class="form-control" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="empresa_proveedor_input">Empresa </label>
                                                <input type="text" id="empresa_proveedor_input" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email_proveedor_input">Email</label>
                                                <input type="email" id="email_proveedor_input" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="direccion_proveedor_input">Dirección</label>
                                                <textarea id="direccion_proveedor_input" cols="30" rows="3" class="form-control" disabled></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <!-- Sección para AÑADIR productos a la compra -->
                                <div style="display: flex; align-items: center; margin-bottom: 15px;">
                                    <h5>Productos a Comprar </h5>
                                    <div style="width: 20px"></div>
                                    <button type="button" class="btn btn-success btn-sm" id="add_product_btn" data-toggle="modal" data-target="#modal-buscar_producto">
                                        <i class="fa fa-plus"></i> Añadir Producto
                                    </button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="productos_table">
                                        <thead>
                                            <tr>
                                                <th>Código</th>
                                                <th>Producto</th>
                                                <th>Stock Actual</th>
                                                <th>P. Compra (Almacén)</th>
                                                <th>P. Unitario (Esta Compra)</th>
                                                <th>Cantidad</th>
                                                <th>Subtotal</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Las filas de productos se añadirán aquí con JavaScript -->
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6" class="text-right"><strong>TOTAL COMPRA:</strong></td>
                                                <td id="total_general_compra">0.00</td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <!-- Campo oculto donde se enviará el array JSON de productos al controlador -->
                                <input type="hidden" name="productos_comprados_json" id="productos_comprados_json">

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="btn_guardar_compra">Guardar Compra</button>
                                <a href="<?php echo $URL;?>/compras" class="btn btn-default">Cancelar</a>
                            </div>
                        </form>
                        <!-- /.FORMULARIO DE CREACIÓN DE COMPRAS -->
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- MODAL para buscar productos -->
<div class="modal fade" id="modal-buscar_producto">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1d36b6;color: white">
                <h4 class="modal-title">Búsqueda de productos para añadir a la compra</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table table-responsive">
                    <table id="example1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Nro</th>
                                <th>Seleccionar</th>
                                <th>Código</th>
                                <th>Categoría</th>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Stock</th>
                                <th>P. Compra</th>
                                <th>P. Venta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $contador_prod_modal = 0;
                            foreach ($productos_datos as $productos_dato){
                                $id_producto_modal = $productos_dato['id_producto']; ?>
                                <tr>
                                    <td><?php echo $contador_prod_modal = $contador_prod_modal + 1; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm add-product-to-list"
                                                data-id_producto="<?php echo htmlspecialchars($productos_dato['id_producto']);?>"
                                                data-codigo="<?php echo htmlspecialchars($productos_dato['codigo']);?>"
                                                data-nombre="<?php echo htmlspecialchars($productos_dato['nombre']);?>"
                                                data-stock_actual="<?php echo htmlspecialchars($productos_dato['stock']);?>"
                                                data-precio_compra_almacen="<?php echo htmlspecialchars($productos_dato['precio_compra']);?>">
                                            Añadir
                                        </button>
                                    </td>
                                    <td><?php echo htmlspecialchars($productos_dato['codigo']);?></td>
                                    <td><?php echo htmlspecialchars($productos_dato['nombre_categoria']);?></td>
                                    <td>
                                        <img src="<?php echo $URL."/almacen/img_productos/".htmlspecialchars($productos_dato['imagen']);?>" width="50px" alt="imagen producto">
                                    </td>
                                    <td><?php echo htmlspecialchars($productos_dato['nombre']);?></td>
                                    <td><?php echo htmlspecialchars($productos_dato['stock']);?></td>
                                    <td><?php echo htmlspecialchars($productos_dato['precio_compra']);?></td>
                                    <td><?php echo htmlspecialchars($productos_dato['precio_venta']);?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIN MODAL para buscar productos -->

<!-- MODAL para buscar proveedor -->
<div class="modal fade" id="modal-buscar_proveedor">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1d36b6;color: white">
                <h4 class="modal-title">Búsqueda de proveedor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table table-responsive">
                    <table id="example2" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th><center>Nro</center></th>
                                <th><center>Seleccionar</center></th>
                                <th><center>Nombre del proveedor</center></th>
                                <th><center>Celular</center></th>
                                <th><center>Teléfono</center></th>
                                <th><center>Empresa</center></th>
                                <th><center>Email</center></th>
                                <th><center>Dirección</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $contador_prov_modal = 0;
                            foreach ($proveedores_datos as $proveedores_dato) {
                                $id_proveedor_modal = $proveedores_dato['id_proveedor']; ?>
                                <tr>
                                    <td><center><?php echo $contador_prov_modal = $contador_prov_modal + 1; ?></center></td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm select-proveedor-btn"
                                                data-id_proveedor="<?php echo htmlspecialchars($proveedores_dato['id_proveedor']);?>"
                                                data-nombre_proveedor="<?php echo htmlspecialchars($proveedores_dato['nombre_proveedor']);?>"
                                                data-celular="<?php echo htmlspecialchars($proveedores_dato['celular']);?>"
                                                data-telefono="<?php echo htmlspecialchars($proveedores_dato['telefono']);?>"
                                                data-empresa="<?php echo htmlspecialchars($proveedores_dato['empresa']);?>"
                                                data-email="<?php echo htmlspecialchars($proveedores_dato['email']);?>"
                                                data-direccion="<?php echo htmlspecialchars($proveedores_dato['direccion']);?>">
                                            Seleccionar
                                        </button>
                                    </td>
                                    <td><?php echo htmlspecialchars($proveedores_dato['nombre_proveedor']); ?></td>
                                    <td>
                                        <a href="https://wa.me/591<?php echo htmlspecialchars($proveedores_dato['celular']); ?>" target="_blank" class="btn btn-success btn-sm">
                                            <i class="fa fa-phone"></i> <?php echo htmlspecialchars($proveedores_dato['celular']); ?>
                                        </a>
                                    </td>
                                    <td><?php echo htmlspecialchars($proveedores_dato['telefono']); ?></td>
                                    <td><?php echo htmlspecialchars($proveedores_dato['empresa']); ?></td>
                                    <td><?php echo htmlspecialchars($proveedores_dato['email']); ?></td>
                                    <td><?php echo htmlspecialchars($proveedores_dato['direccion']); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIN MODAL para buscar proveedor -->

<?php require_once ('../layout/mensajes.php'); ?>
<?php require_once ('../layout/parte2.php'); ?>

<script>
    // Array para almacenar los productos de la compra
    let productosCompra = [];

    // Función para renderizar la tabla de productos
    function renderizarTablaProductos() {
        const tbody = $('#productos_table tbody');
        tbody.empty(); // Limpiar tabla actual
        let totalGeneral = 0;

        productosCompra.forEach((producto, index) => {
            const subtotal = (parseFloat(producto.precio_unitario_compra) * parseInt(producto.cantidad_compra)).toFixed(2);
            totalGeneral += parseFloat(subtotal);

            const row = `
                <tr data-index="${index}">
                    <td>${producto.codigo}</td>
                    <td>${producto.nombre}</td>
                    <td>${producto.stock_actual}</td>
                    <td>${producto.precio_compra_almacen}</td>
                    <td><input type="number" class="form-control form-control-sm precio-unitario-compra" data-index="${index}" value="${producto.precio_unitario_compra}" step="0.01" min="0.01"></td>
                    <td><input type="number" class="form-control form-control-sm cantidad-producto-compra" data-index="${index}" value="${producto.cantidad_compra}" min="1"></td>
                    <td class="subtotal-producto">${subtotal}</td>
                    <td><button type="button" class="btn btn-danger btn-sm eliminar-producto-btn" data-index="${index}"><i class="fa fa-trash"></i></button></td>
                </tr>
            `;
            tbody.append(row);
        });

        $('#total_general_compra').text(totalGeneral.toFixed(2));
        // Actualizar el campo oculto JSON para el envío
        $('#productos_comprados_json').val(JSON.stringify(productosCompra));
    }

    // Evento para añadir producto desde el modal
    $(document).on('click', '.add-product-to-list', function() {
        const id_producto = $(this).data('id_producto');
        const codigo = $(this).data('codigo');
        const nombre = $(this).data('nombre');
        const stock_actual = $(this).data('stock_actual');
        const precio_compra_almacen = $(this).data('precio_compra_almacen');

        // Verificar si el producto ya está en la lista
        const productoExistente = productosCompra.find(p => p.id_producto === id_producto);
        if (productoExistente) {
            Swal.fire({
                icon: 'warning',
                title: 'Producto ya añadido',
                text: 'Este producto ya está en la lista de la compra. Puedes ajustar la cantidad.',
                showConfirmButton: false,
                timer: 2000
            });
            $('#modal-buscar_producto').modal('hide');
            return;
        }

        // Añadir el producto con cantidad y precio unitario iniciales
        productosCompra.push({
            id_producto: id_producto,
            codigo: codigo,
            nombre: nombre,
            stock_actual: stock_actual,
            precio_compra_almacen: precio_compra_almacen,
            precio_unitario_compra: precio_compra_almacen, // Precio inicial sugerido de almacén
            cantidad_compra: 1 // Cantidad inicial
        });

        renderizarTablaProductos();
        $('#modal-buscar_producto').modal('hide'); // Cerrar modal
    });

    // Evento para eliminar producto de la tabla
    $(document).on('click', '.eliminar-producto-btn', function() {
        const index = $(this).data('index');
        productosCompra.splice(index, 1); // Eliminar del array
        renderizarTablaProductos();
    });

    // Evento para cambiar cantidad o precio unitario
    $(document).on('change', '.cantidad-producto-compra, .precio-unitario-compra', function() {
        const index = $(this).data('index');
        const tipo = $(this).hasClass('cantidad-producto-compra') ? 'cantidad_compra' : 'precio_unitario_compra';
        let valor = $(this).val();

        // Validar que el valor sea numérico y positivo
        if (isNaN(valor) || parseFloat(valor) <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Valor inválido',
                text: 'La cantidad y el precio unitario deben ser números positivos.',
                showConfirmButton: false,
                timer: 2000
            });
            $(this).val(tipo === 'cantidad_compra' ? (productosCompra[index].cantidad_compra || 1) : (productosCompra[index].precio_unitario_compra || 0.01));
            valor = $(this).val(); 
        }


        productosCompra[index][tipo] = valor;
        renderizarTablaProductos();
    });

    // Evento para seleccionar proveedor desde el modal
    $(document).on('click', '.select-proveedor-btn', function() {
        $('#id_proveedor_input_hidden').val($(this).data('id_proveedor'));
        $('#nombre_proveedor_input').val($(this).data('nombre_proveedor'));
        $('#celular_proveedor_input').val($(this).data('celular'));
        $('#telefono_proveedor_input').val($(this).data('telefono'));
        $('#empresa_proveedor_input').val($(this).data('empresa'));
        $('#email_proveedor_input').val($(this).data('email'));
        $('#direccion_proveedor_input').val($(this).data('direccion'));
        $('#modal-buscar_proveedor').modal('hide');
    });

    // Inicializar la tabla DataTable para el modal de productos
    $(function () {
        $("#example1").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Productos",
                "infoEmpty": "Mostrando 0 a 0 de 0 Productos",
                "infoFiltered": "(Filtrado de _MAX_ total Productos)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Productos",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscador:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "responsive": true, "lengthChange": true, "autoWidth": false,
            buttons: [{
                extend: 'collection',
                text: 'Reportes',
                orientation: 'landscape',
                buttons: [{
                    text: 'Copiar',
                    extend: 'copy',
                }, {
                    extend: 'pdf'
                },{
                    extend: 'csv'
                },{
                    extend: 'excel'
                },{
                    text: 'Imprimir',
                    extend: 'print'
                }
                ]
            },
                {
                    extend: 'colvis',
                    text: 'Visor de columnas',
                    collectionLayout: 'fixed three-column'
                }
            ],
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        // Inicializar la tabla DataTable para el modal de proveedores
        $("#example2").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Proveedores",
                "infoEmpty": "Mostrando 0 a 0 de 0 Proveedores",
                "infoFiltered": "(Filtrado de _MAX_ total Proveedores)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Proveedores",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscador:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "responsive": true, "lengthChange": true, "autoWidth": false,
            buttons: [{
                extend: 'collection',
                text: 'Reportes',
                orientation: 'landscape',
                buttons: [{
                    text: 'Copiar',
                    extend: 'copy',
                }, {
                    extend: 'pdf'
                },{
                    extend: 'csv'
                },{
                    extend: 'excel'
                },{
                    text: 'Imprimir',
                    extend: 'print'
                }
                ]
            },
                {
                    extend: 'colvis',
                    text: 'Visor de columnas',
                    collectionLayout: 'fixed three-column'
                }
            ],
        }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
    });

    // Asegurarse de que el campo JSON se actualice antes de enviar el formulario
    $('#btn_guardar_compra').click(function(e) {
        if (productosCompra.length === 0) {
            e.preventDefault(); // Evitar el envío si no hay productos
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Debe añadir al menos un producto a la compra.',
                showConfirmButton: false,
                timer: 2500
            });
        } else if (!$('#id_proveedor_input_hidden').val()) {
            e.preventDefault(); // Evitar el envío si no hay proveedor
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Debe seleccionar un proveedor para la compra.',
                showConfirmButton: false,
                timer: 2500
            });
        } else {
            $('#productos_comprados_json').val(JSON.stringify(productosCompra));
        }
    });

    // Iniciar el renderizado de la tabla al cargar la página (estará vacía al inicio)
    renderizarTablaProductos();
</script>
