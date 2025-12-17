<?php
include('app/config.php');
include('layout/sesion.php');
include('layout/parte1.php');
?>

<style>

    /* Suavizar tarjetas */
    .small-box {
        border-radius: 14px;
        box-shadow: 0 8px 18px rgba(0, 0, 0, .08);
        transition: all .3s ease;
    }

    /* Hover elegante */
    .small-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 14px 30px rgba(0, 0, 0, .15);
    }

    /* Números principales */
    .small-box .inner h3 {
        font-size: 2.3rem;
        font-weight: 700;
        margin-bottom: 4px;
    }

    /* Texto */
    .small-box .inner p {
        font-size: .95rem;
        opacity: .95;
    }

    /* Íconos grandes y suaves */
    .small-box .icon i {
        font-size: 60px;
        opacity: .25;
        transition: transform .3s ease;
    }

    .small-box:hover .icon i {
        transform: scale(1.15);
    }

    /* Footer más limpio */
    .small-box-footer {
        font-weight: 500;
        background: rgba(0, 0, 0, .15);
    }

    /* Título principal */
    .content-header h1 {
        font-weight: 700;
    }

    /* Espaciado general */
    .content-wrapper {
        background-color: #f4f6f9;
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-sm-12">
                    <h1 class="m-0">
                        Bienvenido al SISTEMA de VENTAS
                        <small class="text-muted d-block mt-1">
                            <?php echo $rol_sesion; ?>
                        </small>
                    </h1>
                </div>
            </div>
        </div>
    </div>

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
                                <div class="icon"><i class="fas fa-user-plus"></i></div>
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
                                <div class="icon"><i class="fas fa-address-card"></i></div>
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
                                <div class="icon"><i class="fas fa-tags"></i></div>
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
                                <div class="icon"><i class="fas fa-list"></i></div>
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
                                <div class="icon"><i class="fas fa-car"></i></div>
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
                                <div class="icon"><i class="fas fa-cart-plus"></i></div>
                            </a>
                            <a href="<?php echo $URL; ?>/compras" class="small-box-footer">
                                Más detalles <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                <?php endif; ?>

                <!-- Ventas -->
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

            </div>
        </div>
    </div>
</div>

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
                }
            })
            .catch(err => console.error("Error cargando resumen:", err));
    });
</script>