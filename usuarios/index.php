<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
// include ('../app/controllers/usuarios/listado_de_usuarios.php'); 
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Listado de usuarios</h1>
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
                            <h3 class="card-title">Usuarios registrados</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>Nro</center>
                                        </th>
                                        <th>
                                            <center>Nombres</center>
                                        </th>
                                        <th>
                                            <center>Email</center>
                                        </th>
                                        <th>
                                            <center>Rol del usuario</center>
                                        </th>
                                        <th>
                                            <center>Acciones</center>
                                        </th>
                                    </tr>
                                </thead>
                                <!-- El tbody se llenará dinámicamente con JavaScript -->
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>
                                            <center>Nro</center>
                                        </th>
                                        <th>
                                            <center>Nombres</center>
                                        </th>
                                        <th>
                                            <center>Email</center>
                                        </th>
                                        <th>
                                            <center>Rol del usuario</center>
                                        </th>
                                        <th>
                                            <center>Acciones</center>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
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


<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>


<script>
    $(function() {
        const APP_BASE_PATH = "..";


        $("#example1").DataTable({
            "processing": true,
            "serverSide": false,
            "ajax": {
                "url": `${APP_BASE_PATH}/api/usuarios/show.php`,
                "type": "GET",
                "dataSrc": ""
            },
            "columns": [
                // Columna para el número de fila
                {
                    "data": null,
                    "render": function(data, type, row, meta) {
                        return meta.row + 1;
                    },
                    "className": "text-center"
                },
                // Columna para los nombres
                {
                    "data": "nombres"
                },
                // Columna para el email
                {
                    "data": "email"
                },
                // Columna para el rol
                {
                    "data": "rol",
                    "className": "text-center"
                },
                // Columna para las acciones
                {
                    "data": "id_usuario",
                    "render": function(data, type, row) {
                        return `
                        <center>
                            <div class="btn-group">
                                <a href="${APP_BASE_PATH}/usuarios/show.php?id=${data}" type="button" class="btn btn-info"><i class="fa fa-eye"></i> Ver</a>
                                <a href="${APP_BASE_PATH}/usuarios/update.php?id=${data}" type="button" class="btn btn-success"><i class="fa fa-pencil-alt"></i> Editar</a>
                                <a href="${APP_BASE_PATH}/usuarios/delete.php?id=${data}" type="button" class="btn btn-danger"><i class="fa fa-trash"></i> Borrar</a>
                            </div>
                        </center>
                    `;
                    },
                    "orderable": false,
                    "searchable": false
                }
            ],
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Usuarios",
                "infoEmpty": "Mostrando 0 a 0 de 0 Usuarios",
                "infoFiltered": "(Filtrado de _MAX_ total Usuarios)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Usuarios",
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
                buttons: ['copy', 'pdf', 'csv', 'excel', 'print']
            }, {
                extend: 'colvis',
                text: 'Visor de columnas',
                collectionLayout: 'fixed three-column'
            }],
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>