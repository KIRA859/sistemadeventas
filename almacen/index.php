<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Listado de productos
                        <a href="create.php" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Agregar Nuevo
                        </a>
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Productos registrados</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tabla-productos" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Nro</center>
                                    </th>
                                    <th>
                                        <center>Código</center>
                                    </th>
                                    <th>
                                        <center>Categoría</center>
                                    </th>
                                    <th>
                                        <center>Imagen</center>
                                    </th>
                                    <th>
                                        <center>Nombre</center>
                                    </th>
                                    <th>
                                        <center>Descripción</center>
                                    </th>
                                    <th>
                                        <center>Stock</center>
                                    </th>
                                    <th>
                                        <center>P. compra</center>
                                    </th>
                                    <th>
                                        <center>P. venta</center>
                                    </th>
                                    <th>
                                        <center>Fecha ingreso</center>
                                    </th>
                                    <th>
                                        <center>Usuario</center>
                                    </th>
                                    <th>
                                        <center>Acciones</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="productos-body">
                                <tr>
                                    <td colspan="12">
                                        <center>Cargando productos...</center>
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

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>

<script>
    let dataTable;

    async function cargarProductos() {
        try {
            const resp = await fetch("../api/almacen/productos.php");
            if (!resp.ok) {
                throw new Error(`Error HTTP: ${resp.status}`);
            }

            const data = await resp.json();
            const tbody = document.getElementById("productos-body");
            tbody.innerHTML = "";

            if (data.success && data.productos && data.productos.length > 0) {
                data.productos.forEach((prod, i) => {
                    let colorStock = "";
                    if (prod.stock < prod.stock_minimo) {
                        colorStock = 'style="background:#ffcccc"';
                    } else if (prod.stock > prod.stock_maximo) {
                        colorStock = 'style="background:#ccffcc"';
                    }

                    // Manejar imagen (si no existe, mostrar placeholder)
                    let imagenHtml = '<div class="text-center"><i class="fas fa-image fa-2x text-muted"></i></div>';
                    if (prod.imagen) {
                        imagenHtml = `<img src="../almacen/img_productos/${prod.imagen}" width="50" height="50" style="object-fit: cover;">`;
                    }

                    tbody.innerHTML += `
                    <tr>
                        <td><center>${i+1}</center></td>
                        <td><center>${prod.codigo || 'N/A'}</center></td>
                        <td>${prod.nombre_categoria || 'Sin categoría'}</td>
                        <td><center>${imagenHtml}</center></td>
                        <td>${prod.nombre || ''}</td>
                        <td>${prod.descripcion || ''}</td>
                        <td ${colorStock}><center>${prod.stock || 0}</center></td>
                        <td><center>${prod.precio_compra ? 'S/ ' + parseFloat(prod.precio_compra).toFixed(2) : 'N/A'}</center></td>
                        <td><center>${prod.precio_venta ? 'S/ ' + parseFloat(prod.precio_venta).toFixed(2) : 'N/A'}</center></td>
                        <td><center>${prod.fecha_ingreso ? new Date(prod.fecha_ingreso).toLocaleDateString() : 'N/A'}</center></td>
                        <td>${prod.email || 'N/A'}</td>
                        <td>
                            <center>
                                <a href="update.php?id=${prod.id_producto}" class="btn btn-success btn-sm">
                                    <i class="fa fa-edit"></i>
                                </a>
                               <button class="btn btn-danger btn-sm" onclick="eliminarProducto(${prod.id_producto})">
                                <i class="fa fa-trash"></i> Eliminar
                                </button>
                            </center>
                        </td>
                    </tr>`;
                });

                // Inicializar o recargar DataTable
                if ($.fn.DataTable.isDataTable('#tabla-productos')) {
                    dataTable.destroy();
                }

                dataTable = $('#tabla-productos').DataTable({
                    "pageLength": 10,
                    "language": {
                        "emptyTable": "No hay productos registrados",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ productos",
                        "infoEmpty": "Mostrando 0 a 0 de 0 productos",
                        "infoFiltered": "(Filtrado de _MAX_ total productos)",
                        "lengthMenu": "Mostrar _MENU_ productos",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "No se encontraron resultados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Último",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    },
                    "responsive": true,
                    "autoWidth": false,
                    "order": [
                        [0, "asc"]
                    ],
                    "columnDefs": [{
                            "width": "5%",
                            "targets": 0
                        },
                        {
                            "width": "8%",
                            "targets": 1
                        },
                        {
                            "width": "10%",
                            "targets": 2
                        },
                        {
                            "width": "8%",
                            "targets": 3
                        },
                        {
                            "width": "12%",
                            "targets": 4
                        },
                        {
                            "width": "15%",
                            "targets": 5
                        },
                        {
                            "width": "5%",
                            "targets": 6
                        },
                        {
                            "width": "8%",
                            "targets": 7
                        },
                        {
                            "width": "8%",
                            "targets": 8
                        },
                        {
                            "width": "10%",
                            "targets": 9
                        },
                        {
                            "width": "10%",
                            "targets": 10
                        },
                        {
                            "width": "8%",
                            "targets": 11
                        }
                    ]
                });
            } else {
                tbody.innerHTML = `
                <tr>
                    <td colspan="12"><center>No hay productos registrados</center></td>
                </tr>`;
            }
        } catch (err) {
            console.error("Error cargando productos:", err);
            const tbody = document.getElementById("productos-body");
            tbody.innerHTML = `
            <tr>
                <td colspan="12"><center>Error al cargar los productos</center></td>
            </tr>`;
        }
    }

    async function eliminarProducto(id) {
        if (!confirm("¿Está seguro de que desea desactivar este producto?")) return;

        try {
            const resp = await fetch("../api/almacen/productos.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    accion: "desactivar",
                    id_producto: id
                })
            });

            if (!resp.ok) {
                throw new Error(`Error HTTP: ${resp.status}`);
            }

            const data = await resp.json();

            if (data.success) {
                alert("Producto desactivado correctamente");
                location.reload();
            } else {
                alert("Error: " + (data.message || "No se pudo desactivar el producto"));
            }
        } catch (error) {
            console.error("Detalle del error:", error);
            alert("Error al conectar con la API.");
        }
    }
    // Cargar productos cuando el documento esté listo
    $(document).ready(function() {
        cargarProductos();
    });
</script>