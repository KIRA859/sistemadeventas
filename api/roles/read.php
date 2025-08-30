<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include ('../../app/config.php');

$stmt = $pdo->query("SELECT id_rol, rol FROM tb_roles");
$roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($roles);
