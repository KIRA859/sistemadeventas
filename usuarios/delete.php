<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

// Recibir ID desde index.php
$id_usuario_get = $_GET['id'] ?? null;
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Eliminar usuario</h1>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">¿Está seguro de eliminar al usuario?</h3>
                        </div>

                        <div class="card-body">

                            <!-- Formulario visible -->
                            <form id="formEliminarVisible" action="javascript:void(0);">
                                <input type="hidden" id="id_usuario" value="<?php echo htmlspecialchars($id_usuario_get); ?>">

                                <div class="form-group">
                                    <label>Nombres</label>
                                    <input type="text" id="nombres" class="form-control" disabled>
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" id="email" class="form-control" disabled>
                                </div>

                                <div class="form-group">
                                    <label>Rol del usuario</label>
                                    <input type="text" id="rol" class="form-control" disabled>
                                </div>

                                <hr>

                                <div class="form-group">
                                    <a href="index.php" class="btn btn-secondary">Volver</a>
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </div>
                            </form>

                            <!-- Formulario oculto que hace el POST real -->
                            <form id="formDelete" action="../api/usuarios/delete.php" method="POST" style="display:none;">
                                <input type="hidden" name="id_usuario" id="deleteId">
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
    const APP_BASE_PATH = "..";
    const idUsuario = document.getElementById("id_usuario").value;

    async function cargarUsuario() {
        try {
            const resp = await fetch(`${APP_BASE_PATH}/api/usuarios/read_one.php?id=${idUsuario}`);

            if (!resp.ok) {
                throw new Error("Error al obtener datos del usuario");
            }

            const data = await resp.json();

            document.getElementById("nombres").value = data.nombres ?? "";
            document.getElementById("email").value = data.email ?? "";
            document.getElementById("rol").value = data.rol ?? "";

        } catch (err) {
            console.error("Error:", err);
            alert("Error de conexión al cargar usuario.");
        }
    }

    // PROCESO DE ELIMINACIÓN
    document.getElementById("formEliminarVisible").addEventListener("submit", (e) => {
        e.preventDefault();

        if (!confirm("¿Confirma que desea eliminar este usuario?")) return;

        // Pasar ID al formulario oculto
        document.getElementById("deleteId").value = idUsuario;

        // Enviar POST real a delete.php
        document.getElementById("formDelete").submit();
    });

    cargarUsuario();
</script>
