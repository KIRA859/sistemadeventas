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
          <h1 class="m-0">Registro de un nuevo cliente</h1>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Llene los datos</h3>
            </div>
            <div class="card-body">
              <form id="form-cliente">
                <div class="form-group">
                  <label>Nombre Completo</label>
                  <input type="text" name="nombre_cliente" class="form-control" required>
                </div>
                <div class="form-group">
                  <label>Cédula / NIT</label>
                  <input type="text" name="nit_ci_cliente" class="form-control" required>
                </div>
                <div class="form-group">
                  <label>Correo Electrónico</label>
                  <input type="email" name="email_cliente" class="form-control" required>
                </div>
                <div class="form-group">
                  <label>Teléfono</label>
                  <input type="text" name="celular_cliente" class="form-control">
                </div>
                <div class="form-group">
                  <label>Dirección</label>
                  <input type="text" name="direccion" class="form-control">
                </div>
                <div class="form-group">
                  <a href="index.php" class="btn btn-secondary">Cancelar</a>
                  <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
              </form>
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
$("#form-cliente").on("submit", function(e) {
  e.preventDefault();
  const data = Object.fromEntries(new FormData(this).entries());

  fetch("../api/clientes/clientes.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(data)
  })
  .then(res => res.json())
  .then(json => {
    if (json.status === "success") {
      alert("Cliente registrado correctamente");
      window.location.href = "index.php";
    } else {
      alert("Error: " + json.message);
    }
  });
});
</script>
