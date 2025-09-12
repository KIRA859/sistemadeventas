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
                    <h1 class="m-0">Listado de Movimientos de Inventario</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Movimientos recientes</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body" style="display: block;">
                            <table id="tabla_movimientos" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID Mov.</th>
                                        <th>ID Prod.</th>
                                        <th>Producto</th>
                                        <th>Tipo Movimiento</th>
                                        <th>Cantidad</th>
                                        <th>Descripción</th>
                                        <th>Fecha y Hora</th>
                                        <th>Usuario</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>

<script>
    $(function() {
        $('#tabla_movimientos').DataTable({
            "processing": true,
            "serverSide": false, // Como cargamos todos los datos de una vez, es false
            "ajax": {
                "url": "<?php echo $URL; ?>/api/almacen/movimientos.php", 
                "dataSrc": "data" // Indicamos que los datos están en la clave "data" del JSON
            },
            "columns": [
                { "data": "id_movimiento" },
                { "data": "id_producto" },
                { "data": "producto_nombre" }, // Este dato viene del JOIN en la API
                { 
                    "data": "tipo_movimiento",
                    // Usamos "render" para personalizar la celda y mostrar insignias de color
                    "render": function(data, type, row) {
                        if (data === 'ENTRADA') {
                            return '<span class="badge badge-success">ENTRADA</span>';
                        } else if (data === 'SALIDA') {
                            return '<span class="badge badge-danger">SALIDA</span>';
                        } else {
                            return '<span class="badge badge-warning">' + data + '</span>'; // Para otros tipos
                        }
                    }
                },
                { "data": "cantidad" },
                { "data": "descripcion" },
                { "data": "fecha_movimiento" },
                { "data": "usuario_email" } // Este dato también viene del JOIN
            ],
            "pageLength": 10,
            "language": {
                // idioma español
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Movimientos",
                "infoEmpty": "Mostrando 0 a 0 de 0 Movimientos",
                "infoFiltered": "(Filtrado de _MAX_ total Movimientos)",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscador:",
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
        });
    });
</script>