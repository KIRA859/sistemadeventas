<?php
include ('../app/config.php');
include ('../layout/sesion.php');
include ('../layout/parte1.php');

//Recoger el ID que viene desde index.php
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
                            <form id="formEliminar">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>

<?php include ('../layout/mensajes.php'); ?>
<?php include ('../layout/parte2.php'); ?>

<script>
const APP_BASE_PATH = "/sistema_de_ventas";
const idUsuario = document.getElementById("id_usuario").value;

async function cargarUsuario() {
    try {
        const resp = await fetch(`${APP_BASE_PATH}/api/usuarios/read_one.php?id=${idUsuario}`);
        const data = await resp.json();

        if (resp.ok) {
            document.getElementById("nombres").value = data.nombres;
            document.getElementById("email").value = data.email;
            document.getElementById("rol").value = data.rol;
        } else {
            alert(data.message || "No se pudo cargar el usuario.");
        }
    } catch (err) {
        console.error(err);
        alert("Error de conexión al cargar usuario.");
    }
}

// Eliminar usuario
document.getElementById("formEliminar").addEventListener("submit", async (e) => {
    e.preventDefault();

    if (!confirm("¿Confirma que desea eliminar este usuario?")) return;

    try {
        const resp = await fetch(`${APP_BASE_PATH}/api/usuarios/delete.php`, {
            method: "DELETE",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id_usuario: idUsuario })
        });

        const data = await resp.json();
        alert(data.message);

        if (resp.ok && data.success) {
            window.location.href = "./index.php";
        }
    } catch (err) {
        console.error(err);
        alert("Error al eliminar usuario.");
    }
});

cargarUsuario();
</script>