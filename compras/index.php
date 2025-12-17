<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Listado de compras actualizado</h1>
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
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Compras registradas</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="table table-responsive">
                                <table id="example1" class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>
                                                <center>#</center>
                                            </th>
                                            <th>
                                                <center>Nro compra</center>
                                            </th>
                                            <th>
                                                <center>Producto</center>
                                            </th>
                                            <th>
                                                <center>Fecha</center>
                                            </th>
                                            <th>
                                                <center>Proveedor</center>
                                            </th>
                                            <th>
                                                <center>Comprobante</center>
                                            </th>
                                            <th>
                                                <center>Usuario</center>
                                            </th>
                                            <th>
                                                <center>Precio unitario</center>
                                            </th>
                                            <th>
                                                <center>Cantidad</center>
                                            </th>
                                            <th>
                                                <center>Acciones</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_compras"></tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        fetch("../api/compras/listado.php")
            .then(res => res.json())
            .then(data => {
                console.log("Compras cargadas:", data);

                let tbody = document.getElementById("tbody_compras");
                tbody.innerHTML = "";

                // Si NO hay compras → mostrar mensaje y NO inicializar DataTables
                if (!Array.isArray(data) || data.length === 0) {
                    tbody.innerHTML =
                        `<tr><td colspan="10" class="text-center text-danger">No se encontraron compras</td></tr>`;
                    return; // 👈 IMPORTANTE: evita que DataTables se inicialice
                }

                // Construir filas
                data.forEach((compra, i) => {
                    tbody.innerHTML += `
                    <tr>
                        <td>${i+1}</td>
                        <td>${compra.nro_compra ?? ""}</td>
                        <td>${compra.nombre_producto ?? ""}</td>
                        <td>${compra.fecha_compra ?? ""}</td>
                        <td>${compra.nombre_proveedor ?? ""}</td>
                        <td>${compra.comprobante ?? ""}</td>
                        <td>${compra.nombres_usuario_compra ?? ""}</td>
                        <td>${compra.precio_unitario ?? ""}</td>
                        <td>${compra.cantidad ?? ""}</td>
                        <td>
                            <center>
                                <div class="btn-group">
                                    <a href="show.php?id=${compra.id_compra ?? 0}" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i> Ver
                                    </a>
                                    <a href="update.php?id=${compra.id_compra ?? 0}" class="btn btn-success btn-sm">
                                        <i class="fa fa-pencil-alt"></i> Editar
                                    </a>
                                    <a href="delete.php?id=${compra.id_compra ?? 0}" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i> Borrar
                                    </a>
                                </div>
                            </center>
                        </td>
                    </tr>
                `;
                });

                // Destruir instancia previa si existe
                if ($.fn.DataTable.isDataTable('#example1')) {
                    $('#example1').DataTable().destroy();
                }

                // Inicializar DataTables SOLO si hay filas
                $("#example1").DataTable({
                    "pageLength": 5,
                    "language": {
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Compras",
                        "infoEmpty": "Mostrando 0 a 0 de 0 Compras",
                        "infoFiltered": "(Filtrado de _MAX_ total Compras)",
                        "lengthMenu": "Mostrar _MENU_ Compras",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscador:",
                        "zeroRecords": "Sin resultados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Último",
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
                            buttons: ['copy', 'pdf', 'csv', 'excel', 'print']
                        },
                        {
                            extend: 'colvis',
                            text: 'Visor de columnas',
                            collectionLayout: 'fixed three-column'
                        }
                    ]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            })
            .catch(err => {
                console.error("Error cargando compras:", err);
                document.getElementById("tbody_compras").innerHTML =
                    `<tr><td colspan="10" class="text-center text-danger">Error al cargar compras</td></tr>`;
            });

    });
</script>