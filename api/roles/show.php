<?php
ini_set('display_errors', 0); 
ini_set('log_errors', 1);
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include ('../../app/config.php');

if (!isset($_GET['id'])) {
    echo json_encode([
        "success" => false,
        "message" => "Falta el parámetro id"
    ]);
    exit;
}

$id = intval($_GET['id']);

try {
    $stmt = $pdo->prepare("SELECT id_rol, rol FROM tb_roles WHERE id_rol = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    $rol = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($rol) {
        echo json_encode([
            "success" => true,
            "rol" => $rol
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Rol no encontrado"
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Error en la consulta: " . $e->getMessage()
    ]);
}
