<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

//include('../app/controllers/usuarios/listado_de_usuarios.php');
?>


<!--content wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Listado de clientes</h1>
          <h2 class="h2-title"><b>Modulo en construcción</b></h2>
        </div><!--/.col-->
      </div><!--/.row-->
    </div><!-- /.container-fluid -->
  </div>

  <!-- /.content-header -->


  <!--Main content-->
  <div class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-md-12">
          <div class="card card-outline card-primary">
            <div class="card-header">
              <h3 class="card-title">Clientes registrados</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body" style="display: block;">

              <table id="table_usuarios" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>
                      <center>Nro</center>
                    </th>
                    <th>
                      <center>Cedula</center>
                    </th>
                    <th>
                      <center>Nombres</center>
                    </th>
                    <th>
                      <center>Email</center>
                    </th>
                    <th>
                      <center>Telefono</center>
                    </th>
                    <th>
                      <center>Dirección</center>
                    </th>
                    <th>
                      <center>Acciones</center>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $contador = 0;
                  include('../app/controllers/clientes/listado_de_clientes.php');
                  foreach ($clientes_datos as $clientes_dato) { 
                    $id_cliente = $clientes_dato['id_cliente'];  ?>
                    <tr>
                      <td>
                        <center><?php echo $contador = $contador + 1 ?></center>
                      </td>
                      <td><?php echo $clientes_dato['cedula']; ?></td>
                      <td><?php echo $clientes_dato['nombre']; ?></td>
                      <td><?php echo $clientes_dato['correo']; ?></td>
                      <td><?php echo $clientes_dato['telefono']; ?></td>
                      <td><?php echo $clientes_dato['direccion']; ?></td>



                      <td>
                        <center>
                          <div class="btn-group">
                            <a href="show.php?id=<?php echo $id_usuario; ?>"  type="button" class="btn btn-info"> <i class="fa fa-eye" style="font-size: 19x;"></i> Ver
                            <a href="update.php?id=<?php echo $id_usuario; ?>" type="button" class="btn btn-success"> <i class="fa fa-pencil-alt"></i>Editar</a>
                            <a href="delete.php?id=<?php echo $id_usuario; ?>" type="button" class="btn btn-danger"> <i class="fa fa-trash"></i>Borrar</a>
                          </div>
                        </center>
                      </td>
                    </tr>

                  <?php
                  }
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>
                      <center>Nro</center>
                    </th>
                    <th>
                      <center>Cedula</center>
                    </th>
                    <th>
                      <center>Nombres</center>
                    </th>
                    <th>
                      <center>Email</center>
                    </th>
                    <th>
                      <center>Telefono</center>
                    </th>
                    <th>
                      <center>Acciones</center>
                    </th>
                  </tr>
                </tfoot>
              </table>

              <!-- <table id="table_usuarios" class="table table-bordered table-striped">-->

            </div>
            <!-- /.card-body -->
          </div>
        </div>
      </div>
      <!-- /.row-->
    </div><!-- /.container-fluid-->
  </div>
  <!-- /.content -->

</div>


<!-- /.content-wrapper-->
<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>


<!-- Page specific script-->
<script>
  $(function() {
    $("#table_usuarios").DataTable({
      "pageLength": 5,
      "language": {
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ clientes",
        "infoEmpty": "Mostrando 0 a 0 de 0 clientes",
        "infoFiltered": "(Filtrado de _MAX_ total clientes)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ clientes",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscador:",
        "zeroRecords": "Sin resultados encontrados",
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
          buttons: [{
              text: 'Copiar',
              extend: 'copy',
            },
            {
              extend: 'pdf'
            },
            {
              extend: 'csv'
            },
            {
              extend: 'excel'
            },
            {
              text: 'Imprimir',
              extend: 'print'
            },
          ]
        },
        {
          extend: 'colvis',
          text: 'Visor de columnas',
          collectionLayout: 'fixed three-column'
        },
      ]
    }).buttons().container().appendTo('#table_usuarios_wrapper .col-md-6:eq(0)');
  });
</script>