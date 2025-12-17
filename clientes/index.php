<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
?>

<!-- Content Wrapper -->
<div class="content-wrapper">

  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Listado de clientes</h1>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-outline card-primary">
            <div class="card-header">
              <h3 class="card-title">Clientes registrados</h3>
            </div>
            <div class="card-body">
              <table id="table_clientes" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Nro</th>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody id="clientes-body"></tbody>
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
    // Inicializar DataTable vacío
    let table = $("#table_clientes").DataTable({
      "pageLength": 5,
      "responsive": true,
      "autoWidth": false,
      "language": {
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ clientes",
        "infoEmpty": "Mostrando 0 clientes",
        "infoFiltered": "(filtrado de _MAX_ clientes totales)",
        "search": "Buscar:",
        "lengthMenu": "Mostrar _MENU_ clientes",
        "paginate": {
          "first": "Primero",
          "last": "Último",
          "next": "Siguiente",
          "previous": "Anterior"
        }
      }
    });

    // Cargar clientes desde API
    fetch("../api/clientes/clientes.php")
      .then(res => res.json())
      .then(json => {
        if (json.status === "success" && Array.isArray(json.data)) {
          table.clear(); // limpiar antes de cargar
          json.data.forEach((c, i) => {
            table.row.add([
              i + 1,
              c.cedula || "",
              c.nombre || "",
              c.correo || "",
              c.telefono || "",
              c.direccion || "",
              `
              <div class="btn-group">
                <a href="create.php?id=${c.id_cliente}" class="btn btn-success btn-sm"><i class="fa fa-pencil-alt"></i></a>
                <button class="btn btn-danger btn-sm btn-delete" data-id="${c.id_cliente}"><i class="fa fa-trash"></i></button>
              </div>
              `
            ]);
          });
          table.draw();
        } else {
          console.warn("No llegaron clientes de la API:", json);
        }
      })
      .catch(err => console.error("Error cargando clientes:", err));

    // Eliminar cliente
    $(document).on("click", ".btn-delete", function() {
      let id = $(this).data("id");
      if (confirm("¿Seguro de eliminar este cliente?")) {
        fetch("../api/clientes/clientes.php", {
            method: "DELETE",
            headers: {
              "Content-Type": "application/json"
            },
            body: JSON.stringify({
              id_cliente: id
            })
          })
          .then(res => res.json())
          .then(json => {
            alert(json.message);
            location.reload();
          })
          .catch(err => console.error("Error eliminando cliente:", err));
      }
    });
  });
</script>
