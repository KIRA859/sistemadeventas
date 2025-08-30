<?php
include ('../../config.php');

// Consulta para obtener roles
$sql = "SELECT * FROM tb_roles WHERE estado = '1' ";
$query = $pdo->prepare($sql);
$query->execute();
$roles = $query->fetchAll(PDO::FETCH_ASSOC);

// Devolver como JSON
header('Content-Type: application/json');
echo json_encode($roles);
?>