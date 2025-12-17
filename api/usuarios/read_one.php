<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include ('../../app/config.php');

$id = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(["message" => "ID requerido"]);
    exit;
}

$stmt = $pdo->prepare("SELECT u.id_usuario, u.nombres, u.email, r.id_rol , r.rol
                       FROM tb_usuarios u 
                       INNER JOIN tb_roles r ON u.id_rol = r.id_rol
                       WHERE u.id_usuario = :id LIMIT 1");
$stmt->bindParam(":id", $id);
$stmt->execute();

if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo json_encode($row);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Usuario no encontrado"]);
}
