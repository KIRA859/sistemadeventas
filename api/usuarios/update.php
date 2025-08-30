<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include ('../../app/config.php');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id_usuario) && !empty($data->nombres) && !empty($data->email) && !empty($data->id_rol)) {
    $id_usuario = intval($data->id_usuario);
    $nombres    = $data->nombres;
    $email      = $data->email;
    $id_rol     = intval($data->id_rol);
    $password   = !empty($data->password_user) ? password_hash($data->password_user, PASSWORD_DEFAULT) : null;
    $fechaHora  = date("Y-m-d H:i:s");

    $sql = "UPDATE tb_usuarios 
            SET nombres=:nombres, email=:email, id_rol=:id_rol, fyh_actualizacion=:fyh_actualizacion";

    if ($password) {
        $sql .= ", password_user=:password_user";
    }
    $sql .= " WHERE id_usuario=:id_usuario";

    $sentencia = $pdo->prepare($sql);

    $sentencia->bindParam(':nombres', $nombres);
    $sentencia->bindParam(':email', $email);
    $sentencia->bindParam(':id_rol', $id_rol);
    $sentencia->bindParam(':fyh_actualizacion', $fechaHora);
    $sentencia->bindParam(':id_usuario', $id_usuario);

    if ($password) {
        $sentencia->bindParam(':password_user', $password);
    }

    if ($sentencia->execute()) {
        http_response_code(200);
        echo json_encode([
            "success" => true,
            "message" => "Usuario actualizado correctamente."
        ]);
    } else {
        http_response_code(503);
        echo json_encode([
            "success" => false,
            "message" => "No se pudo actualizar el usuario."
        ]);
    }
} else {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Datos incompletos para actualizar."
    ]);
}
