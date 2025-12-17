<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include('../../app/config.php');

// Evitar errores fatales que rompan el JSON
ini_set('display_errors', 0);
error_reporting(E_ALL);

$data = json_decode(file_get_contents("php://input"), true);

// Validación
if (!isset($data['rol']) || trim($data['rol']) === "") {
    echo json_encode([
        "success" => false,
        "message" => "Datos incompletos"
    ]);
    exit;
}

$rol = trim($data['rol']);
$fechaHora = date('Y-m-d H:i:s');  

try {
    $sql = "INSERT INTO tb_roles (rol, fyh_creacion) VALUES (:rol, :fyh_creacion)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':rol', $rol);
    $stmt->bindParam(':fyh_creacion', $fechaHora);

    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "message" => "Rol creado correctamente"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Error al guardar el rol."
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Error SQL: " . $e->getMessage()
    ]);
}