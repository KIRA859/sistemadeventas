<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

// Incluimos el controlador para obtener todas las ventas
include('../app/controllers/ventas/listado_de_ventas.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Listado de ventas realizadas</h1>
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
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Ventas Registradas</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="table table-responsive">
                                <table id="example1" class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th><center>Nro</center></th>
                                            <th><center>Nro de Venta</center></th>
                                            <th><center>Fecha Venta</center></th>
                                            <th><center>Cliente</center></th>
                                            <th><center>Total Pagado</center></th>
                                            <th><center>Productos</center></th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        foreach ($ventas_datos as $ventas_dato) {
                                            $id_venta = $ventas_dato['id_venta'];
                                            $id_cliente = $ventas_dato['id_cliente'];
                                            $contador++;
                                        ?>
                                            <tr>
                                                <td><center><?php echo htmlspecialchars($contador); ?></center></td>
                                                <td><center><?php echo htmlspecialchars($ventas_dato['nro_venta']); ?></center></td>
                                                <td><center><?php echo htmlspecialchars($ventas_dato['fecha_venta']); ?></center></td>
                                                <td>
                                                    <center>
                                                        <!-- Modal de clientes existente -->
                                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal_clientes<?php echo htmlspecialchars($id_venta); ?>">
                                                            <i class="fa fa-user "></i> <?php echo htmlspecialchars($ventas_dato['nombre_cliente']); ?>
                                                        </button>

                                                        <div class="modal fade" id="modal_clientes<?php echo htmlspecialchars($id_venta); ?>" tabindex="-1" aria-labelledby="modalClienteLabel<?php echo htmlspecialchars($id_venta); ?>" aria-hidden="true">
                                                            <div class="modal-dialog modal-sm">
                                                                <div class="modal-content">
                                                                    <div class="modal-header" style="background-color: #cd6b25ff;color: white">
                                                                        <h4 class="modal-title" id="modalClienteLabel<?php echo htmlspecialchars($id_venta); ?>"><i class="fa fa-user"></i> Cliente</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <?php
                                                                    // Obtener datos del cliente para el modal
                                                                    $sql_clientes_modal = "SELECT * FROM tb_clientes WHERE id_cliente = :id_cliente";
                                                                    $query_clientes_modal = $pdo->prepare($sql_clientes_modal);
                                                                    $query_clientes_modal->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
                                                                    $query_clientes_modal->execute();
                                                                    $clientes_dato_modal = $query_clientes_modal->fetch(PDO::FETCH_ASSOC);

                                                                    $nombre_cliente_modal = $clientes_dato_modal['nombre_cliente'] ?? 'N/A';
                                                                    $nit_ci_cliente_modal = $clientes_dato_modal['nit_ci_cliente'] ?? 'N/A';
                                                                    $celular_cliente_modal = $clientes_dato_modal['celular_cliente'] ?? 'N/A';
                                                                    $email_cliente_modal = $clientes_dato_modal['email_cliente'] ?? 'N/A';
                                                                    ?>
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label><i class="fa fa-user"></i> Nombre del cliente</label>
                                                                            <input type="text" value="<?php echo htmlspecialchars($nombre_cliente_modal); ?>" class="form-control" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>NIT/CI del cliente</label>
                                                                            <input type="text" value="<?php echo htmlspecialchars($nit_ci_cliente_modal); ?>" class="form-control" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Celular del cliente</label>
                                                                            <input type="text" value="<?php echo htmlspecialchars($celular_cliente_modal); ?>" class="form-control" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Correo del cliente</label>
                                                                            <input type="email" value="<?php echo htmlspecialchars($email_cliente_modal); ?>" class="form-control" disabled>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer justify-content-between">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </center>
                                                </td>
                                                <td>
                                                    <center>
                                                        <button class="btn btn-primary "><?php echo "COP$" . htmlspecialchars(number_format($ventas_dato['total_pagado'], 2)); ?></button>
                                                    </center>
                                                </td>
                                                <td>
                                                    <center>
                                                        <!-- Botón para abrir el modal de productos de la venta (AJAX) -->
                                                        <button type="button" class="btn btn-primary btn-sm view-products-btn" data-toggle="modal" data-target="#modal_productos_venta" data-id_venta="<?php echo htmlspecialchars($id_venta); ?>" data-nro_venta="<?php echo htmlspecialchars($ventas_dato['nro_venta']); ?>">
                                                            <i class="fa fa-shopping-basket"></i> Ver Productos
                                                        </button>
                                                    </center>
                                                </td>
                                                <td>
                                                    <center>
                                                        <!-- Formulario para borrar la venta (POST) -->
                                                        <form action="../app/controllers/ventas/delete_venta.php" method="post" style="display:inline-block;" onsubmit="return confirm('¿Está seguro de que desea eliminar la venta Nro <?php echo htmlspecialchars($ventas_dato['nro_venta']); ?>? Esta acción es irreversible y revertirá el stock de productos.');">
                                                            <input type="hidden" name="id_venta" value="<?php echo htmlspecialchars($id_venta); ?>">
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar Venta"><i class="fa fa-trash"></i> Borrar</button>
                                                        </form>

                                                        <!-- Enlace para imprimir la factura (factura.php) -->
                                                        <a href="factura.php?id_venta=<?php echo htmlspecialchars($id_venta); ?>" class="btn btn-success btn-sm" title="Imprimir Factura" target="_blank"><i class="fa fa-print"></i> Imprimir</a>
                                                    </center>
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
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- MODAL para visualizar los productos de una venta específica (cargado via AJAX) -->
<div class="modal fade" id="modal_productos_venta" tabindex="-1" aria-labelledby="modalProductosVentaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #08c2ec;color: white">
                <h5 class="modal-title" id="modalProductosVentaLabel">Productos de la Venta Nro: <span id="modal_nro_venta_display"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="background-color: #e7e7e7;text-align:center;">Nro</th>
                                <th style="background-color: #e7e7e7;text-align:center;">Producto</th>
                                <th style="background-color: #e7e7e7;text-align:center;">Descripción</th>
                                <th style="background-color: #e7e7e7;text-align:center;">Cantidad</th>
                                <th style="background-color: #e7e7e7;text-align:center;">Precio Unitario</th>
                                <th style="background-color: #e7e7e7;text-align:center;">SubTotal</th>
                            </tr>
                        </thead>
                        <tbody id="modal_productos_body">
                            <!-- Los productos se cargarán aquí vía AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>

<script>
    $(function() {
        $("#example1").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Ventas",
                "infoEmpty": "Mostrando 0 a 0 de 0 Ventas",
                "infoFiltered": "(Filtrado de _MAX_ total Ventas)",
                "infoPostFix": "",
                "thousands": ".",
                "lengthMenu": "Mostrar _MENU_ Ventas",
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
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            buttons: [{
                extend: 'collection',
                text: 'Reportes',
                orientation: 'landscape',
                buttons: [{
                    text: 'Copiar',
                    extend: 'copy',
                }, {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4] // Columnas a exportar para PDF
                    }
                }, {
                    extend: 'csv',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                }, {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                }, {
                    text: 'Imprimir',
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                }]
            }, {
                extend: 'colvis',
                text: 'Visor de columnas',
                collectionLayout: 'fixed three-column'
            }],
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


        // Evento para cargar productos en el modal de productos de la venta (AJAX)
        $(document).on('click', '.view-products-btn', function() {
            var id_venta = $(this).data('id_venta');
            var nro_venta = $(this).data('nro_venta');

            $('#modal_nro_venta_display').text(nro_venta);
            $('#modal_productos_body').empty(); // Limpiar contenido anterior

            // Realizar una llamada AJAX para obtener los productos de esta venta
            $.ajax({
                url: '../app/controllers/ventas/cargar_productos_venta_ajax.php', // Controlador AJAX
                type: 'GET',
                data: { id_venta: id_venta },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success' && response.data.length > 0) {
                        var productosHtml = '';
                        var contador_modal_prod = 0;
                        $.each(response.data, function(index, producto) {
                            contador_modal_prod++;
                            var subtotal = parseFloat(producto.cantidad) * parseFloat(producto.precio_unitario);
                            productosHtml += `
                                <tr>
                                    <td>${contador_modal_prod}</td>
                                    <td>${producto.nombre_producto}</td>
                                    <td>${producto.descripcion_producto}</td>
                                    <td>${producto.cantidad}</td>
                                    <td>COP$${parseFloat(producto.precio_unitario).toFixed(2)}</td>
                                    <td>COP$${subtotal.toFixed(2)}</td>
                                </tr>
                            `;
                        });
                        $('#modal_productos_body').html(productosHtml);
                    } else {
                        $('#modal_productos_body').html('<tr><td colspan="6"><center>No hay productos para esta venta.</center></td></tr>');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error al cargar productos de la venta (AJAX):", textStatus, errorThrown);
                    console.error("Respuesta del servidor:", jqXHR.responseText);
                    $('#modal_productos_body').html('<tr><td colspan="6"><center>Error al cargar los productos.</center></td></tr>');
                }
            });
        });
    });
</script>
