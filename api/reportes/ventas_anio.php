<?php
include('../../app/config.php');

$sql = "
SELECT 
    YEAR(fyh_creacion) AS anio,
    COUNT(*) AS total_ventas,
    SUM(total_pagado) AS total_vendido
FROM tb_ventas
WHERE id_estado = 2
GROUP BY YEAR(fyh_creacion)
ORDER BY anio DESC
";

$stmt = $pdo->query($sql);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
