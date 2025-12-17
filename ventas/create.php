<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
?>

<!-- Content Wrapper -->
<div class="content-wrapper" style="background-color: #f8f9fa;">
    <!-- Header -->
    <div class="content-header">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h1 class="m-0"><i class="fas fa-cash-register mr-2"></i>Nueva Venta</h1>
            <div>
                <span class="badge badge-secondary"><?php echo date('d/m/Y'); ?></span>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Productos -->
                <div class="col-md-8">
                    <div class="card card-primary card-outline h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="fas fa-boxes mr-2"></i>Productos Disponibles</h5>
                        </div>
                        <div class="card-body p-2">
                            <div class="input-group mb-2">
                                <input type="text" id="buscar-producto" class="form-control" placeholder="Buscar producto...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                            <div class="row" id="lista-productos" style="max-height: 400px; overflow-y: auto;"></div>
                        </div>
                    </div>
                </div>

                <!-- Cliente y carrito -->
                <div class="col-md-4">
                    <!-- Cliente -->
                    <div class="card card-warning card-outline mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="fas fa-user mr-2"></i>Cliente</h5>
                        </div>
                        <div class="card-body p-2">
                            <select id="select-cliente" class="form-control mb-2">
                                <option value="">Seleccionar cliente...</option>
                            </select>
                            <div id="cliente-info" class="bg-light p-2 rounded" style="display: none;">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="font-weight-bold" id="cliente-nombre"></span>
                                    <span class="badge badge-success">Seleccionado</span>
                                </div>
                                <div class="small">
                                    <div>NIT/CI: <span id="cliente-nit"></span></div>
                                    <div>Tel: <span id="cliente-telefono"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Carrito -->
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="fas fa-shopping-cart mr-2"></i>Carrito de Venta</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                <table class="table table-sm table-hover mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Producto</th>
                                            <th width="80">Cant</th>
                                            <th width="80">Total</th>
                                            <th width="40"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="carrito-body">
                                        <tr id="carrito-vacio">
                                            <td colspan="4" class="text-center text-muted py-3">
                                                <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                                                <p class="mb-0">Carrito vacío</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="p-2 border-top">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="font-weight-bold">Subtotal:</span>
                                    <span id="subtotal">COP$ 0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="font-weight-bold text-success">Total:</span>
                                    <span id="total" class="font-weight-bold text-success">COP$ 0.00</span>
                                </div>
                                <button id="btn-pagar" class="btn btn-success btn-block" disabled>
                                    <i class="fas fa-credit-card mr-1"></i> Proceder al Pago
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Pago -->
<div class="modal fade" id="modal-pago">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-credit-card mr-2"></i>Procesar Pago</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success h4 mb-3 text-center" id="modal-total">COP$ 0.00</div>
                <div class="form-group">
                    <label>Forma de Pago:</label>
                    <select class="form-control" id="forma-pago"></select>
                </div>
                <div class="form-group">
                    <label>Monto Recibido:</label>
                    <input type="number" class="form-control" id="monto-recibido" step="0.01" min="0">
                </div>
                <div class="alert alert-info" id="cambio-info" style="display:none;">
                    <strong>Cambio:</strong> <span id="cambio-monto">COP$ 0.00</span>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button class="btn btn-success" id="btn-confirmar-pago" disabled>
                    <i class="fas fa-check mr-1"></i> Confirmar Pago
                </button>
            </div>
        </div>
    </div>
</div>

<?php include('../layout/parte2.php'); ?>
<script>
    $(document).ready(function() {
        let carrito = [];
        let totalVenta = 0;
        let clienteSeleccionado = null;

        // Consumir UNA sola API 
        fetch("../api/ventas/listar.php")
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    // Productos
                    if (Array.isArray(data.productos)) {
                        const cont = $("#lista-productos");
                        cont.empty();
                        data.productos.forEach(prod => {
                            cont.append(`
                          <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card product-card h-100"
                                 data-id="${prod.id_producto}"
                                 data-nombre="${prod.nombre}"
                                 data-precio="${prod.precio_venta}"
                                 data-stock="${prod.stock}">
                                <div class="card-body p-2 text-center">
                                    <img src="../almacen/img_productos/${prod.imagen}" class="img-fluid rounded mb-2" style="height:80px;object-fit:cover;">
                                    <h6 class="card-title mb-1">${prod.nombre}</h6>
                                    <p class="text-muted small mb-1">${prod.codigo}</p>
                                    <p class="text-success font-weight-bold mb-1">COP$ ${parseFloat(prod.precio_venta).toFixed(2)}</p>
                                    <span class="badge ${prod.stock > 5 ? 'badge-success':'badge-warning'}">Stock: ${prod.stock}</span>
                                    <button class="btn btn-sm btn-primary btn-block mt-2 add-to-cart"><i class="fas fa-cart-plus mr-1"></i>Agregar</button>
                                </div>
                            </div>
                          </div>
                      `);
                        });
                    }

                    // Clientes
                    if (Array.isArray(data.clientes)) {
                        const selClientes = $("#select-cliente");
                        selClientes.empty().append(`<option value="">Seleccione cliente</option>`);
                        data.clientes.forEach(c => {
                            selClientes.append(`<option value="${c.id_cliente}" data-nombre="${c.nombre_cliente}" data-nit="${c.nit_ci_cliente}" data-telefono="${c.celular_cliente}">${c.nombre_cliente} - ${c.nit_ci_cliente}</option>`);
                        });
                    }

                    //Formas de pago
                    if (Array.isArray(data.formas_pago)) {
                        const selPagos = $("#forma-pago");
                        selPagos.empty().append(`<option value="">Seleccione forma de pago</option>`);
                        data.formas_pago.forEach(fp => {
                            selPagos.append(`<option value="${fp.id_forma_pago}">${fp.nombre_forma_pago}</option>`);
                        });
                    }
                } else {
                    console.error("Error en API listar.php:", data.message);
                }
            })
            .catch(err => {
                console.error("Error al consumir API:", err);
            });

        //Seleccionar cliente 
        $("#select-cliente").on("change", function() {
            const opt = $(this).find("option:selected");
            if (opt.val()) {
                clienteSeleccionado = {
                    id: opt.val(),
                    nombre: opt.data("nombre"),
                    nit: opt.data("nit"),
                    telefono: opt.data("telefono")
                };
                $("#cliente-info").show();
                $("#cliente-nombre").text(clienteSeleccionado.nombre);
                $("#cliente-nit").text(clienteSeleccionado.nit);
                $("#cliente-telefono").text(clienteSeleccionado.telefono);
                $("#btn-pagar").prop("disabled", carrito.length === 0);
            } else {
                clienteSeleccionado = null;
                $("#cliente-info").hide();
                $("#btn-pagar").prop("disabled", true);
            }
        });

        //Agregar producto al carrito
        $(document).on("click", ".add-to-cart", function() {
            const card = $(this).closest(".product-card");
            const id = card.data("id");
            const nombre = card.data("nombre");
            const precio = parseFloat(card.data("precio"));
            const stock = parseInt(card.data("stock"));

            const item = carrito.find(p => p.id == id);
            if (item) {
                if (item.cantidad < stock) {
                    item.cantidad++;
                    item.total = item.cantidad * precio;
                } else {
                    alert("Stock insuficiente");
                    return;
                }
            } else {
                carrito.push({
                    id,
                    nombre,
                    precio,
                    cantidad: 1,
                    total: precio
                });
            }
            actualizarCarrito();
        });

        //Actualizar carrito
        function actualizarCarrito() {
            const tbody = $("#carrito-body");
            tbody.empty();
            let subtotal = 0;
            if (carrito.length === 0) {
                tbody.append(`<tr id="carrito-vacio"><td colspan="4" class="text-center text-muted py-3">Carrito vacío</td></tr>`);
                $("#btn-pagar").prop("disabled", true);
            } else {
                carrito.forEach((item, i) => {
                    subtotal += item.total;
                    tbody.append(`
                <tr>
                    <td>${item.nombre}</td>
                    <td><input type="number" min="1" value="${item.cantidad}" onchange="actualizarCantidad(${i}, this.value)"></td>
                    <td>COP$ ${item.total.toFixed(2)}</td>
                    <td><button class="btn btn-sm btn-danger" onclick="eliminarProducto(${i})"><i class="fas fa-trash"></i></button></td>
                </tr>
            `);
                });
                $("#btn-pagar").prop("disabled", false);
            }
            totalVenta = subtotal;
            $("#subtotal").text(`COP$ ${subtotal.toFixed(2)}`);
            $("#total").text(`COP$ ${totalVenta.toFixed(2)}`);
        }

        // Funciones globales para inputs dinámicos
        window.actualizarCantidad = function(i, val) {
            val = parseInt(val);
            if (val > 0) {
                carrito[i].cantidad = val;
                carrito[i].total = val * carrito[i].precio;
                actualizarCarrito();
            }
        };

        window.eliminarProducto = function(i) {
            carrito.splice(i, 1);
            actualizarCarrito();
        };

        //Abrir modal de pago
        $("#btn-pagar").click(function() {
            $("#modal-total").text(`COP$ ${totalVenta.toFixed(2)}`);
            $("#monto-recibido").val("");
            $("#cambio-info").hide();
            $("#btn-confirmar-pago").prop("disabled", true);
            $("#modal-pago").modal("show");
        });

        // Mostrar el total también en el input
        $("#monto-recibido").val(totalVenta.toFixed(2));

        // Calcular cambio
        $("#monto-recibido").on("input", function() {
            const monto = parseFloat($(this).val()) || 0;
            const cambio = monto - totalVenta;

            if (cambio >= 0) {
                $("#cambio-info").show();
                $("#cambio-monto").text(`COP$ ${cambio.toFixed(2)}`);
                $("#btn-confirmar-pago").prop("disabled", false);
            } else {
                $("#cambio-info").hide();
                $("#btn-confirmar-pago").prop("disabled", false);
            }
        });

        //Confirmar pago (registrar venta)
        $("#btn-confirmar-pago").click(function() {
            const subtotal = totalVenta;
            const iva = subtotal * 0.00; // aquí se suma el IVA
            const totalConIva = subtotal + iva;

            const payload = {
                id_cliente: clienteSeleccionado ? clienteSeleccionado.id : 9999,
                id_forma_pago: $("#forma-pago").val() || null,
                total: totalConIva,
                productos: carrito.map(p => ({
                    id: p.id,
                    cantidad: p.cantidad,
                    precio: p.precio,
                    total: p.total
                }))
            };

            // Loader simple
            $("#btn-confirmar-pago").prop("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Procesando...');

            fetch("../api/ventas/registrar.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(payload)
                })
                .then(res => res.json())
                .then(data => {
                    $("#btn-confirmar-pago").prop("disabled", false).html('<i class="fas fa-check mr-1"></i> Confirmar Pago');
                    if (data.status === "success") {
                        // Redirigir a factura con ID
                        window.location.href = "factura.php?id_venta=" + data.id_venta;
                    } else {
                        Swal.fire("Error", data.message || "No se pudo registrar la venta", "error");
                    }
                })
                .catch(err => {
                    console.error(err);
                    $("#btn-confirmar-pago").prop("disabled", false).html('<i class="fas fa-check mr-1"></i> Confirmar Pago');
                    Swal.fire("Error", "Error en la petición. Revisa la consola.", "error");
                });
        });

        // === Buscador de productos ===
        $("#buscar-producto").on("keyup", function() {
            const query = $(this).val().toLowerCase().trim();

            $("#lista-productos .product-card").each(function() {
                const nombre = $(this).data("nombre").toLowerCase();
                const codigo = $(this).find("p.text-muted").text().toLowerCase();

                if (nombre.includes(query) || codigo.includes(query)) {
                    $(this).closest(".col-md-6").show();
                } else {
                    $(this).closest(".col-md-6").hide();
                }
            });
        });

    });
</script>