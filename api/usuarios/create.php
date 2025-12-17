<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

include_once("../../app/config.php"); 

$response = [
    "success" => false,
    "message" => ""
];

try {
    // Leer datos JSON
    $data = json_decode(file_get_contents("php://input"), true);
    // DEBUG: para ver qué llegó
    file_put_contents("debug.log", print_r($data, true), FILE_APPEND);

    if (!$data) {
        $response["message"] = "No se recibieron datos";
        echo json_encode($response);
        exit;
    }

    // Validar datos obligatorios
    if (
        empty($data["nombres"]) ||
        empty($data["email"]) ||
        empty($data["password_user"]) ||
        empty($data["id_rol"])
    ) {
        $response["message"] = "Datos incompletos (nombres, email, password_user, id_rol)";
        echo json_encode($response);
        exit;
    }

    $nombres = trim($data["nombres"]);
    $email = trim($data["email"]);
    $id_rol = intval($data["id_rol"]);
    $password = password_hash($data["password_user"], PASSWORD_DEFAULT);

    // Verificar si el correo ya existe
    $queryCheck = $pdo->prepare("SELECT id_usuario FROM tb_usuarios WHERE email = :email LIMIT 1");
    $queryCheck->bindParam(":email", $email);
    $queryCheck->execute();

    if ($queryCheck->rowCount() > 0) {
        $response["message"] = "El email ya está registrado.";
        echo json_encode($response);
        exit;
    }

    // Insertar nuevo usuario
    $query = $pdo->prepare("INSERT INTO tb_usuarios (nombres, email, password_user, id_rol)
                            VALUES (:nombres, :email, :password_user, :id_rol)");
    $query->bindParam(":nombres", $nombres);
    $query->bindParam(":email", $email);
    $query->bindParam(":password_user", $password);
    $query->bindParam(":id_rol", $id_rol);

    if ($query->execute()) {
        $response["success"] = true;
        $response["message"] = "Usuario creado correctamente.";
    } else {
        $response["message"] = "Error al crear el usuario.";
    }

} catch (Exception $e) {
    $response["message"] = "Error: " . $e->getMessage();
}

echo json_encode($response);
