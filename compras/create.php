<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Registrar Compra</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <form id="form_compra">
                <input type="hidden" name="id_usuario" value="<?php echo $id_usuario_sesion; ?>">

                <div class="row">
                    <!-- Datos de proveedor -->
                    <div class="col-md-6">
                        <div class="card card-outline card-primary">
                            <div class="card-header">Proveedor</div>
                            <div class="card-body">
                                <input type="hidden" id="id_proveedor_input_hidden">
                                <div class="input-group mb-3">
                                    <input type="text" id="proveedor_nombre" class="form-control" placeholder="Seleccione proveedor" readonly>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-buscar_proveedor">Buscar</button>
                                    </div>
                                </div>
                                <div id="proveedor_info"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Datos de compra -->
                    <div class="col-md-6">
                        <div class="card card-outline card-primary">
                            <div class="card-header">Datos de Compra</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nro_compra">Nro de Compra</label>
                                    <input type="text" id="nro_compra" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="fecha_compra">Fecha</label>
                                    <input type="date" id="fecha_compra" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="comprobante">Comprobante</label>
                                    <input type="text" id="comprobante" class="form-control" placeholder="Ej: Factura 123">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Productos -->
                <div class="card card-outline card-success mt-3">
                    <div class="card-header">Productos</div>
                    <div class="card-body">
                        <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modal-buscar_producto">Añadir Producto</button>
                        <table class="table table-bordered" id="tabla_compra">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="detalle_compra"></tbody>
                        </table>
                        <h4 class="text-right">Total: <span id="total_general_compra">0</span></h4>
                    </div>
                </div>

                <!-- Botón guardar -->
                <div class="mt-3 text-right">
                    <button type="submit" class="btn btn-primary" id="btn_guardar_compra">Guardar Compra</button>
                </div>
            </form>
        </div>
    </section>
</div>

<!-- Modal buscar proveedor -->
<div class="modal fade" id="modal-buscar_proveedor">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Seleccionar Proveedor</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" id="tabla_proveedores">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Acción</th>
                            <th>Nombre</th>
                            <th>NIT</th>
                            <th>Dirección</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal buscar producto -->
<div class="modal fade" id="modal-buscar_producto">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Seleccionar Producto</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" id="tabla_productos">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Acción</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Stock</th>
                            <th>Precio Compra</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('../layout/parte2.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let productosCompra = [];

    // Obtener número de compra
    fetch('../api/compras/index.php?action=get_max_nro')
        .then(res => res.json())
        .then(data => {
            if (data.success && data.max_nro !== null) {
                document.getElementById('nro_compra').value = data.max_nro + 1;
            } else {
                document.getElementById('nro_compra').value = 1;
            }
        })
        .catch(error => {
            console.error('Error al obtener número de compra:', error);
            document.getElementById('nro_compra').value = 1;
        });
    // Cargar proveedores
    $('#modal-buscar_proveedor').on('show.bs.modal', function() {
        fetch('../api/compras/proveedores.php')
            .then(res => res.json())
            .then(data => {
                console.log("Respuesta proveedores:", data);
                let tbody = $('#tabla_proveedores tbody');
                tbody.empty();

                if (Array.isArray(data)) {
                    data.forEach((prov, i) => {
                        tbody.append(`
                        <tr>
                            <td>${i+1}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm seleccionar-proveedor"
                                        data-id="${prov.id_proveedor}" 
                                        data-nombre="${prov.nombre_proveedor}" 
                                        data-celular="${prov.celular}" 
                                        data-telefono="${prov.telefono}" 
                                        data-empresa="${prov.empresa}" 
                                        data-email="${prov.email}" 
                                        data-direccion="${prov.direccion}">
                                    Seleccionar
                                </button>
                            </td>
                            <td>${prov.nombre_proveedor}</td>
                            <td>${prov.celular}</td>
                            <td>${prov.telefono}</td>
                            <td>${prov.empresa}</td>
                            <td>${prov.email}</td>
                            <td>${prov.direccion}</td>
                        </tr>
                    `);
                    });
                } else {
                    tbody.append(`<tr><td colspan="8" class="text-center text-danger">Error al cargar proveedores</td></tr>`);
                }
            })
            .catch(err => console.error("Error en fetch proveedores:", err));
    });

    // Al seleccionar proveedor, rellenar campos
    $(document).on('click', '.seleccionar-proveedor', function() {
        $('#id_proveedor_input_hidden').val($(this).data('id'));
        $('#proveedor_nombre').val($(this).data('nombre'));
        $('#proveedor_info').html(`
        <p><b>Celular:</b> ${$(this).data('celular')}</p>
        <p><b>Teléfono:</b> ${$(this).data('telefono')}</p>
        <p><b>Empresa:</b> ${$(this).data('empresa')}</p>
        <p><b>Email:</b> ${$(this).data('email')}</p>
        <p><b>Dirección:</b> ${$(this).data('direccion')}</p>
    `);
        $('#modal-buscar_proveedor').modal('hide');
    });

    // Cargar productos
    $('#modal-buscar_producto').on('show.bs.modal', function() {
        fetch('../api/compras/productos.php')
            .then(res => {
                console.log('Status:', res.status);
                return res.json();
            })
            .then(data => {
                console.log('Datos recibidos:', data);
                let tbody = $('#tabla_productos tbody');
                tbody.empty();
                data.forEach((prod, i) => {
                    tbody.append(`
                    <tr>
                        <td>${i+1}</td>
                        <td><button type="button" class="btn btn-success btn-sm add-product"
                                data-id="${prod.id_producto}" 
                                data-nombre="${prod.nombre}" 
                                data-precio="${prod.precio_compra}">
                                Añadir
                        </button></td>
                        <td>${prod.codigo}</td>
                        <td>${prod.nombre}</td>
                        <td>${prod.stock}</td>
                        <td>${prod.precio_compra}</td>
                    </tr>
                `);
                });

            });
    });

    $(document).on('click', '.add-product', function() {
        let prod = {
            id_producto: $(this).data('id'),
            nombre: $(this).data('nombre'),
            precio_unitario: parseFloat($(this).data('precio')),
            cantidad: 1
        };
        productosCompra.push(prod);
        renderProductos();
        $('#modal-buscar_producto').modal('hide');
    });

    // Renderizar productos
    function renderProductos() {
        let tbody = $('#detalle_compra');
        tbody.empty();
        let total = 0;
        productosCompra.forEach((p, i) => {
            let subtotal = p.precio_unitario * p.cantidad;
            total += subtotal;
            tbody.append(`
            <tr>
                <td>${p.nombre}</td>
                <td><input type="number" min="1" value="${p.cantidad}" 
                           class="form-control cantidad-prod" 
                           data-index="${i}"></td>
                <td><input type="number" min="0.01" step="0.01" value="${p.precio_unitario}" 
                           class="form-control precio-prod" 
                           data-index="${i}"></td>
                <td class="subtotal">${subtotal.toFixed(2)}</td>
                <td><button type="button" class="btn btn-danger btn-sm remove-product" data-index="${i}">X</button></td>
            </tr>
        `);
        });
        $('#total_general_compra').text(total.toFixed(2));
    }

    // Eventos cantidad/precio
    $(document).on('input', '.cantidad-prod, .precio-prod', function() {
        let index = $(this).data('index');
        let cantidad = parseInt($(`.cantidad-prod[data-index="${index}"]`).val());
        let precio = parseFloat($(`.precio-prod[data-index="${index}"]`).val());

        productosCompra[index].cantidad = isNaN(cantidad) ? 1 : cantidad;
        productosCompra[index].precio_unitario = isNaN(precio) ? 0 : precio;
        renderProductos();
    });

    // Eliminar producto
    $(document).on('click', '.remove-product', function() {
        let index = $(this).data('index');
        productosCompra.splice(index, 1);
        renderProductos();
    });

    // Guardar compra (VERSION MEJORADA)
    $('#form_compra').submit(function(e) {
        e.preventDefault();

        if (productosCompra.length === 0) {
            Swal.fire("Error", "Debe añadir al menos un producto", "error");
            return;
        }
        if (!$('#id_proveedor_input_hidden').val()) {
            Swal.fire("Error", "Debe seleccionar un proveedor", "error");
            return;
        }

        const payload = {
            nro_compra: $('#nro_compra').val(),
            fecha_compra: $('#fecha_compra').val(),
            comprobante: $('#comprobante').val(),
            id_usuario: $('input[name="id_usuario"]').val(),
            id_proveedor: $('#id_proveedor_input_hidden').val(),
            total_compra: parseFloat($('#total_general_compra').text()),
            productos: productosCompra.map(p => ({
                id_producto: p.id_producto,
                cantidad: p.cantidad,
                precio_unitario: p.precio_unitario
            }))
        };

        fetch('../api/compras/index.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            })
            .then(res => {
                // PRIMERO revisamos si la respuesta fue exitosa
                if (!res.ok) {
                    // Si no, leemos el texto del error y lo mostramos
                    return res.text().then(text => {
                        throw new Error(`El servidor respondió con un error: ${res.statusText}. Mensaje: ${text}`);
                    });
                }
                // Si la respuesta fue exitosa, revisamos el tipo de contenido
                const contentType = res.headers.get("content-type");
                if (contentType && contentType.includes("application/json")) {
                    return res.json();
                } else {
                    return res.text().then(text => {
                        throw new Error(`El servidor no devolvió JSON. Tipo de respuesta: ${contentType}. Contenido: ${text.substring(0, 100)}...`);
                    });
                }
            })
            .then(data => {
                if (data.success) {
                    Swal.fire("Éxito", data.message || "Compra registrada", "success")
                        .then(() => window.location.href = "../compras");
                } else {
                    Swal.fire("Error", data.error || "No se pudo registrar la compra", "error");
                }
            })
            .catch(err => Swal.fire("Error", `Error en la petición: ${err.message || err}`, "error"));
    });
</script>