<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include ('../../app/config.php');

$data = json_decode(file_get_contents("php://input"));

$response = ["success" => false, "message" => ""];

if (!empty($data->id_usuario)) {
    $id_usuario = intval($data->id_usuario);

    $sentencia = $pdo->prepare("DELETE FROM tb_usuarios WHERE id_usuario=:id_usuario");
    $sentencia->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

    if ($sentencia->execute()) {
        http_response_code(200);
        echo json_encode([
            "success" => true,
            "message" => "Usuario eliminado correctamente.",
            "redirect" => true,
            "redirect_url" => "../../usuarios/index.php"
        ]);
    } else {
        http_response_code(503);
        echo json_encode([
            "success" => false,
            "message" => "No se pudo eliminar el usuario."
        ]);
    }
} else {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "ID de usuario no proporcionado."
    ]);
}
