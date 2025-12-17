<?php
header("Content-Type: application/json");
include("../../app/config.php");

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo !== "POST") {
    echo json_encode([
        "success" => false,
        "message" => "Método no permitido. Use POST."
    ]);
    exit;
}

// Recibir datos en JSON
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id_rol']) || !isset($data['rol'])) {
    echo json_encode([
        "success" => false,
        "message" => "Datos incompletos (id_rol y rol son obligatorios)"
    ]);
    exit;
}

$id_rol = intval($data['id_rol']);
$rol = trim($data['rol']);

try {
    $sql = "UPDATE tb_roles SET rol = :rol WHERE id_rol = :id_rol";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":rol", $rol, PDO::PARAM_STR);
    $stmt->bindParam(":id_rol", $id_rol, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "message" => "Rol actualizado correctamente"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Error al actualizar el rol"
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Error: " . $e->getMessage()
    ]);
}
