<?php
include ('../app/config.php');
include ('../layout/sesion.php');
include ('../layout/parte1.php');
include ('../app/controllers/almacen/listado_de_productos.php');
include ('../app/controllers/clientes/listado_de_clientes.php');
include ('../app/controllers/estados_venta/listado_de_estados_venta.php');
include ('../app/controllers/ventas/listado_de_ventas.php'); 
include ('../app/controllers/ventas/listado_de_formas_pago.php'); 


// Generar un número de venta para mostrar al usuario
$query_max_nro_venta = $pdo->prepare("SELECT MAX(nro_venta) AS max_nro_venta FROM tb_ventas");
$query_max_nro_venta->execute();
$resultado_max_nro_venta = $query_max_nro_venta->fetch(PDO::FETCH_ASSOC);
$max_nro_venta = $resultado_max_nro_venta['max_nro_venta'] ?? 0;
$siguiente_nro_venta = $max_nro_venta + 1;
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Registro de una nueva Venta</h1>
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
                            <h3 class="card-title"><i class="fa fa-shopping-bag"></i> Venta Nro
                                <input type="text" style="text-align: center;" value="<?php echo htmlspecialchars($siguiente_nro_venta); ?>" disabled>
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <form action="../app/controllers/ventas/create.php" method="POST" id="form_registrar_venta_final">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nro_venta">Nro de Venta:</label>
                                            <input type="text" name="nro_venta" id="nro_venta" class="form-control" value="<?php echo htmlspecialchars($siguiente_nro_venta); ?>" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fecha_venta">Fecha de Venta:</label>
                                            <input type="date" name="fecha_venta" id="fecha_venta" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="id_forma_pago">Forma de Pago:</label>
                                            <select name="id_forma_pago" id="id_forma_pago" class="form-control" >
                                                <?php foreach ($formas_pago_datos as $forma_pago): ?>
                                                    <option value="<?php echo htmlspecialchars($forma_pago['id_forma_pago']); ?>">
                                                        <?php echo htmlspecialchars($forma_pago['nombre_forma_pago']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Campo oculto para el id_usuario (asumimos que viene de la sesión) -->
                                <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($_SESSION['id_usuario'] ?? ''); ?>">
                                <!-- Campo oculto para el estado de la venta (por defecto a 'Pendiente' o similar) -->
                                <input type="hidden" name="id_estado" value="1"> <!-- Asume que ID 1 es 'Pendiente' -->

                                <hr>
                                <!-- Sección de datos del cliente -->
                                <div style="display: flex; align-items: center; margin-bottom: 15px;">
                                    <h5>Datos del Cliente </h5>
                                    <div style="width: 20px"></div>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-buscar_cliente">
                                        <i class="fa fa-search"></i> Buscar Cliente
                                    </button>
                                </div>

                                <div class="container-fluid mb-4" style="font-size: 12px">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="hidden" name="id_cliente" id="id_cliente_input_hidden">
                                                <label for="nombre_cliente_input">Nombre del Cliente </label>
                                                <input type="text" id="nombre_cliente_input" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nit_ci_cliente_input">NIT/CI</label>
                                                <input type="text" id="nit_ci_cliente_input" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="celular_cliente_input">Celular</label>
                                                <input type="number" id="celular_cliente_input" class="form-control" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email_cliente_input">Email</label>
                                                <input type="email" id="email_cliente_input" class="form-control" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <!-- Sección para AÑADIR productos a la venta -->
                                <div style="display: flex; align-items: center; margin-bottom: 15px;">
                                    <h5>Productos a Vender </h5>
                                    <div style="width: 20px"></div>
                                    <button type="button" class="btn btn-success btn-sm" id="add_product_btn" data-toggle="modal" data-target="#modal-buscar_producto">
                                        <i class="fa fa-plus"></i> Añadir Producto
                                    </button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #e7e7e7;text-align:center;">Nro</th>
                                                <th style="background-color: #e7e7e7;text-align:center;">Producto</th>
                                                <th style="background-color: #e7e7e7;text-align:center;">Detalle</th>
                                                <th style="background-color: #e7e7e7;text-align:center;">Cantidad</th>
                                                <th style="background-color: #e7e7e7;text-align:center;">Precio Unitario</th>
                                                <th style="background-color: #e7e7e7;text-align:center;">Precio SubTotal</th>
                                                <th style="background-color: #e7e7e7;text-align:center;">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            //Definimos variables
                                            $contador_de_carrito = 0;
                                            $cantidad_total_carrito = 0;
                                            $precio_unitario_total_carrito = 0;
                                            $precio_total_carrito = 0;
                                            $nro_venta_carrito = $siguiente_nro_venta;
                                            $sql_carrito = "SELECT carr.id_carrito, carr.cantidad, pro.id_producto, pro.nombre as nombre_producto, pro.descripcion, pro.precio_venta as precio_venta_almacen, pro.stock as stock_actual
                                                            FROM tb_carrito as carr
                                                            INNER JOIN tb_almacen as pro ON carr.id_producto = pro.id_producto
                                                            WHERE carr.nro_venta = :nro_venta_carrito
                                                            ORDER BY id_carrito ASC";
                                            $query_carrito = $pdo->prepare($sql_carrito);
                                            $query_carrito->bindParam(':nro_venta_carrito', $nro_venta_carrito, PDO::PARAM_INT);
                                            $query_carrito->execute();
                                            $carrito_datos = $query_carrito->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($carrito_datos as $carrito_dato) {
                                                $id_carrito = $carrito_dato['id_carrito'];
                                                $contador_de_carrito++;
                                                $cantidad_total_carrito += $carrito_dato['cantidad'];
                                                $precio_unitario_total_carrito += floatval($carrito_dato['precio_venta_almacen']);

                                                $cantidad = floatval($carrito_dato['cantidad']);
                                                $precio_venta = floatval($carrito_dato['precio_venta_almacen']);
                                                $sub_total = $cantidad * $precio_venta;
                                                $precio_total_carrito += $sub_total;
                                            ?>
                                                <tr>
                                                    <td>
                                                        <center><?php echo htmlspecialchars($contador_de_carrito); ?></center>
                                                        <input type="hidden" value="<?php echo htmlspecialchars($carrito_dato['id_producto']); ?>" name="id_producto_en_carrito[]">
                                                    </td>
                                                    <td><?php echo htmlspecialchars($carrito_dato['nombre_producto']); ?></td>
                                                    <td><?php echo htmlspecialchars($carrito_dato['descripcion']); ?></td>
                                                    <td>
                                                        <center>
                                                            <span id="cantidad_carrito<?php echo htmlspecialchars($contador_de_carrito); ?>"><?php echo htmlspecialchars($carrito_dato['cantidad']); ?></span>
                                                        </center>
                                                        <input type="hidden" value="<?php echo htmlspecialchars($carrito_dato['stock_actual']); ?>" id="stock_de_inventario<?php echo htmlspecialchars($contador_de_carrito); ?>">
                                                        <input type="hidden" name="cantidad_en_carrito[]" value="<?php echo htmlspecialchars($carrito_dato['cantidad']); ?>">
                                                    </td>
                                                    <td>
                                                        <center><?php echo htmlspecialchars(number_format($precio_venta, 2)); ?></center>
                                                        <input type="hidden" name="precio_unitario_en_carrito[]" value="<?php echo htmlspecialchars($precio_venta); ?>">
                                                    </td>
                                                    <td>
                                                        <center><?php echo htmlspecialchars(number_format($sub_total, 2)); ?></center>
                                                        <input type="hidden" name="subtotal_en_carrito[]" value="<?php echo htmlspecialchars($sub_total); ?>">
                                                    </td>
                                                    <td>
                                                        <center>
                                                            <form action="../app/controllers/ventas/borrar_carrito.php" method="post" class="form-borrar-carrito">
                                                                <input type="hidden" name="id_carrito" value="<?php echo htmlspecialchars($id_carrito); ?>">
                                                                <input type="hidden" name="nro_venta_actual" value="<?php echo htmlspecialchars($nro_venta_carrito); ?>">
                                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Borrar</button>
                                                            </form>
                                                        </center>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3" style="background-color: #e7e7e7; text-align: right;">Total</th>
                                                <th>
                                                    <center> <?php echo htmlspecialchars($cantidad_total_carrito); ?></center>
                                                </th>
                                                <th>
                                                    <center><?php echo htmlspecialchars(number_format($precio_unitario_total_carrito, 2)); ?></center>
                                                </th>
                                                <th style="background-color: #fff819;">
                                                    <center><span id="total_venta_display"><?php echo htmlspecialchars(number_format($precio_total_carrito, 2)); ?></span></center>
                                                    <input type="hidden" name="total_pagado_final" id="total_pagado_final_input" value="<?php echo htmlspecialchars($precio_total_carrito, ENT_QUOTES, 'UTF-8'); ?>">
                                                </th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="monto_recibido_input">Monto Recibido:</label>
                                            <input type="number" step="0.01" min="0" name="monto_recibido" id="monto_recibido_input" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Cambio:</label>
                                            <p class="form-control-static" id="cambio_display">0.00</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="btn_guardar_venta_final">Registrar Venta</button>
                                <a href="<?php echo $URL;?>/ventas" class="btn btn-default">Cancelar</a>
                            </div>
                        </form>
                        <!-- /.FORMULARIO DE CREACIÓN DE VENTAS -->
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
                <h4 class="modal-title">Búsqueda de producto</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table table-responsive">
                    <table id="example1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th><center>Nro</center></th>
                                <th><center>Seleccionar</center></th>
                                <th><center>Código</center></th>
                                <th><center>Categoría</center></th>
                                <th><center>Imagen</center></th>
                                <th><center>Nombre</center></th>
                                <th><center>Stock</center></th>
                                <th><center>Precio compra</center></th>
                                <th><center>Precio venta</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $contador_prod_modal = 0;
                            foreach ($productos_datos as $productos_dato){
                                $id_producto_modal = $productos_dato['id_producto']; ?>
                                <tr>
                                    <td><center><?php echo htmlspecialchars($contador_prod_modal = $contador_prod_modal + 1); ?></center></td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm select-product-to-add"
                                                data-id_producto="<?php echo htmlspecialchars($productos_dato['id_producto']);?>"
                                                data-codigo="<?php echo htmlspecialchars($productos_dato['codigo']);?>"
                                                data-nombre="<?php echo htmlspecialchars($productos_dato['nombre']);?>"
                                                data-descripcion="<?php echo htmlspecialchars($productos_dato['descripcion']);?>"
                                                data-stock="<?php echo htmlspecialchars($productos_dato['stock']);?>"
                                                data-precio_venta="<?php echo htmlspecialchars($productos_dato['precio_venta']);?>">
                                            Seleccionar
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
                <!-- Input temporal para añadir al carrito -->
                <div class="row mt-4">
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="hidden" id="id_producto_selected">
                            <label for="producto_selected">Producto</label>
                            <input type="text" id="producto_selected" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="descripcion_selected">Descripción</label>
                            <input type="text" id="descripcion_selected" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="cantidad_selected">Cantidad</label>
                            <input type="number" id="cantidad_selected" class="form-control" min="1" value="1">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="precio_venta_selected">P. Unitario</label>
                            <input type="text" id="precio_venta_selected" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <button type="button" style="float: right;" id="btn_registrar_carrito" class="btn btn-primary">Añadir al Carrito</button>
                <div id="respuesta_carrito"></div>
            </div>
        </div>
    </div>
</div>
<!-- FIN MODAL para buscar productos -->

<!-- MODAL para buscar cliente -->
<div class="modal fade" id="modal-buscar_cliente">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1d36b6;color: white">
                <h4 class="modal-title">Búsqueda de cliente </h4>
                <div style="width:10px;"></div>
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-agregar_cliente">
                    <i class="fa fa-users"></i> Agregar nuevo cliente
                </button>
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
                                <th><center>Nombre del cliente</center></th>
                                <th><center>NIT_CI</center></th>
                                <th><center>Telefono</center></th>
                                <th><center>Correo</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $contador_cli_modal = 0;
                            foreach ($clientes_datos as $cliente_dato) {
                                $id_cliente_modal = $cliente_dato['id_cliente']; ?>
                                <tr>
                                    <td><center><?php echo htmlspecialchars($contador_cli_modal = $contador_cli_modal + 1); ?></center></td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm select-cliente-btn"
                                                data-id_cliente="<?php echo htmlspecialchars($cliente_dato['id_cliente']);?>"
                                                data-nombre_cliente="<?php echo htmlspecialchars($cliente_dato['nombre_cliente']);?>"
                                                data-nit_ci_cliente="<?php echo htmlspecialchars($cliente_dato['nit_ci_cliente']);?>"
                                                data-celular_cliente="<?php echo htmlspecialchars($cliente_dato['celular_cliente']);?>"
                                                data-email_cliente="<?php echo htmlspecialchars($cliente_dato['email_cliente']);?>">
                                            Seleccionar
                                        </button>
                                    </td>
                                    <td><?php echo htmlspecialchars($cliente_dato['nombre_cliente']); ?></td>
                                    <td>
                                        <center><?php echo htmlspecialchars($cliente_dato['nit_ci_cliente']); ?></center>
                                    </td>
                                    <td>
                                        <center>
                                            <a href="https://wa.me/591<?php echo htmlspecialchars($cliente_dato['celular_cliente']); ?>" target="_blank" class="btn btn-success btn-sm">
                                                <i class="fa fa-phone"></i> <?php echo htmlspecialchars($cliente_dato['celular_cliente']); ?>
                                            </a>
                                        </center>
                                    </td>
                                    <td>
                                        <center><?php echo htmlspecialchars($cliente_dato['email_cliente']); ?></center>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIN MODAL para buscar cliente -->

<!-- MODAL para agregar nuevo cliente (si lo necesitas, actualmente no está definido) -->
<!-- Puedes añadir un modal similar al de productos o clientes aquí si tienes un formulario para crear nuevos clientes -->
<div class="modal fade" id="modal-agregar_cliente">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h4 class="modal-title">Agregar Nuevo Cliente</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Aquí irá el formulario para agregar un nuevo cliente.</p>
                <!-- Aquí podrías incluir un formulario para crear clientes -->
                <!-- Por ahora, es un placeholder -->
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <!-- <button type="button" class="btn btn-primary">Guardar Cliente</button> -->
            </div>
        </div>
    </div>
</div>


<?php include ('../layout/mensajes.php'); ?>
<?php include ('../layout/parte2.php'); ?>

<script>
    // Función para calcular y mostrar el cambio
    function calcularCambio() {
        const totalVentaStr = $('#total_venta_display').text().replace(/[^0-9.-]+/g, ""); // Eliminar todo excepto números, puntos y guiones
        const totalVenta = parseFloat(totalVentaStr);
        const montoRecibido = parseFloat($('#monto_recibido_input').val());

        console.log('Calcular Cambio - Total Venta:', totalVenta);
        console.log('Calcular Cambio - Monto Recibido:', montoRecibido);

        if (isNaN(totalVenta) || isNaN(montoRecibido)) {
            $('#cambio_display').text('0.00');
            return;
        }

        const cambio = montoRecibido - totalVenta;
        $('#cambio_display').text(cambio.toFixed(2));
    }

    // Evento para seleccionar un producto en el modal y rellenar los campos temporales
    $(document).on('click', '.select-product-to-add', function() {
        $('#id_producto_selected').val($(this).data('id_producto'));
        $('#producto_selected').val($(this).data('nombre'));
        $('#descripcion_selected').val($(this).data('descripcion'));
        $('#cantidad_selected').val(1); // Reiniciar cantidad a 1
        $('#precio_venta_selected').val($(this).data('precio_venta'));
        $('#cantidad_selected').attr('max', $(this).data('stock')); // Establecer el máximo de la cantidad al stock disponible

        console.log('Producto Seleccionado en Modal:');
        console.log('id_producto_selected:', $('#id_producto_selected').val());
        console.log('producto_selected:', $('#producto_selected').val());
        console.log('cantidad_selected (initial):', $('#cantidad_selected').val());
        console.log('precio_venta_selected:', $('#precio_venta_selected').val());
        console.log('stock_disponible (max):', $('#cantidad_selected').attr('max'));
    });

    // Evento para añadir producto al carrito (AJAX)
    $('#btn_registrar_carrito').click(function(e) {
        e.preventDefault(); // Prevenir el envío del formulario principal

        var nro_venta = <?php echo json_encode($siguiente_nro_venta); ?>; // Usar json_encode para pasar PHP a JS de forma segura
        var id_producto = $('#id_producto_selected').val();
        var cantidad = $('#cantidad_selected').val();
        var stock_disponible = $('#cantidad_selected').attr('max');

        // --- INICIO DEPURACIÓN JS (AJAX call) ---
        console.log('Depuración AJAX Carrito - Envío:');
        console.log('nro_venta:', nro_venta, 'Tipo:', typeof nro_venta);
        console.log('id_producto:', id_producto, 'Tipo:', typeof id_producto);
        console.log('cantidad:', cantidad, 'Tipo:', typeof cantidad);
        console.log('stock_disponible:', stock_disponible, 'Tipo:', typeof stock_disponible);
        // --- FIN DEPURACIÓN JS ---

        if (id_producto === "") {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Debe seleccionar un producto.'
            });
            return;
        }

        if (cantidad === "" || parseInt(cantidad) <= 0 || isNaN(parseInt(cantidad))) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'La cantidad debe ser un número positivo y válido.'
            });
            return;
        }

        if (parseInt(cantidad) > parseInt(stock_disponible)) {
            Swal.fire({
                icon: 'warning',
                title: 'Stock insuficiente',
                text: `La cantidad solicitada (${cantidad}) excede el stock disponible (${stock_disponible}).`
            });
            return;
        }

        // AJAX para registrar en tb_carrito
        var url = "../app/controllers/ventas/registrar_carrito.php";
        $.get(url, {
            nro_venta: nro_venta,
            id_producto: id_producto,
            cantidad: cantidad
        }, function(datos) {
            Swal.fire({
                icon: 'success',
                title: 'Producto añadido',
                text: 'El producto se ha añadido al carrito.'
            });
            $('#modal-buscar_producto').modal('hide');
            // Recargar la página o actualizar solo la tabla del carrito para ver los cambios
            location.reload();
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error al añadir al carrito:", textStatus, errorThrown);
            console.error("Respuesta del servidor:", jqXHR.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error de servidor',
                text: 'Hubo un problema al añadir el producto al carrito. ' + jqXHR.responseText
            });
        });
    });

    // Evento para seleccionar cliente desde el modal
    $(document).on('click', '.select-cliente-btn', function() {
        $('#id_cliente_input_hidden').val($(this).data('id_cliente'));
        $('#nombre_cliente_input').val($(this).data('nombre_cliente'));
        $('#nit_ci_cliente_input').val($(this).data('nit_ci_cliente'));
        $('#celular_cliente_input').val($(this).data('celular_cliente'));
        $('#email_cliente_input').val($(this).data('email_cliente'));
        $('#modal-buscar_cliente').modal('hide');

        console.log('Cliente Seleccionado:');
        console.log('id_cliente_input_hidden:', $('#id_cliente_input_hidden').val());
        console.log('nombre_cliente_input:', $('#nombre_cliente_input').val());
    });

    // Asegurarse de que se realice la validación final antes de enviar el formulario de venta
    $('#form_registrar_venta_final').submit(function(e) {
        var id_cliente = $('#id_cliente_input_hidden').val();
        if (id_cliente === "") {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Debe seleccionar un cliente para registrar la venta.'
            });
            return;
        }

        // Verificar si hay productos en el carrito temporal
        var num_productos_en_carrito = <?php echo count($carrito_datos); ?>;
        console.log('Num productos en carrito al enviar:', num_productos_en_carrito);
        if (num_productos_en_carrito === 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Debe añadir al menos un producto a la venta.'
            });
            return;
        }

        // Validar que el monto recibido sea suficiente
        const totalVentaStr = $('#total_venta_display').text().replace(/[^0-9.-]+/g, "");
        const totalVenta = parseFloat(totalVentaStr);
        const montoRecibido = parseFloat($('#monto_recibido_input').val());

        console.log('Validación final - Total Venta:', totalVenta);
        console.log('Validación final - Monto Recibido:', montoRecibido);

        if (isNaN(montoRecibido) || montoRecibido < totalVenta) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error de Pago',
                text: 'El monto recibido es insuficiente o inválido.'
            });
            return;
        }

        // Si todo está bien, el formulario se enviará
        Swal.fire({
            icon: 'info',
            title: 'Procesando Venta',
            text: 'Registrando la venta, por favor espere...',
            showConfirmButton: false,
            allowOutsideClick: false
        });
    });


    // Inicializar DataTables para los modales
    $(function () {
        $("#example1").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Productos",
                "infoEmpty": "Mostrando 0 a 0 de 0 Productos",
                "infoFiltered": "(Filtrado de _MAX_ total Productos)",
                "infoPostFix": "",
                "thousands": ".", // Usar punto como separador de miles
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

        $("#example2").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Clientes",
                "infoEmpty": "Mostrando 0 a 0 de 0 Clientes",
                "infoFiltered": "(Filtrado de _MAX_ total Clientes)",
                "infoPostFix": "",
                "thousands": ".", // Usar punto como separador de miles
                "lengthMenu": "Mostrar _MENU_ Clientes",
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

        // Inicializar el cálculo del cambio al cargar la página y cada vez que cambia el monto recibido
        calcularCambio();
        $('#monto_recibido_input').on('input', calcularCambio);
    });
</script>
