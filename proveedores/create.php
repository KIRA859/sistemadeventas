<?php
/*include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');
include('../app/controllers/proveedores/listado_de_proveedores.php');


?>
<!--content wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Registro de un nuevo proveedor</h1>
                    <?php
                    if (isset($_SESSION['mensaje'])) {
                        echo '<div class="alert alert-danger" role="alert">' . $_SESSION['mensaje'] . '</div>';
                        unset($_SESSION['mensaje']);
                    }
                    ?>
                </div><!--/.col-->
            </div><!--/.row-->
        </div><!-- /.container-fluid -->
    </div>


    <!-- /.content-header -->
    <!--Main content-->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Llene los datos con cuidado</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <form action="../app/controllers/proveedores/create.php" method="post">

                                <!-- FILA 1 -->
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label>Nombre de la empresa:</label>
                                        <input type="text" name="nombre_empresa" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label>NIT de la empresa:</label>
                                        <input type="text" name="nit" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Teléfono:</label>
                                        <input type="text" name="telefono" class="form-control" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Correo de la empresa:</label>
                                        <input type="email" name="correo" class="form-control">
                                    </div>
                                </div>

                                <!-- FILA 2 -->
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label>Dirección:</label>
                                        <input type="text" name="direccion" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Nombre del Representante legal:</label>
                                        <input type="text" name="nombre_representante" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Categoría del proveedor:</label>
                                        <select name="categoria" class="form-control">
                                            <option value="">Seleccione</option>
                                            <?php foreach ($categorias_datos as $cat) { ?>
                                                <option value="<?php echo $cat['id_categoria']; ?>">
                                                    <?php echo $cat['nombre_categoria']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Condiciones de pago (días):</label>
                                        <input type="number" name="condicion_pago" class="form-control" placeholder="Ej: 30">
                                    </div>
                                </div>

                                <!-- FILA 3 -->
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label>Banco y número de cuenta:</label>
                                        <input type="text" name="banco" class="form-control" placeholder="Ej: Banco ABC - 123456">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Observaciones:</label>
                                        <textarea name="observaciones" class="form-control" rows="1" placeholder="Notas adicionales"></textarea>
                                    </div>
                                </div>

                                <hr>
                                <div class="form-group">
                                    <a href="../almacen/listado_de_productos" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-primary">Guardar Proveedor</button>
                                </div>

                            </form>
                        </div>
                        <!-- /.card-body -->

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- /.content-wrapper-->

    <?php include('../layout/mensajes.php'); ?>
    <?php include('../layout/parte2.php'); ?>

    <script>
        function calcularPrecioVenta() {
            let compra = parseFloat(document.getElementById('precio_compra').value);
            let ganancia = parseFloat(document.getElementById('porcentaje_ganancia').value);

            if (!isNaN(compra) && !isNaN(ganancia)) {
                let venta = compra + (compra * ganancia / 100);
                document.getElementById('precio_venta').value = venta.toFixed(2);
            } else {
                document.getElementById('precio_venta').value = '';
            }
        }
    </script>


    <!--Este script es para calcular la utilidad estimada automaticamente-->
    <script>
        function calcularPrecioVenta() {
            let compra = parseFloat(document.getElementById('precio_compra').value);
            let ganancia = parseFloat(document.getElementById('porcentaje_ganancia').value);

            if (!isNaN(compra) && !isNaN(ganancia)) {
                let venta = compra + (compra * ganancia / 100);
                document.getElementById('precio_venta').value = Math.round(venta);

            } else {
                document.getElementById('precio_venta').value = '';
            }
        }

        function calcularGanancia() {
            let compra = parseFloat(document.getElementById('precio_compra').value);
            let venta_real = parseFloat(document.getElementById('precio_venta_real').value);

            if (!isNaN(compra) && compra > 0 && !isNaN(venta_real)) {
                let ganancia = ((venta_real - compra) / compra) * 100;
                document.getElementById('ganancia_obtenida').value = Math.round(ganancia) + "%";
            } else {
                document.getElementById('ganancia_obtenida').value = '';
            }
        }
    </script>*/
