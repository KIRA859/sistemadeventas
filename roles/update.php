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
                    <h1 class="m-0">Edición del Rol</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Llene los datos con cuidado</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <form id="form-update">
                                <input type="hidden" id="id_rol" name="id_rol">
                                <div class="form-group">
                                    <label for="rol">Nombre del Rol</label>
                                    <input type="text" id="rol" name="rol" class="form-control"
                                        placeholder="Escriba aquí el rol..." required>
                                </div>
                                <hr>
                                <button type="submit" class="btn btn-success">Actualizar</button>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Obtener ID desde la URL
    const params = new URLSearchParams(window.location.search);
    const idRol = params.get("id");

    if (!idRol) {
        alert("No se especificó un ID de rol válido.");
        window.location.href = "index.php";
    }

    // Cargar datos del rol
    async function cargarRol(idRol) {
        try {
            const resp = await fetch(`/api/roles/show.php?id=${idRol}`);
            const data = await resp.json();
            console.log("Datos recibidos:", data);

            if (data.success) {
                document.getElementById("id_rol").value = data.rol.id_rol;
                document.getElementById("rol").value = data.rol.rol;
            } else {
                alert("No se pudo cargar el rol: " + data.message);
                window.location.href = "index.php";
            }
        } catch (error) {
            console.error(error);
            alert("Error al cargar el rol desde el servidor");
        }
    }

    cargarRol(idRol);

    // Capturar submit y actualizar con la API
    document.querySelector("#form-update").addEventListener("submit", async function(e) {
        e.preventDefault();

        const id_rol = document.getElementById("id_rol").value;
        const nuevoRol = document.getElementById("rol").value;

        try {
            const resp = await fetch("/api/roles/update.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    id_rol: id_rol,
                    rol: nuevoRol
                })
            });

            const data = await resp.json();
            console.log("Respuesta actualización:", data);

            if (data.success) {
                alert("Rol actualizado correctamente");
                window.location.href = "index.php";
            } else {
                alert("Error: " + data.message);
            }
        } catch (error) {
            console.error(error);
            alert("Error en la conexión con el servidor");
        }
    });
</script>

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>
