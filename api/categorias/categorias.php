<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . "/../../app/config.php"; 

$metodo = $_SERVER['REQUEST_METHOD'];

// Preflight
if ($metodo === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Leer JSON si aplica
$input = [];
if (in_array($metodo, ['POST', 'PUT', 'DELETE'])) {
    $raw = file_get_contents("php://input");
    $input = json_decode($raw, true);
    if ($raw && json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "JSON inválido"]);
        exit();
    }
}

try {
    switch ($metodo) {

        case "GET":
            $stmt = $pdo->query("SELECT id_categoria, nombre_categoria FROM tb_categorias ORDER BY nombre_categoria");
            $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(["success" => true, "categorias" => $categorias]);
            break;

        case "POST":
            if (empty($input['nombre_categoria'])) {
                http_response_code(400);
                echo json_encode(["success" => false, "message" => "El campo 'nombre_categoria' es requerido"]);
                break;
            }

            $sql = "INSERT INTO tb_categorias(nombre_categoria, fyh_creacion, fyh_actualizacion) 
            VALUES(:nombre, NOW(), NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([":nombre" => trim($input['nombre_categoria'])]);

            $id = $pdo->lastInsertId();
            $stmt = $pdo->prepare("SELECT id_categoria, nombre_categoria, fyh_creacion, fyh_actualizacion 
                           FROM tb_categorias WHERE id_categoria = :id");
            $stmt->execute([":id" => $id]);
            $nueva = $stmt->fetch(PDO::FETCH_ASSOC);

            http_response_code(201);
            echo json_encode([
                "success" => true,
                "message" => "Categoría creada correctamente",
                "categoria" => $nueva
            ]);
            break;

        case "PUT":
            if (empty($input['id_categoria']) || empty($input['nombre_categoria'])) {
                http_response_code(400);
                echo json_encode(["success" => false, "message" => "Los campos 'id_categoria' y 'nombre_categoria' son requeridos"]);
                break;
            }

            $stmtCheck = $pdo->prepare("SELECT 1 FROM tb_categorias WHERE id_categoria = :id");
            $stmtCheck->execute([":id" => $input['id_categoria']]);
            if ($stmtCheck->rowCount() === 0) {
                http_response_code(404);
                echo json_encode(["success" => false, "message" => "Categoría no encontrada"]);
                break;
            }

            $sql = "UPDATE tb_categorias 
            SET nombre_categoria = :nombre, fyh_actualizacion = NOW() 
            WHERE id_categoria = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":nombre" => trim($input['nombre_categoria']),
                ":id"     => $input['id_categoria']
            ]);

            echo json_encode([
                "success" => true,
                "message" => "Categoría actualizada correctamente"
            ]);
            break;

        case "DELETE":
            if (empty($input['id_categoria'])) {
                http_response_code(400);
                echo json_encode(["success" => false, "message" => "El campo 'id_categoria' es requerido"]);
                break;
            }

            // Verificar existencia
            $stmtCheck = $pdo->prepare("SELECT 1 FROM tb_categorias WHERE id_categoria = :id");
            $stmtCheck->execute([":id" => $input['id_categoria']]);
            if ($stmtCheck->rowCount() === 0) {
                http_response_code(404);
                echo json_encode(["success" => false, "message" => "Categoría no encontrada"]);
                break;
            }

            $sql = "DELETE FROM tb_categorias WHERE id_categoria = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([":id" => $input['id_categoria']]);

            echo json_encode(["success" => true, "message" => "Categoría eliminada correctamente"]);
            break;

        default:
            http_response_code(405);
            echo json_encode(["success" => false, "message" => "Método no permitido"]);
            break;
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Error en BD: " . $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
