<?php
include('../../app/config.php');

$anio = $_GET['anio'] ?? date('Y');

$sql = "
SELECT 
    MONTH(fyh_creacion) AS mes,
    COUNT(*) AS total_ventas,
    SUM(total_pagado) AS total_vendido
FROM tb_ventas
WHERE id_estado = 2
  AND YEAR(fyh_creacion) = :anio
GROUP BY MONTH(fyh_creacion)
ORDER BY mes
";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':anio', $anio);
$stmt->execute();

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
