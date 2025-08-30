<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');
include('../app/controllers/almacen/movimientos.php');
include ('../app/controllers/almacen/listado_de_productos.php');
include ('../app/controllers/clientes/listado_de_clientes.php');
include ('../app/controllers/estados_venta/listado_de_estados_venta.php');
include ('../app/controllers/ventas/listado_de_ventas.php'); 
include ('../app/controllers/ventas/listado_de_formas_pago.php');

// Define una función para obtener el nombre del producto y el email del usuario
// Esto es necesario para mostrar nombres en lugar de solo IDs
function obtenerDatosRelacionados($conexion, $id_producto, $id_usuario)
{
    // Lógica para obtener el nombre del producto
    $sql_producto = "SELECT nombre FROM tb_almacen WHERE id_producto = :id_producto";
    $query_producto = $conexion->prepare($sql_producto);
    $query_producto->execute(['id_producto' => $id_producto]);
    $producto_nombre = $query_producto->fetch(PDO::FETCH_ASSOC)['nombre'] ?? 'No encontrado';

    // Lógica para obtener el email del usuario
    $sql_usuario = "SELECT email FROM tb_usuarios WHERE id_usuario = :id_usuario";
    $query_usuario = $conexion->prepare($sql_usuario);
    $query_usuario->execute(['id_usuario' => $id_usuario]);
    $usuario_email = $query_usuario->fetch(PDO::FETCH_ASSOC)['email'] ?? 'No encontrado';

    return ['producto' => $producto_nombre, 'usuario' => $usuario_email];
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Listado de Movimientos de Inventario</h1>
                </div></div></div></div>
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Movimientos recientes</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body" style="display: block;">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID Movimiento</th>
                                        <th>ID Producto</th>
                                        <th>Producto</th>
                                        <th>Tipo Movimiento</th>
                                        <th>Cantidad</th>
                                        <th>Descripción</th>
                                        <th>Fecha y Hora</th>
                                        <th>Usuario</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $contador = 0;
                                    include('../app/controllers/almacen/movimientos.php');

                                    foreach ($movimientos_datos as $movimiento) {
                                        $contador = $contador + 1;
                                        // Obtener datos relacionados
                                        $datos_relacionados = obtenerDatosRelacionados($pdo, $movimiento['id_producto'], $movimiento['id_usuario']);
                                    ?>
                                        <tr>
                                            <td><?php echo $contador; ?></td>
                                            <td><?php echo $movimiento['id_producto']; ?></td>
                                            <td><?php echo $datos_relacionados['producto']; ?></td>
                                            <td>
                                                <?php
                                                $tipo = $movimiento['tipo_movimiento'];
                                                if ($tipo == 'ENTRADA') {
                                                    echo '<span class="badge badge-success">ENTRADA</span>';
                                                } elseif ($tipo == 'SALIDA') {
                                                    echo '<span class="badge badge-danger">SALIDA</span>';
                                                } else {
                                                    echo '<span class="badge badge-warning">AJUSTE</span>';
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $movimiento['cantidad']; ?></td>
                                            <td><?php echo $movimiento['descripcion']; ?></td>
                                            <td><?php echo $movimiento['fecha_movimiento']; ?></td>
                                            <td><?php echo $datos_relacionados['usuario']; ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            </div></div>
    </div>
<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>

<script>
    $(function() {
        $("#example1").DataTable({
            "pageLength": 10,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Movimientos",
                "infoEmpty": "Mostrando 0 a 0 de 0 Movimientos",
                "infoFiltered": "(Filtrado de _MAX_ total Movimientos)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Movimientos",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscador:",
                "zeroRecords": "No se encontraron resultados",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "responsive": true,
            "autoWidth": false,
        });
    });
</script>