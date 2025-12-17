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
                    <h1 class="m-0">Listado de Categorías
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
                            <i class="fa fa-plus"></i> Agregar Nuevo
                        </button>
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Categorías registradas</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="tabla-categorias" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>Nro</center>
                                        </th>
                                        <th>
                                            <center>Nombre</center>
                                        </th>
                                        <th>
                                            <center>Acciones</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="categorias-body"></tbody>
                                <tfoot>
                                    <tr>
                                        <th>
                                            <center>Nro</center>
                                        </th>
                                        <th>
                                            <center>Nombre</center>
                                        </th>
                                        <th>
                                            <center>Acciones</center>
                                        </th>
                                    </tr>
                                </tfoot>
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

<!-- MODAL -->
<div class="modal fade" id="modal-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#1d36b6;color:white">
                <h4 class="modal-title">Nueva Categoría</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Nombre de la categoría *</label>
                    <input type="text" id="nombre_categoria" class="form-control">
                    <small id="lbl_create" style="color:red;display:none">* Campo requerido</small>
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" id="btn_create">Guardar</button>
            </div>

        </div>
    </div>
</div>

<!-- ================== CRUD SCRIPT ================== -->
<script>
    const API_URL = "https://sistemadeventas.infinityfree.me/api/categorias/categorias.php";
    let dataTable = null;

    async function cargarCategorias() {
        try {
            const resp = await fetch(API_URL, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    accion: "listar"
                })
            });

            if (!resp.ok) throw new Error("HTTP " + resp.status);
            const data = await resp.json();

            const tbody = document.getElementById("categorias-body");

            // 1) Destruir DataTable anterior si existe (antes de modificar el tbody)
            if (dataTable && $.fn.DataTable.isDataTable('#tabla-categorias')) {
                try {
                    dataTable.clear();
                    dataTable.destroy();
                } catch (err) {
                    console.warn("Warning al destruir dataTable:", err);
                }
                dataTable = null;
            }

            // 2) Reconstruir el tbody
            tbody.innerHTML = "";

            if (!data.success) {
                console.error("Error del servidor:", data.message);
                return;
            }

            data.categorias.forEach((cat, i) => {
                tbody.innerHTML += `
                <tr>
                    <td><center>${i + 1}</center></td>
                    <td>${cat.nombre_categoria}</td>
                    <td>
                        <center>
                            <button class="btn btn-success btn-sm"
                                onclick="editarCategoria(${cat.id_categoria}, '${cat.nombre_categoria.replace(/'/g, "\\'")}')">
                                <i class="fa fa-pencil-alt"></i>
                            </button>

                            <button class="btn btn-danger btn-sm"
                                onclick="eliminarCategoria(${cat.id_categoria})">
                                <i class="fa fa-trash"></i>
                            </button>
                        </center>
                    </td>
                </tr>
            `;
            });

            // 3) Espera pequeño para asegurar que el DOM haya insertado las filas
            setTimeout(() => {
                // Inicializar DataTable solo UNA vez
                dataTable = $('#tabla-categorias').DataTable({
                    pageLength: 5,
                    responsive: true,
                    autoWidth: false
                });
            }, 80);

        } catch (e) {
            console.error("Error cargando categorías:", e);
        }
    }

    /* =============================
           CREAR CATEGORÍA
    ============================= */
    document.getElementById("btn_create").addEventListener("click", async () => {
        const nombre = document.getElementById("nombre_categoria").value.trim();
        const lbl = document.getElementById("lbl_create");

        if (!nombre) {
            lbl.style.display = "block";
            return;
        }
        lbl.style.display = "none";

        const resp = await fetch(API_URL, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                accion: "crear",
                nombre_categoria: nombre
            })
        });

        const data = await resp.json();

        if (data.success) {
            Swal.fire("Éxito", "Categoría creada", "success");
            $("#modal-create").modal("hide");
            cargarCategorias();
        } else {
            Swal.fire("Error", data.message, "error");
        }
    });

    /* =============================
              EDITAR
    ============================= */
    async function editarCategoria(id, nombre) {
        const nuevo = prompt("Editar nombre:", nombre);
        if (nuevo === null) return;
        if (!nuevo.trim()) return alert("El nombre no puede estar vacío");

        const resp = await fetch(API_URL, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                accion: "editar",
                id_categoria: id,
                nombre_categoria: nuevo
            })
        });

        const data = await resp.json();

        if (data.success) {
            Swal.fire("Actualizado", "Categoría modificada", "success");
            cargarCategorias();
        } else {
            Swal.fire("Error", data.message, "error");
        }
    }

    /* =============================
              ELIMINAR
    ============================= */
    async function eliminarCategoria(id) {
        if (!confirm("¿Eliminar esta categoría?")) return;

        const resp = await fetch(API_URL, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                accion: "eliminar",
                id_categoria: id
            })
        });

        const data = await resp.json();

        if (data.success) {
            Swal.fire("Eliminado", "Categoría borrada", "success");
            cargarCategorias();
        } else {
            Swal.fire("Error", data.message, "error");
        }
    }

    document.addEventListener("DOMContentLoaded", cargarCategorias);
</script>