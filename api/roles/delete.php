<?php
header("Content-Type: application/json");
include('../../app/config.php');

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['id_rol'])) {
        echo json_encode(["success" => false, "message" => "ID no recibido"]);
        exit;
    }

    $id_rol = intval($data['id_rol']);

    try {
        $sql = "DELETE FROM tb_roles WHERE id_rol = :id_rol";
        $query = $pdo->prepare($sql);
        $query->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
        $query->execute();

        echo json_encode(["success" => true, "message" => "Rol eliminado correctamente"]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido"]);
}
