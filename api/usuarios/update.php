<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include ('../../app/config.php');

$id_usuario = $_POST['id_usuario'] ?? null;
$nombres    = $_POST['nombres'] ?? null;
$email      = $_POST['email'] ?? null;
$id_rol     = $_POST['id_rol'] ?? null;
$password   = $_POST['password_user'] ?? null;

if (!empty($id_usuario) && !empty($nombres) && !empty($email) && !empty($id_rol)) {

    $fechaHora = date("Y-m-d H:i:s");

    $sql = "UPDATE tb_usuarios
            SET nombres=:nombres, email=:email, id_rol=:id_rol, fyh_actualizacion=:fyh";

    if (!empty($password)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql .= ", password_user=:password_user";
    }

    $sql .= " WHERE id_usuario=:id_usuario";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nombres', $nombres);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id_rol', $id_rol);
    $stmt->bindParam(':fyh', $fechaHora);
    $stmt->bindParam(':id_usuario', $id_usuario);

    if (!empty($password)) {
        $stmt->bindParam(':password_user', $passwordHash);
    }

    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "message" => "Usuario actualizado correctamente."
        ]);
        exit;
    }

    echo json_encode([
        "success" => false,
        "message" => "No se pudo actualizar el usuario."
    ]);
    exit;
}

echo json_encode([
    "success" => false,
    "message" => "Datos incompletos."
]);
exit;
