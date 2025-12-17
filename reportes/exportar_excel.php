<?php
include('../app/config.php');

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reportes.xls");

$stmt = $pdo->query("
SELECT fecha_venta, total_pagado
FROM ventas
ORDER BY fecha_venta
");

echo "Fecha\tTotal\n";
while ($row = $stmt->fetch()) {
    echo "{$row['fecha_venta']}\t{$row['total_pagado']}\n";
}
