<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Encabezado -->
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
                                            <center>Nombre de la categoría</center>
                                        </th>
                                        <th>
                                            <center>Acciones</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="categorias-body">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>
                                            <center>Nro</center>
                                        </th>
                                        <th>
                                            <center>Nombre de la categoría</center>
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

<!--MODAL CREAR -->
<div class="modal fade" id="modal-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1d36b6;color: white">
                <h4 class="modal-title">Creación de una nueva categoría</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="nombre_categoria">Nombre de la categoría <b>*</b></label>
                    <input type="text" id="nombre_categoria" class="form-control" placeholder="Ingrese el nombre de la categoría">
                    <small style="color: red;display: none" id="lbl_create">* Este campo es requerido</small>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn_create">Guardar categoría</button>
            </div>
        </div>
    </div>
</div>

<!--SCRIPT CRUD -->
<script>
    // Variable global para DataTable
    let dataTable;

    async function cargarCategorias() {
        try {
            const resp = await fetch("../api/categorias/categorias.php");
            if (!resp.ok) {
                throw new Error(`Error HTTP: ${resp.status}`);
            }
            const data = await resp.json();
            const tbody = document.getElementById("categorias-body");
            tbody.innerHTML = "";

            if (data.success) {
                data.categorias.forEach((cat, i) => {
                    tbody.innerHTML += `
                    <tr>
                        <td><center>${i + 1}</center></td>
                        <td>${cat.nombre_categoria}</td>
                        <td>
                            <center>
                                <button class="btn btn-success btn-sm" onclick="editarCategoria(${cat.id_categoria}, '${cat.nombre_categoria.replace(/'/g, "\\'")}')">
                                    <i class="fa fa-pencil-alt"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="eliminarCategoria(${cat.id_categoria})">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </center>
                        </td>
                    </tr>
                `;
                });

                // Destruir DataTable existente si hay uno
                if ($.fn.DataTable.isDataTable('#tabla-categorias')) {
                    dataTable.destroy();
                }

                // Inicializar DataTable
                dataTable = $('#tabla-categorias').DataTable({
                    "pageLength": 5,
                    "language": {
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Categorías",
                        "infoEmpty": "Mostrando 0 a 0 de 0 Categorías",
                        "infoFiltered": "(Filtrado de _MAX_ total Categorías)",
                        "lengthMenu": "Mostrar _MENU_ Categorías",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscador:",
                        "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Último",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    },
                    "responsive": true,
                    "lengthChange": true,
                    "autoWidth": false,
                    buttons: [{
                            extend: 'collection',
                            text: 'Reportes',
                            buttons: ['copy', 'pdf', 'csv', 'excel', 'print']
                        },
                        {
                            extend: 'colvis',
                            text: 'Visor de columnas'
                        }
                    ]
                }).buttons().container().appendTo('#tabla-categorias_wrapper .col-md-6:eq(0)');
            } else {
                console.error("Error en la respuesta del servidor:", data.message);
            }
        } catch (err) {
            console.error("Error cargando categorías:", err);
        }
    }

    function mostrarMensaje(tipo, mensaje) {
        Swal.fire({
            icon: tipo,
            title: mensaje,
            showConfirmButton: true,
            confirmButtonText: 'Aceptar',
            timer: tipo === 'success' ? 3000 : undefined
        });
    }

    // Crear categoría
    document.getElementById("btn_create").addEventListener("click", async () => {
        const nombre = document.getElementById("nombre_categoria").value.trim();
        const lblError = document.getElementById("lbl_create");

        if (!nombre) {
            lblError.style.display = "block";
            return;
        }
        lblError.style.display = "none";

        try {
            const resp = await fetch("../api/categorias/categorias.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    nombre_categoria: nombre
                })
            });

            const data = await resp.json();

            if (data.success) {
                // Mostrar mensaje de éxito
                mostrarMensaje("success", data.message || "Categoría creada correctamente");

                // Limpiar campo
                document.getElementById("nombre_categoria").value = "";

                // Cerrar modal
                $('#modal-create').modal('hide');

                // Recargar tabla
                cargarCategorias();
            } else {
                mostrarMensaje("error", data.message || "Error al crear categoría");
            }
        } catch (error) {
            console.error("Error:", error);
            mostrarMensaje("error", "Error de conexión con el servidor");
        }
    });

    // Editar categoría
    async function editarCategoria(id, nombre) {
        const nuevoNombre = prompt("Editar categoría:", nombre);
        if (nuevoNombre === null) return; // Usuario canceló
        if (!nuevoNombre.trim()) {
            alert("El nombre no puede estar vacío");
            return;
        }

        try {
            const resp = await fetch("../api/categorias/categorias.php", {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    id_categoria: id,
                    nombre_categoria: nuevoNombre
                })
            });

            const data = await resp.json();
            if (data.success) {
                mostrarMensaje("success", "Categoría actualizada correctamente");
                cargarCategorias();
            } else {
                mostrarMensaje("error", data.message || "Error al actualizar categoría");
            }
        } catch (error) {
            console.error("Error:", error);
            mostrarMensaje("error", "Error de conexión");
        }
    }

    // Eliminar categoría
    async function eliminarCategoria(id) {
        if (!confirm("¿Está seguro de que desea eliminar esta categoría?")) return;

        try {
            const resp = await fetch("../api/categorias/categorias.php", {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    id_categoria: id
                })
            });

            const data = await resp.json();
            if (data.success) {
                mostrarMensaje("success", "Categoría eliminada correctamente");
                cargarCategorias();
            } else {
                mostrarMensaje("error", data.message || "Error al eliminar categoría");
            }
        } catch (error) {
            console.error("Error:", error);
            mostrarMensaje("error", "Error de conexión");
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        cargarCategorias();
    });
</script>