<?php
header("Content-Type: application/json");
require_once("../../app/config.php");

try {
    $stmt = $pdo->query("SELECT id_proveedor, nombre_proveedor, celular, telefono, empresa, email, direccion FROM tb_proveedores");
    $proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($proveedores);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error al cargar proveedores", "detalle" => $e->getMessage()]);
}
