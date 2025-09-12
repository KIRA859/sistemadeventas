<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

$id_compra_get = $_GET['id'] ?? null;

if (!$id_compra_get) {
    $_SESSION['mensaje'] = "Error: Falta ID de la compra.";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/compras/index.php');
    exit;
}

// CONSUMIR API 
$api_url = $URL . "/api/compras/index.php?id=" . urlencode($id_compra_get);

// Usar cURL para mejor manejo de errores
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FAILONERROR, true);
$json = curl_exec($ch);

if (curl_errno($ch)) {
    $_SESSION['mensaje'] = "Error al conectar con la API: " . curl_error($ch);
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/compras/index.php');
    exit;
}

curl_close($ch);

$response = json_decode($json, true);

if (!$response || !isset($response['success'])) {
    $_SESSION['mensaje'] = "Error: Respuesta inválida de la API";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/compras/index.php');
    exit;
}

if (!$response['success']) {
    $_SESSION['mensaje'] = "Error: " . ($response['error'] ?? "No se encontró la compra");
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/compras/index.php');
    exit;
}

if (empty($response['data'])) {
    $_SESSION['mensaje'] = "Error: No se encontraron datos de la compra";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/compras/index.php');
    exit;
}

$compra_general = $response['data'];
$productos_de_la_compra = $compra_general['productos'] ?? [];
?>

<!-- ================== VISTA ================== -->
<div class="content-wrapper">
    <!-- Encabezado -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">
                        Detalles de la Compra Nro:
                        <?php echo htmlspecialchars($compra_general['nro_compra'] ?? 'N/A'); ?>
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
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Información General de la Compra</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Número de Compra:</strong></label>
                                        <p class="form-control-plaintext"><?php echo htmlspecialchars($compra_general['nro_compra'] ?? 'N/A'); ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Fecha de Compra:</strong></label>
                                        <p class="form-control-plaintext"><?php echo htmlspecialchars($compra_general['fecha_compra'] ?? 'N/A'); ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Proveedor:</strong></label>
                                        <p class="form-control-plaintext"><?php echo htmlspecialchars($compra_general['nombre_proveedor'] ?? 'N/A'); ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Comprobante:</strong></label>
                                        <p class="form-control-plaintext"><?php echo htmlspecialchars($compra_general['comprobante'] ?? 'Sin comprobante'); ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Usuario que registró:</strong></label>
                                        <p class="form-control-plaintext"><?php echo htmlspecialchars($compra_general['nombres_usuario'] ?? 'N/A'); ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Total de la Compra:</strong></label>
                                        <p class="form-control-plaintext text-success">
                                            <strong>$<?php echo number_format($compra_general['total_compra'] ?? 0, 2); ?></strong>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <h4 class="card-title">Productos Incluidos en esta Compra</h4>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Código</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>P. Unitario</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($productos_de_la_compra)): ?>
                                            <?php 
                                            $total_general = 0;
                                            foreach ($productos_de_la_compra as $producto_compra): 
                                                $subtotal = $producto_compra['subtotal'] ?? ($producto_compra['cantidad'] * $producto_compra['precio_unitario']);
                                                $total_general += $subtotal;
                                            ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($producto_compra['codigo'] ?? $producto_compra['codigo_producto'] ?? 'N/A'); ?></td>
                                                    <td><?php echo htmlspecialchars($producto_compra['nombre_producto'] ?? $producto_compra['nombre'] ?? 'Producto no disponible'); ?></td>
                                                    <td class="text-center"><?php echo htmlspecialchars($producto_compra['cantidad'] ?? 0); ?></td>
                                                    <td class="text-right">$<?php echo number_format($producto_compra['precio_unitario'] ?? 0, 2); ?></td>
                                                    <td class="text-right">$<?php echo number_format($subtotal, 2); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr class="table-success">
                                                <td colspan="4" class="text-right"><strong>TOTAL GENERAL:</strong></td>
                                                <td class="text-right"><strong>$<?php echo number_format($total_general, 2); ?></strong></td>
                                            </tr>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    No hay productos registrados para esta compra.
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="<?php echo $URL; ?>/compras/index.php" class="btn btn-primary">
                                <i class="fas fa-arrow-left"></i> Volver al Listado
                            </a>
                            <?php if (!empty($compra_general['id_compra'])): ?>
                                <a href="<?php echo $URL; ?>/compras/update.php?id=<?php echo htmlspecialchars($compra_general['id_compra']); ?>" class="btn btn-info">
                                    <i class="fas fa-edit"></i> Editar Compra
                                </a>
                            <?php endif; ?>
                            <button onclick="window.print()" class="btn btn-secondary">
                                <i class="fas fa-print"></i> Imprimir
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>

<!-- Estilos adicionales -->
<style>
.form-control-plaintext {
    padding: 0.375rem 0;
    margin-bottom: 0;
    background-color: transparent;
    border: solid transparent;
    border-width: 1px 0;
}
.table th {
    background-color: #f8f9fa;
}
</style>