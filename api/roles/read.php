<?php
ini_set('display_errors', 0); 
ini_set('log_errors', 1);
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include ('../../app/config.php');
//STMT= declaración o sentencia
$stmt = $pdo->query("SELECT id_rol, rol FROM tb_roles");
$roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($roles);
