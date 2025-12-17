<?php
header("Content-Type: application/json");
include('../../app/config.php');

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo !== 'POST') {
    echo json_encode(["success" => false, "message" => "Método no permitido"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$accion = $data['accion'] ?? '';

/* ============================================================
    1. LISTAR CATEGORÍAS
============================================================ */
if ($accion === "listar") {

    try {
        $sql = "SELECT * FROM tb_categorias ORDER BY id_categoria DESC";
        $query = $pdo->query($sql);
        $categorias = $query->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "success" => true,
            "categorias" => $categorias
        ]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }

    exit;
}


if ($accion === "crear") {

    if (!isset($data['nombre_categoria']) || empty($data['nombre_categoria'])) {
        echo json_encode(["success" => false, "message" => "El campo 'nombre_categoria' es obligatorio"]);
        exit;
    }

    $nombre = $data['nombre_categoria'];

    try {
        $sql = "INSERT INTO tb_categorias (nombre_categoria) VALUES (:nombre)";
        $query = $pdo->prepare($sql);
        $query->bindParam(':nombre', $nombre);
        $query->execute();

        echo json_encode(["success" => true, "message" => "Categoría creada"]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }

    exit;
}


if ($accion === "editar") {

    if (!isset($data['id_categoria'])) {
        echo json_encode(["success" => false, "message" => "ID obligatorio"]);
        exit;
    }

    if (!isset($data['nombre_categoria']) || empty($data['nombre_categoria'])) {
        echo json_encode(["success" => false, "message" => "El nombre es obligatorio"]);
        exit;
    }

    $id = $data['id_categoria'];
    $nombre = $data['nombre_categoria'];

    try {
        $sql = "UPDATE tb_categorias SET nombre_categoria = :nombre WHERE id_categoria = :id";
        $query = $pdo->prepare($sql);
        $query->bindParam(':nombre', $nombre);
        $query->bindParam(':id', $id);
        $query->execute();

        echo json_encode(["success" => true, "message" => "Categoría actualizada"]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }

    exit;
}


if ($accion === "eliminar") {

    if (!isset($data['id_categoria'])) {
        echo json_encode(["success" => false, "message" => "ID obligatorio"]);
        exit;
    }

    $id = intval($data['id_categoria']);

    try {
        $sql = "DELETE FROM tb_categorias WHERE id_categoria = :id";
        $query = $pdo->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();

        echo json_encode(["success" => true, "message" => "Categoría eliminada"]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }

    exit;
}


echo json_encode(["success" => false, "message" => "Acción no válida"]);
