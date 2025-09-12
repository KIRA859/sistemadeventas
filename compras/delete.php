<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

$id_compra_get = $_GET['id'] ?? null;
if (!$id_compra_get) {
    $_SESSION['mensaje'] = "Error: No se recibió el ID de la compra.";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/compras/index.php');
    exit;
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Detalle de la Compra</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-9">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">¿Está seguro de eliminar la compra?</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" id="detalle-compra">
                            <p class="text-center">Cargando datos de la compra...</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Detalle de la compra</h3>
                        </div>
                        <div class="card-body" id="resumen-compra">
                            <p class="text-center">Cargando...</p>
                        </div>

                        <div class="p-3">
                            <button class="btn btn-danger btn-block" id="btn_eliminar">
                                <i class="fa fa-trash"></i> Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
</div>

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>

<script>
    const API_LISTADO = "../api/compras/listado.php";
    const API_COMPRAS = "../api/compras/index.php";
    const idCompra = "<?php echo $id_compra_get; ?>";

    document.addEventListener("DOMContentLoaded", () => {
        // Cargar la compra específica desde la API
        fetch(`${API_COMPRAS}?id=${idCompra}`)
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    document.querySelector("#detalle-compra").innerHTML =
                        `<p class="text-danger">${data.error}</p>`;
                    return;
                }

                const compra = data.data;

                // Render detalle de productos
                document.querySelector("#detalle-compra").innerHTML = `
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Proveedor:</strong> ${compra.nombre_proveedor || 'N/A'}</p>
                        <p><strong>Nro Compra:</strong> ${compra.nro_compra}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Fecha:</strong> ${compra.fecha_compra}</p>
                        <p><strong>Comprobante:</strong> ${compra.comprobante || 'N/A'}</p>
                    </div>
                </div>
                <h5>Productos:</h5>
                <table class="table table-sm table-bordered">
                    <thead class="table-danger">
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${compra.productos.map(prod => `
                            <tr>
                                <td>${prod.nombre_producto || 'Producto ' + prod.id_producto}</td>
                                <td>${prod.cantidad}</td>
                                <td>$${parseFloat(prod.precio_unitario).toFixed(2)}</td>
                                <td>$${parseFloat(prod.subtotal).toFixed(2)}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                    <tfoot>
                        <tr class="table-active">
                            <th colspan="3" class="text-right">Total:</th>
                            <th>$${parseFloat(compra.total_compra).toFixed(2)}</th>
                        </tr>
                    </tfoot>
                </table>
            `;

                // Render resumen
                document.querySelector("#resumen-compra").innerHTML = `
                <p><strong>Nro compra:</strong> ${compra.nro_compra}</p>
                <p><strong>Fecha:</strong> ${compra.fecha_compra}</p>
                <p><strong>Proveedor:</strong> ${compra.nombre_proveedor || 'N/A'}</p>
                <p><strong>Total:</strong> $${parseFloat(compra.total_compra).toFixed(2)}</p>
                <p><strong>Usuario:</strong> ${compra.nombres_usuario || 'N/A'}</p>
                <p><strong>Comprobante:</strong> ${compra.comprobante || 'N/A'}</p>
            `;
            })
            .catch(err => {
                console.error("Error al cargar compra:", err);
                document.querySelector("#detalle-compra").innerHTML =
                    `<p class="text-danger">Error al cargar la compra: ${err.message}</p>`;
            });

        // Eliminar compra
        document.querySelector("#btn_eliminar").addEventListener("click", () => {
            Swal.fire({
                title: '¿Está seguro?',
                text: "Se eliminará la compra #" + idCompra,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`${API_COMPRAS}?id=${idCompra}`, {
                            method: "DELETE"
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire("¡Eliminado!", data.message, "success")
                                    .then(() => {
                                        window.location.href = "<?php echo $URL; ?>/compras";
                                    });
                            } else {
                                Swal.fire("Error", data.error || "No se pudo eliminar", "error");
                            }
                        })
                        .catch(err => {
                            console.error("Error eliminando compra:", err);
                            Swal.fire("Error", "No se pudo conectar con la API", "error");
                        });
                }
            });
        });
    });
</script>