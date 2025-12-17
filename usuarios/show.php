<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Datos del usuario</h1>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Información del usuario</h3>
                        </div>

                        <div class="card-body">
                            <input type="hidden" id="id_usuario" value="<?php echo $_GET['id']; ?>">

                            <div class="form-group">
                                <label for="">Nombres</label>
                                <input type="text" id="nombres" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" id="email" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label for="">Rol del usuario</label>
                                <input type="text" id="rol" class="form-control" disabled>
                            </div>
                            <hr>
                            <div class="form-group">
                                <a href="index.php" class="btn btn-secondary">Volver</a>
                            </div>
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
    document.addEventListener("DOMContentLoaded", async () => {
        const APP_BASE_PATH = ""

        const idUsuario = document.getElementById("id_usuario").value;

        try {
            const resp = await fetch(`${APP_BASE_PATH}/api/usuarios/read_one.php?id=${idUsuario}`);
            const user = await resp.json();

            if (resp.ok) {
                document.getElementById("nombres").value = user.nombres;
                document.getElementById("email").value = user.email;
                document.getElementById("rol").value = user.rol;
            } else {
                alert(user.message || "No se pudo obtener la información del usuario.");
            }
        } catch (err) {
            console.error(err);
            alert("Error al conectar con la API.");
        }
    });
</script>