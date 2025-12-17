<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');
//include('../app/controllers/roles/listado_de_roles.php');


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Listado de roles</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Roles registrado</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>Nro</center>
                                        </th>
                                        <th>
                                            <center>Nombre del rol</center>
                                        </th>
                                        <th>
                                            <center>Acciones</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="roles-body">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>
                                            <center>Nro</center>
                                        </th>
                                        <th>
                                            <center>Nombre del rol</center>
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

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Modal Eliminar -->
<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalDeleteLabel">Eliminar Rol</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p>¿Está seguro de que desea eliminar este rol?</p>
                <input type="hidden" id="delete-id-rol">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btn-confirm-delete">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const API_BASE = "/api/roles"; // ajusta si tu base es distinta
        let tablaRoles = null;

        // 1) Cargar roles y devolver la lista (no inicializa DataTable)
        async function cargarRolesData() {
            const resp = await fetch(`${API_BASE}/read.php`);
            if (!resp.ok) throw new Error("Error cargando roles");
            const roles = await resp.json();
            return roles;
        }

        // 2) Renderizar filas en el tbody
        function renderRows(roles) {
            const tbody = document.getElementById("roles-body");
            tbody.innerHTML = "";

            roles.forEach((rol, index) => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                <td><center>${index + 1}</center></td>
                <td>${rol.rol}</td>
                <td>
                    <center>
                        <div class="btn-group">
                            <a href="update.php?id=${rol.id_rol}" class="btn btn-success">
                                <i class="fa fa-pencil-alt"></i> Editar
                            </a>
                            <button class="btn btn-danger btn-delete" data-id="${rol.id_rol}">
                                <i class="fa fa-trash"></i> Eliminar
                            </button>
                        </div>
                    </center>
                </td>`;
                tbody.appendChild(tr);
            });
        }

        // 3) Inicializar DataTable (si ya existe lo destruye y lo recrea)
        function initDataTable() {
            if ($.fn.DataTable.isDataTable('#example1')) {
                $('#example1').DataTable().destroy();
            }

            tablaRoles = $("#example1").DataTable({
                pageLength: 5,
                responsive: true,
                lengthChange: true,
                autoWidth: false,
                language: {
                    emptyTable: "No hay información",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ Roles",
                    infoEmpty: "Mostrando 0 a 0 de 0 Roles",
                    infoFiltered: "(Filtrado de _MAX_ total Roles)",
                    lengthMenu: "Mostrar _MENU_ Roles",
                    search: "Buscador:",
                    zeroRecords: "Sin resultados encontrados",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                },
                buttons: [{
                        extend: "collection",
                        text: "Reportes",
                        buttons: [{
                                extend: "copy",
                                text: "Copiar"
                            },
                            {
                                extend: "pdf"
                            },
                            {
                                extend: "csv"
                            },
                            {
                                extend: "excel"
                            },
                            {
                                extend: "print",
                                text: "Imprimir"
                            }
                        ]
                    },
                    {
                        extend: "colvis",
                        text: "Visor de columnas"
                    }
                ]
            });

            tablaRoles.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        }

        async function cargarYMostrar() {
            try {
                const roles = await cargarRolesData();

                
                if ($.fn.DataTable.isDataTable('#example1')) {
                    $('#example1').DataTable().clear().destroy();
                }

                renderRows(roles);
                initDataTable(); 

            } catch (err) {
                console.error(err);
                alert("Error al cargar roles");
            }
        }

        // 5) Función que setea el id en el modal (global)
        function setDeleteId(id) {
            document.getElementById("delete-id-rol").value = id;
        }
        window.setDeleteId = setDeleteId;


        $('#example1 tbody').off('click').on('click', '.btn-delete', function(e) {
            const id = $(this).data('id');
            setDeleteId(id);
            $('#modal-delete').modal('show');
        });

        document.getElementById("btn-confirm-delete").addEventListener("click", async function() {
            const idRol = document.getElementById("delete-id-rol").value;
            if (!idRol) return alert("ID no válido.");

            if (!confirm("¿Desea eliminar este rol?")) return;

            try {
                const resp = await fetch(`${API_BASE}/delete.php`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        id_rol: idRol
                    })
                });

                const data = await resp.json();

                if (data.success) {
                    $('#modal-delete').modal('hide');
                    await cargarYMostrar();
                } else {
                    alert("Error: " + (data.message || "no se pudo eliminar"));
                }
            } catch (err) {
                console.error("Error al eliminar rol:", err);
                alert("Error al eliminar rol");
            }
        });

        cargarYMostrar();
    });
</script>