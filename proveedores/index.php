<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">
                        Listado de Proveedores
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
                            <i class="fa fa-plus"></i> Agregar Nuevo
                        </button>
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Proveedores registrados</h3>
                        </div>
                        <div class="card-body">
                            <table id="tablaProveedores" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Nro</th>
                                        <th>Nombre</th>
                                        <th>Celular</th>
                                        <th>Teléfono</th>
                                        <th>Empresa</th>
                                        <th>Email</th>
                                        <th>Dirección</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyProveedores">
                                    <!-- Se carga con JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /.content -->
</div> <!-- /.content-wrapper -->

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>

<!-- Modal Crear -->
<div class="modal fade" id="modal-create">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1d36b6;color: white">
                <h4 class="modal-title">Creación de un nuevo proveedor</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formCreateProveedor">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Nombre *</label>
                            <input type="text" name="nombre_proveedor" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Celular *</label>
                            <input type="number" name="celular" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label>Teléfono</label>
                            <input type="number" name="telefono" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Empresa *</label>
                            <input type="text" name="empresa" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Dirección *</label>
                            <textarea name="direccion" class="form-control" rows="2" required></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btnSaveProveedor" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #116f4a;color: white">
                <h4 class="modal-title">Editar proveedor</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formEditProveedor">
                    <input type="hidden" name="id_proveedor" id="edit_id">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Nombre *</label>
                            <input type="text" name="nombre_proveedor" id="edit_nombre" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Celular *</label>
                            <input type="number" name="celular" id="edit_celular" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label>Teléfono</label>
                            <input type="number" name="telefono" id="edit_telefono" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Empresa *</label>
                            <input type="text" name="empresa" id="edit_empresa" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label>Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Dirección *</label>
                            <textarea name="direccion" id="edit_direccion" class="form-control" rows="2" required></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btnUpdateProveedor" class="btn btn-success">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<script>
    const API_URL = "<?php echo $URL; ?>/api/proveedores/index.php";

    //Cargar proveedores al iniciar
    document.addEventListener("DOMContentLoaded", cargarProveedores);

    function cargarProveedores() {
        fetch(API_URL)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const tbody = document.getElementById("tbodyProveedores");
                    tbody.innerHTML = "";
                    data.data.forEach((p, index) => {
                        tbody.innerHTML += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${p.nombre_proveedor}</td>
                            <td><a href="https://wa.me/57${p.celular}" target="_blank" class="btn btn-success btn-sm">${p.celular}</a></td>
                            <td>${p.telefono ?? ""}</td>
                            <td>${p.empresa}</td>
                            <td>${p.email ?? ""}</td>
                            <td>${p.direccion}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="abrirEditar(${p.id_proveedor})"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-danger btn-sm" onclick="eliminarProveedor(${p.id_proveedor})"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    `;
                    });
                }
            });
    }

    //Crear proveedor
    document.getElementById("btnSaveProveedor").addEventListener("click", () => {
        const form = document.getElementById("formCreateProveedor");
        const formData = Object.fromEntries(new FormData(form).entries());

        fetch(API_URL, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(formData)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Proveedor creado correctamente");
                    $('#modal-create').modal('hide');
                    form.reset();
                    cargarProveedores();
                } else {
                    alert("Error: " + data.error);
                }
            });
    });

    //Abrir modal de edición
    function abrirEditar(id) {
        fetch(`${API_URL}?id=${id}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const p = data.data;
                    document.getElementById("edit_id").value = p.id_proveedor;
                    document.getElementById("edit_nombre").value = p.nombre_proveedor;
                    document.getElementById("edit_celular").value = p.celular;
                    document.getElementById("edit_telefono").value = p.telefono ?? "";
                    document.getElementById("edit_empresa").value = p.empresa;
                    document.getElementById("edit_email").value = p.email ?? "";
                    document.getElementById("edit_direccion").value = p.direccion;
                    $('#modal-edit').modal('show');
                }
            });
    }

    //Actualizar proveedor
    document.getElementById("btnUpdateProveedor").addEventListener("click", () => {
        const form = document.getElementById("formEditProveedor");
        const formData = Object.fromEntries(new FormData(form).entries());

        fetch(API_URL, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(formData)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Proveedor actualizado");
                    $('#modal-edit').modal('hide');
                    cargarProveedores();
                } else {
                    alert("Error: " + data.error);
                }
            });
    });

    //Eliminar proveedor
    function eliminarProveedor(id) {
        if (confirm("¿Seguro que deseas eliminar este proveedor?")) {
            fetch(`${API_URL}?id=${id}`, {
                    method: "DELETE"
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert("Proveedor eliminado");
                        cargarProveedores();
                    }
                });
        }
    }
</script>