<?php ob_start(); // ¡ESTA DEBE SER LA PRIMERA LÍNEA! 
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Star Software</title>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo $URL; ?>/public/templeates/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="<?php echo $URL; ?>/public/templeates/AdminLTE-3.2.0/dist/css/adminlte.min.css">

    <!-- DataTables (CDN) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- jQuery (solo una vez) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables JS (CDN) -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <!-- Dependencias de reportes -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


</head>

<body class="hold-transition sidebar-mini">

    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">The Star Software </a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?php echo $URL; ?>" class="brand-link">
                <img src="<?php echo $URL; ?>/imagenes/the_star.png" alt="Star_logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">The Star Software</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?php echo $URL; ?>/public/templeates/AdminLTE-3.2.0/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <!-- $nombres_sesion viene de layout/sesion.php -->
                        <a href="#" class="d-block"><?php echo htmlspecialchars($nombres_sesion ?? 'Invitado'); ?></a>
                    </div>
                </div>


                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <?php if (isset($_SESSION['sesion_rol']) && $_SESSION['sesion_rol'] == 1): ?>
                            <li class="nav-item ">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Usuarios
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo $URL; ?>/usuarios" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de usuarios</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo $URL; ?>/usuarios/create.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Creación de usuario</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['sesion_rol']) && $_SESSION['sesion_rol'] == 1): ?>
                            <li class="nav-item ">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas fa-address-card"></i>
                                    <p>
                                        Roles
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo $URL; ?>/roles" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de roles</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo $URL; ?>/roles/create.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Creación de rol</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['sesion_rol']) && $_SESSION['sesion_rol'] == 1): ?>
                            <li class="nav-item ">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas fa-tags"></i>
                                    <p>
                                        Categorías
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo $URL; ?>/categorias" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de categorías</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['sesion_rol']) && $_SESSION['sesion_rol'] == 1): ?>
                            <li class="nav-item ">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>
                                        Almacen
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo $URL; ?>/almacen" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de productos</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo $URL; ?>/almacen/create.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Creación de productos</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo $URL; ?>/almacen/movimientos.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Movimientos</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['sesion_rol']) && $_SESSION['sesion_rol'] == 1): ?>
                            <li class="nav-item ">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas fa-cart-plus"></i>
                                    <p>
                                        Compras
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo $URL; ?>/compras" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de compras</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo $URL; ?>/compras/create.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Creación de compra</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['sesion_rol']) && $_SESSION['sesion_rol'] == 1): ?>
                            <li class="nav-item ">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        Clientes
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo $URL; ?>/clientes" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de clientes</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo $URL; ?>/clientes/create.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Creación de clientes</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['sesion_rol']) && $_SESSION['sesion_rol'] == 1): ?>
                            <li class="nav-item ">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas fa-car"></i>
                                    <p>
                                        Proveedores
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo $URL; ?>/proveedores" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de proveedores</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item ">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-shopping-basket"></i>
                                <p>
                                    Ventas
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo $URL; ?>/ventas" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Listado de ventas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo $URL; ?>/ventas/create.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Realizar venta</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php if (isset($_SESSION['sesion_rol']) && $_SESSION['sesion_rol'] == 1): ?>
                        <!-- Reportes -->
                        <li class="nav-item ">
                            <a href="#" class="nav-link active">
                                <i class="fas fa-chart-line nav-icon"></i>
                                <p>
                                    Reportes
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo $URL; ?>/reportes/index.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Reportes</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
<!-- fin reportes --> <?php endif; ?>


                        <li class="nav-item">
                            <a href="<?php echo $URL; ?>/app/controllers/login/cerrar_sesion.php" class="nav-link" style="background-color: #ca0a0b">
                                <i class="nav-icon fas fa-door-closed"></i>
                                <p>
                                    Cerrar Sesión
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>