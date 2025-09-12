<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 d-flex justify-content-between align-items-center">
                    <h1 class="m-0"><i class="fas fa-cash-register mr-2"></i>Listado de Ventas</h1>
                    <a href="create.php" class="btn btn-success btn-sm">
                        <i class="fas fa-plus-circle mr-1"></i> Nueva Venta
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3 id="total-ventas">0</h3>
                            <p>Total Ventas</p>
                        </div>
                        <div class="icon"><i class="fas fa-shopping-cart"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 id="monto-total">COP$ 0.00</h3>
                            <p>Total Vendido</p>
                        </div>
                        <div class="icon"><i class="fas fa-dollar-sign"></i></div>
                    </div>
                </div>
            </div>

            <!-- Tabla de ventas -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-list mr-1"></i>Ventas Registradas</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tabla-ventas" class="table table-hover table-striped">
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

        </div>
    </div>
</div>

<!-- Modal Productos -->
<div class="modal fade" id="modal_productos_venta" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-boxes mr-2"></i>Productos de la Venta</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i>Venta Nro: <strong id="modal_nro_venta_display"></strong>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="modal_productos_body">
                            <tr><td colspan="5" class="text-center">Seleccione una venta...</td></tr>
                        </tbody>
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

<script>
$(document).ready(function () {
    // === Cargar ventas desde API ===
    fetch("../api/ventas/listar.php")
      .then(res => res.json())
      .then(json => {
          console.log("Respuesta API:", json);

          if (json.status === "success" && Array.isArray(json.data)) {
              let ventas = json.data;
              let tbody = $("#ventas-body");
              tbody.empty();

              let totalVendido = 0;

              ventas.forEach((venta, i) => {
                  totalVendido += parseFloat(venta.total_pagado);

                  tbody.append(`
                      <tr>
                          <td class="text-center">${i + 1}</td>
                          <td class="text-center"><span class="badge badge-primary">${venta.nro_venta}</span></td>
                          <td class="text-center">
                              <small>${venta.fecha_venta}</small>
                          </td>
                          <td class="text-center">${venta.nombre_cliente}</td>
                          <td class="text-center">
                              <span class="badge badge-success">COP$ ${parseFloat(venta.total_pagado).toFixed(2)}</span>
                          </td>
                          <td class="text-center">
                              <button class="btn btn-outline-primary btn-sm ver-productos"
                                  data-nro="${venta.nro_venta}" 
                                  data-productos='${JSON.stringify(venta.productos || [])}'>
                                  <i class="fas fa-boxes"></i> Ver
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
          } else {
              $("#ventas-body").html(`<tr><td colspan="7" class="text-center text-danger">${json.message || "Error en la API"}</td></tr>`);
          }
      })
      .catch(err => {
          console.error("Error al consumir API:", err);
          $("#ventas-body").html(`<tr><td colspan="7" class="text-center text-danger">No se pudo conectar a la API</td></tr>`);
      });

    // === Ver productos de la venta ===
    $(document).on("click", ".ver-productos", function () {
        let nroVenta = $(this).data("nro");
        let productos = $(this).data("productos");

        $("#modal_nro_venta_display").text(nroVenta);
        let tbody = $("#modal_productos_body");
        tbody.empty();

        let total = 0;
        if (Array.isArray(productos) && productos.length > 0) {
            productos.forEach((p, i) => {
                let subtotal = p.cantidad * p.precio_unitario;
                total += subtotal;
                tbody.append(`
                    <tr>
                        <td>${i + 1}</td>
                        <td>${p.nombre_producto}</td>
                        <td class="text-center">${p.cantidad}</td>
                        <td class="text-right">COP$ ${parseFloat(p.precio_unitario).toFixed(2)}</td>
                        <td class="text-right">COP$ ${subtotal.toFixed(2)}</td>
                    </tr>
                `);
            });
        } else {
            tbody.append(`<tr><td colspan="5" class="text-center text-muted">No hay productos registrados</td></tr>`);
        }

        $("#modal_total_venta").text("COP$ " + total.toFixed(2));
        $("#modal_productos_venta").modal("show");
    });
});
</script>
