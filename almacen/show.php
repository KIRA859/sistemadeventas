<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Datos del producto</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Datos del producto</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="codigo">Código:</label>
                                                <input type="text" id="codigo" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="categoria">Categoría:</label>
                                                <input type="text" id="categoria" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nombre">Nombre del producto:</label>
                                                <input type="text" id="nombre" class="form-control" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="usuario">Usuario</label>
                                                <input type="text" id="usuario" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="descripcion">Descripción del producto:</label>
                                                <textarea id="descripcion" cols="30" rows="2" class="form-control" disabled></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="stock">Stock:</label>
                                                <input type="number" id="stock" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="stock_minimo">Stock mínimo:</label>
                                                <input type="number" id="stock_minimo" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="stock_maximo">Stock máximo:</label>
                                                <input type="number" id="stock_maximo" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="precio_compra">Precio compra:</label>
                                                <input type="number" id="precio_compra" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="precio_venta">Precio venta:</label>
                                                <input type="number" id="precio_venta" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="fecha_ingreso">Fecha de ingreso:</label>
                                                <input type="date" id="fecha_ingreso" class="form-control" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="imagen">Imagen del producto</label>
                                        <center>
                                            <img id="imagen" width="100%" alt="Producto">
                                        </center>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="form-group">
                                <a href="index.php" class="btn btn-secondary">Cancelar</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>

<script src="show.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", async () => {
        // Obtén el id del producto desde la URL
        const params = new URLSearchParams(window.location.search);
        const idProducto = params.get("id");

        if (!idProducto) {
            console.error("No se recibió un id de producto en la URL.");
            return;
        }

        try {
            const response = await fetch(`../../api/almacen/show.php`);
            if (!response.ok) throw new Error("Error al consultar API");

            const data = await response.json();

            if (!data.success) {
                console.error("❌ API respondió con error:", data.message);
                return;
            }

            // Buscar el producto que corresponde al id
            const producto = data.productos.find(p => p.id_producto == idProducto);

            if (!producto) {
                console.error(`Producto con id ${idProducto} no encontrado`);
                return;
            }

            // Llenar campos en el DOM
            document.getElementById("codigo").value = producto.codigo;
            document.getElementById("categoria").value = producto.nombre_categoria;
            document.getElementById("nombre").value = producto.nombre;
            document.getElementById("usuario").value = producto.email;
            document.getElementById("descripcion").value = producto.descripcion;
            document.getElementById("stock").value = producto.stock;
            document.getElementById("stock_minimo").value = producto.stock_minimo;
            document.getElementById("stock_maximo").value = producto.stock_maximo;
            document.getElementById("precio_compra").value = producto.precio_compra;
            document.getElementById("precio_venta").value = producto.precio_venta;
            document.getElementById("fecha_ingreso").value = producto.fecha_ingreso;

            const img = document.getElementById("imagen");
            img.src = `../../almacen/img_productos/${producto.imagen}`;
            img.alt = producto.nombre;

            console.log("Producto cargado:", producto);
        } catch (error) {
            console.error("Error en fetch:", error);
        }
    });
</script>

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>