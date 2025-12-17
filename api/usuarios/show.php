<?php
 //debug para mi
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . "/../../app/config.php";
require_once __DIR__ . "/../models/usuario.php"; 

try {
    $usuarioModel = new UsuarioModel($pdo);

    $usuarios = $usuarioModel->readAll();

    if ($usuarios && count($usuarios) > 0) {
        http_response_code(200); // OK
        echo json_encode($usuarios);
    } else {
        http_response_code(404); 
        echo json_encode(["message" => "No se encontraron usuarios"]);
    }

} catch (Throwable $e) {
    http_response_code(500); // Error interno
    echo json_encode([
        "message" => "Error interno en el servidor",
        "error"   => $e->getMessage(),
        "file"    => $e->getFile(),
        "line"    => $e->getLine()
    ]);
}
