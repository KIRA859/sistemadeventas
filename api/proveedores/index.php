<?php
include('../../app/config.php');
header("Content-Type: application/json; charset=UTF-8");

$method = $_SERVER['REQUEST_METHOD'];

try {
    if ($method === 'GET') {
        //Listar todos o uno solo
        if (isset($_GET['id'])) {
            $stmt = $pdo->prepare("SELECT * FROM tb_proveedores WHERE id_proveedor = :id");
            $stmt->execute([":id" => $_GET['id']]);
            $proveedor = $stmt->fetch(PDO::FETCH_ASSOC);

            echo json_encode(["success" => true, "data" => $proveedor]);
        } else {
            $stmt = $pdo->query("SELECT * FROM tb_proveedores ORDER BY id_proveedor DESC");
            $proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(["success" => true, "data" => $proveedores]);
        }
        exit;
    }

    if ($method === 'POST') {
        //Crear proveedor
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data || empty($data['nombre_proveedor']) || empty($data['celular']) || empty($data['empresa']) || empty($data['direccion'])) {
            http_response_code(422);
            echo json_encode(["success" => false, "error" => "Faltan datos obligatorios"]);
            exit;
        }

        $stmt = $pdo->prepare("
            INSERT INTO tb_proveedores (nombre_proveedor, celular, telefono, empresa, email, direccion, fyh_creacion)
            VALUES (:nombre, :celular, :telefono, :empresa, :email, :direccion, NOW())
        ");
        $stmt->execute([
            ":nombre"   => $data['nombre_proveedor'],
            ":celular"  => $data['celular'],
            ":telefono" => $data['telefono'] ?? null,
            ":empresa"  => $data['empresa'],
            ":email"    => $data['email'] ?? null,
            ":direccion"=> $data['direccion']
        ]);

        echo json_encode(["success" => true, "message" => "Proveedor creado correctamente"]);
        exit;
    }

    if ($method === 'PUT') {
        //Actualizar proveedor
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data || empty($data['id_proveedor'])) {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "Falta id_proveedor"]);
            exit;
        }

        $stmt = $pdo->prepare("
            UPDATE tb_proveedores 
            SET nombre_proveedor = :nombre,
                celular = :celular,
                telefono = :telefono,
                empresa = :empresa,
                email = :email,
                direccion = :direccion,
                fyh_actualizacion = NOW()
            WHERE id_proveedor = :id
        ");
        $stmt->execute([
            ":id"       => $data['id_proveedor'],
            ":nombre"   => $data['nombre_proveedor'],
            ":celular"  => $data['celular'],
            ":telefono" => $data['telefono'] ?? null,
            ":empresa"  => $data['empresa'],
            ":email"    => $data['email'] ?? null,
            ":direccion"=> $data['direccion']
        ]);

        echo json_encode(["success" => true, "message" => "Proveedor actualizado correctamente"]);
        exit;
    }

    if ($method === 'DELETE') {
        //Eliminar proveedor
        $id = $_GET['id'] ?? null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "Falta id_proveedor"]);
            exit;
        }

        $stmt = $pdo->prepare("DELETE FROM tb_proveedores WHERE id_proveedor = :id");
        $stmt->execute([":id" => $id]);

        echo json_encode(["success" => true, "message" => "Proveedor eliminado"]);
        exit;
    }

    // Método no permitido
    http_response_code(405);
    echo json_encode(["success" => false, "error" => "Método no permitido"]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
