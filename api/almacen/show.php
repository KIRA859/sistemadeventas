<?php
include("../../app/config.php");

header("Content-Type: application/json; charset=UTF-8");

if (!isset($_GET['id'])) {
    echo json_encode(["success" => false, "message" => "Falta el parámetro id"]);
    exit;
}

$id = (int)$_GET['id'];

$sql = "SELECT p.*, c.nombre_categoria, u.email
        FROM tb_almacen p
        LEFT JOIN tb_categorias c ON p.id_categoria = c.id_categoria
        LEFT JOIN tb_usuarios u ON p.id_usuario = u.id_usuario
        WHERE p.id_producto = :id AND p.activo = 1";

$stmt = $pdo->prepare($sql);
$stmt->execute([":id" => $id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if ($producto) {
    echo json_encode(["success" => true, "producto" => $producto]);
} else {
    echo json_encode(["success" => false, "message" => "Producto no encontrado"]);
}
