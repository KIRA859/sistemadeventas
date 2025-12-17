<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../../app/config.php';

$stmt = $pdo->query("
    SELECT fecha, cantidad_ventas, total_vendido
    FROM ventas_diarias
    ORDER BY fecha DESC
");

echo json_encode([
    "status" => "success",
    "data"   => $stmt->fetchAll(PDO::FETCH_ASSOC)
], JSON_UNESCAPED_UNICODE);
