<?php
include('../../app/config.php');
header('Content-Type: application/json; charset=utf-8');

// Permitir CORS si lo necesitas
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Manejo de preflight OPTIONS (para peticiones desde JS)
if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
    http_response_code(200);
    exit;
}

try {
    $method = $_SERVER['REQUEST_METHOD'];
    $input = json_decode(file_get_contents("php://input"), true);

    switch ($method) {
        // === LISTAR CLIENTES ===
        case "GET":
            $sql = "SELECT 
                id_cliente,
                nit_ci_cliente AS cedula,
                nombre_cliente AS nombre,
                email_cliente AS correo,
                celular_cliente AS telefono,
                direccion,
                fyh_creacion,
                fyh_actualizacion
            FROM tb_clientes 
            ORDER BY fyh_creacion DESC";
            $query = $pdo->prepare($sql);
            $query->execute();
            $clientes = $query->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(["status" => "success", "data" => $clientes], JSON_UNESCAPED_UNICODE);
            break;
        // === CREAR CLIENTE ===
        case "POST":
            if (!$input) throw new Exception("Datos inválidos");
            $sql = "INSERT INTO tb_clientes (nombre_cliente, nit_ci_cliente, celular_cliente, email_cliente, direccion, fyh_creacion, fyh_actualizacion)
                    VALUES (:nombre, :nit, :celular, :email, :direccion, NOW(), NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":nombre" => $input['nombre_cliente'] ?? null,
                ":nit" => $input['nit_ci_cliente'] ?? null,
                ":celular" => $input['celular_cliente'] ?? null,
                ":email" => $input['email_cliente'] ?? null,
                ":direccion" => $input['direccion'] ?? null
            ]);

            echo json_encode([
                "status" => "success",
                "message" => "Cliente registrado",
                "id_cliente" => $pdo->lastInsertId()
            ]);
            break;

        // === ACTUALIZAR CLIENTE ===
        case "PUT":
            if (!$input || empty($input['id_cliente'])) throw new Exception("Cliente inválido");
            $sql = "UPDATE tb_clientes 
                    SET nombre_cliente = :nombre, nit_ci_cliente = :nit, celular_cliente = :celular,
                        email_cliente = :email, direccion = :direccion, fyh_actualizacion = NOW()
                    WHERE id_cliente = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":nombre" => $input['nombre_cliente'] ?? null,
                ":nit" => $input['nit_ci_cliente'] ?? null,
                ":celular" => $input['celular_cliente'] ?? null,
                ":email" => $input['email_cliente'] ?? null,
                ":direccion" => $input['direccion'] ?? null,
                ":id" => $input['id_cliente']
            ]);

            echo json_encode(["status" => "success", "message" => "Cliente actualizado"]);
            break;

        // === ELIMINAR CLIENTE ===
        case "DELETE":
            if (!$input || empty($input['id_cliente'])) throw new Exception("Cliente inválido");
            $sql = "DELETE FROM tb_clientes WHERE id_cliente = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([":id" => $input['id_cliente']]);

            echo json_encode(["status" => "success", "message" => "Cliente eliminado"]);
            break;

        default:
            http_response_code(405);
            echo json_encode(["status" => "error", "message" => "Método no permitido"]);
            break;
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
