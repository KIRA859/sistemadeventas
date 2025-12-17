<?php


include('../../app/config.php');

$response = ["success" => false, "message" => ""];

// Recibir POST normal (InfinityFree NO soporta DELETE)
$id_usuario = isset($_POST['id_usuario']) ? intval($_POST['id_usuario']) : null;

if (!empty($id_usuario)) {

    $sentencia = $pdo->prepare("DELETE FROM tb_usuarios WHERE id_usuario=:id_usuario");
    $sentencia->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

    if ($sentencia->execute()) {
        http_response_code(200);
        echo "<script>
        alert('Usuario eliminado correctamente.');
        window.location.href='../../usuarios/index.php';
    </script>";
        exit();
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
