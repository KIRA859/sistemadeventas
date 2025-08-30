<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Actualizar usuario</h1>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Llene los datos con cuidado</h3>
                        </div>
                        <div class="card-body">
                            <form id="formUpdateUser">
                                <input type="hidden" name="id_usuario" id="id_usuario"
                                    value="<?php echo $_GET['id']; ?>">

                                <div class="form-group">
                                    <label>Nombres</label>
                                    <input type="text" id="nombres" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" id="email" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Rol del usuario</label>
                                    <select id="id_rol" class="form-control"></select>
                                </div>

                                <div class="form-group">
                                    <label>Contraseña</label>
                                    <input type="password" id="password_user" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Repita la contraseña</label>
                                    <input type="password" id="password_repeat" class="form-control">
                                </div>

                                <hr>
                                <a href="index.php" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-success">Actualizar</button>
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
    document.addEventListener("DOMContentLoaded", async () => {
        const APP_BASE_PATH = "/sistema_de_ventas";
        const idUsuario = document.getElementById("id_usuario").value;

        // 1. Cargar roles
        const respRoles = await fetch(`${APP_BASE_PATH}/api/roles/read.php`);
        const roles = await respRoles.json();
        let sel = document.getElementById("id_rol");
        roles.forEach(r => {
            let opt = document.createElement("option");
            opt.value = r.id_rol;
            opt.textContent = r.rol;
            sel.appendChild(opt);
        });

        // 2. Cargar datos del usuario
        const respUser = await fetch(`${APP_BASE_PATH}/api/usuarios/read_one.php?id=${idUsuario}`);
        const user = await respUser.json();
        console.log("Usuario cargado:", user);

        document.getElementById("nombres").value = user.nombres;
        document.getElementById("email").value = user.email;
        document.getElementById("id_rol").value = user.id_rol;

        // 3. Enviar formulario
        document.getElementById("formUpdateUser").addEventListener("submit", async (e) => {
            e.preventDefault();

            const pass = document.getElementById("password_user").value;
            const passRepeat = document.getElementById("password_repeat").value;

            if (pass && pass !== passRepeat) {
                alert("Las contraseñas no coinciden.");
                return;
            }

            const payload = {
                id_usuario: idUsuario,
                nombres: document.getElementById("nombres").value,
                email: document.getElementById("email").value,
                id_rol: document.getElementById("id_rol").value,
                password_user: pass ? pass : null
            };

            const resp = await fetch(`${APP_BASE_PATH}/api/usuarios/update.php`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(payload)
            });

            const data = await resp.json();
            if (resp.ok && data.success) {
                alert("Usuario actualizado correctamente");
                window.location.href = "index.php";
            } else {
                alert("Error: " + data.message);
            }
        });
    });
</script>
