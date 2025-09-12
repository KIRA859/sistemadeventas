<?php
include('app/config.php');
include('layout/sesion.php');
include('layout/parte1.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Bienvenido al SISTEMA de VENTAS - <?php echo $rol_sesion; ?> </h1>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">

                <?php if ($_SESSION['sesion_rol'] == 1): ?>
                <!-- Usuarios -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 id="usuarios-count">0</h3>
                            <p>Usuarios Registrados</p>
                        </div>
                        <a href="<?php echo $URL; ?>/usuarios/create.php">
                            <div class="icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                        </a>
                        <a href="<?php echo $URL; ?>/usuarios" class="small-box-footer">
                            Más detalle <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Roles -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3 id="roles-count">0</h3>
                            <p>Roles Registrados</p>
                        </div>
                        <a href="<?php echo $URL; ?>/roles/create.php">
                            <div class="icon">
                                <i class="fas fa-address-card"></i>
                            </div>
                        </a>
                        <a href="<?php echo $URL; ?>/roles" class="small-box-footer">
                            Más detalle <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Categorías -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 id="categorias-count">0</h3>
                            <p>Categorías Registradas</p>
                        </div>
                        <a href="<?php echo $URL; ?>/categorias">
                            <div class="icon">
                                <i class="fas fa-tags"></i>
                            </div>
                        </a>
                        <a href="<?php echo $URL; ?>/categorias" class="small-box-footer">
                            Más detalle <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Productos -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3 id="productos-count">0</h3>
                            <p>Productos Registrados</p>
                        </div>
                        <a href="<?php echo $URL; ?>/almacen/create.php">
                            <div class="icon">
                                <i class="fas fa-list"></i>
                            </div>
                        </a>
                        <a href="<?php echo $URL; ?>/almacen" class="small-box-footer">
                            Más detalle <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Proveedores -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-dark">
                        <div class="inner">
                            <h3 id="proveedores-count">0</h3>
                            <p>Proveedores Registrados</p>
                        </div>
                        <a href="<?php echo $URL; ?>/proveedores">
                            <div class="icon">
                                <i class="fas fa-car"></i>
                            </div>
                        </a>
                        <a href="<?php echo $URL; ?>/proveedores" class="small-box-footer">
                            Más detalle <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Compras -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3 id="compras-count">0</h3>
                            <p>Compras Registradas</p>
                        </div>
                        <a href="<?php echo $URL; ?>/compras">
                            <div class="icon">
                                <i class="fas fa-cart-plus"></i>
                            </div>
                        </a>
                        <a href="<?php echo $URL; ?>/compras" class="small-box-footer">
                            Más detalles <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Ventas (visible para todos) -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3 id="ventas-count">0</h3>
                            <p>Ventas Registradas</p>
                        </div>
                        <a href="<?php echo $URL; ?>/ventas/create.php">
                            <div class="icon" title="Registrar venta">
                                <i class="fas fa-cart-plus"></i>
                            </div>
                        </a>
                        <a href="<?php echo $URL; ?>/ventas" class="small-box-footer">
                            Más detalles <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include('layout/parte2.php'); ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    fetch("<?php echo $URL; ?>/api/summary.php")
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                document.getElementById("usuarios-count").textContent = data.data.usuarios;
                document.getElementById("roles-count").textContent = data.data.roles;
                document.getElementById("categorias-count").textContent = data.data.categorias;
                document.getElementById("productos-count").textContent = data.data.productos;
                document.getElementById("proveedores-count").textContent = data.data.proveedores;
                document.getElementById("compras-count").textContent = data.data.compras;
                document.getElementById("ventas-count").textContent = data.data.ventas;
            } else {
                console.error(data.message);
            }
        })
        .catch(err => console.error("Error cargando resumen:", err));
});
</script>
