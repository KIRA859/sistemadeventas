<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include('../../app/config.php');

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['rol'])) {
    $rol = $data['rol'];

    $sql = "INSERT INTO tb_roles (rol, fyh_creacion) VALUES (:rol, :fyh_creacion)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':rol', $rol);
    $stmt->bindParam(':fyh_creacion', $fechaHora);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Rol creado correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al guardar"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
}
