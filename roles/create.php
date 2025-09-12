<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Registro de un Rol</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-5">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Llene los datos con cuidado</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="formRol">
                                        <div class="form-group">
                                            <label for="">Nombre del Rol</label>
                                            <input type="text" id="rol" name="rol" class="form-control"
                                                placeholder="Escriba aquí el rol..." required>
                                        </div>
                                        <hr>
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

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>


<script>
document.getElementById('formRol').addEventListener('submit', function(e) {
    e.preventDefault();

    const rol = document.getElementById('rol').value;

    fetch('<?php echo $URL; ?>/api/roles/create.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ rol: rol })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            // Redirigir al listado de roles
            window.location.href = "<?php echo $URL; ?>/roles/index.php";
        }
        
    })
    .catch(err => console.error("Error en fetch:", err));

    


});
</script>