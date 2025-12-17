<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
?>

<div class="content-wrapper">

    <!-- HEADER -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 d-flex justify-content-between align-items-center">
                    <h1 class="m-0">
                        <i class="fas fa-cash-register mr-2"></i> Listado de Ventas
                    </h1>
                    <a href="create.php" class="btn btn-success btn-sm">
                        <i class="fas fa-plus-circle mr-1"></i> Nueva Venta
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENIDO -->
    <div class="content">
        <div class="container-fluid">

            <!-- KPIs -->
            <div class="row mb-4">

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3 id="total-ventas">0</h3>
                            <p>Total Ventas Hoy</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 id="monto-total">COP$ 0.00</h3>
                            <p>Total Vendido Hoy</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                </div>

            </div>

            <!-- TABLA VENTAS -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-1"></i> Ventas Registradas
                    </h3>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Nro Venta</th>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Cliente</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Productos</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="ventas-body">
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        <i class="fas fa-spinner fa-spin"></i> Cargando ventas...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- RESUMEN DIARIO -->
            <div class="card card-success card-outline mt-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line mr-1"></i> Resumen de Ventas Diarias
                    </h3>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Cantidad de Ventas</th>
                                    <th class="text-center">Total Vendido</th>
                                </tr>
                            </thead>
                            <tbody id="resumen-diario-body">
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        Esperando datos...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- MODAL PRODUCTOS -->
<div class="modal fade" id="modal_productos_venta" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-boxes mr-2"></i> Productos de la Venta
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="alert alert-info">
                    Venta Nro: <strong id="modal_nro_venta_display"></strong>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="modal_productos_body"></tbody>
                        <tfoot>
                            <tr class="table-success">
                                <td colspan="4" class="text-right">Total:</td>
                                <td id="modal_total_venta">COP$ 0.00</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>

<!-- ===================== SCRIPTS ===================== -->
<script>
    $(document).ready(function() {

        /* =========================
           LISTAR VENTAS + KPIs
        ========================== */
        fetch("../api/ventas/listar.php")
            .then(res => res.json())
            .then(json => {

                if (json.status !== "success") return;

                let ventas = json.data;
                let totalVendido = 0;

                $("#ventas-body").empty();

                ventas.forEach((venta, i) => {

                    totalVendido += parseFloat(venta.total_pagado);

                    $("#ventas-body").append(`
                    <tr>
                        <td class="text-center">${i + 1}</td>
                        <td class="text-center">
                            <span class="badge badge-primary">${venta.nro_venta}</span>
                        </td>
                        <td class="text-center">${venta.fecha_venta}</td>
                        <td class="text-center">${venta.nombre_cliente}</td>
                        <td class="text-center">
                            <span class="badge badge-success">
                                COP$ ${parseFloat(venta.total_pagado).toFixed(2)}
                            </span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-outline-primary btn-sm ver-productos"
                                data-nro="${venta.nro_venta}"
                                data-productos='${JSON.stringify(venta.productos || [])}'>
                                <i class="fas fa-boxes"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            <a href="factura.php?id_venta=${venta.id_venta}"
                               target="_blank"
                               class="btn btn-outline-success btn-sm">
                                <i class="fas fa-print"></i>
                            </a>
                        </td>
                    </tr>
                `);
                });

                $("#total-ventas").text(ventas.length);
                $("#monto-total").text("COP$ " + totalVendido.toFixed(2));
            });

        /* =========================
           RESUMEN DIARIO (PUNTO 5)
        ========================== */
        fetch("../api/reportes/ventas_diarias.php")
            .then(res => res.json())
            .then(json => {

                if (json.status !== "success") return;

                let resumenBody = $("#resumen-diario-body");
                resumenBody.empty();

                json.data.forEach(dia => {
                    resumenBody.append(`
                    <tr>
                        <td class="text-center">${dia.fecha}</td>
                        <td class="text-center">${dia.cantidad_ventas}</td>
                        <td class="text-center">
                            <span class="badge badge-success">
                                COP$ ${parseFloat(dia.total_vendido).toFixed(2)}
                            </span>
                        </td>
                    </tr>
                `);
                });
            });

        /* =========================
           MODAL PRODUCTOS
        ========================== */
        $(document).on("click", ".ver-productos", function() {

            let productos = $(this).data("productos");
            let nro = $(this).data("nro");
            let total = 0;

            $("#modal_nro_venta_display").text(nro);
            $("#modal_productos_body").empty();

            productos.forEach((p, i) => {
                let subtotal = p.cantidad * p.precio_unitario;
                total += subtotal;

                $("#modal_productos_body").append(`
                <tr>
                    <td>${i + 1}</td>
                    <td>${p.nombre_producto}</td>
                    <td class="text-center">${p.cantidad}</td>
                    <td class="text-right">COP$ ${p.precio_unitario}</td>
                    <td class="text-right">COP$ ${subtotal.toFixed(2)}</td>
                </tr>
            `);
            });

            $("#modal_total_venta").text("COP$ " + total.toFixed(2));
            $("#modal_productos_venta").modal("show");
        });

    });
</script>