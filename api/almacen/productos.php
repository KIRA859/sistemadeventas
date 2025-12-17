<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include("../../app/config.php");

$metodo = $_SERVER['REQUEST_METHOD'];

// Preflight CORS
if ($metodo == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Entrada JSON
$input = [];
if (in_array($metodo, ['POST', 'PUT', 'DELETE'])) {
    $input = json_decode(file_get_contents("php://input"), true);
}

switch ($metodo) {
    case "GET":
        try {
            $sql = "SELECT p.*, c.nombre_categoria, u.email 
                    FROM tb_almacen p 
                    LEFT JOIN tb_categorias c ON p.id_categoria = c.id_categoria f
                    LEFT JOIN tb_usuarios u ON p.id_usuario = u.id_usuario 
                    WHERE p.activo = 1
                    ORDER BY p.id_producto DESC";

            $stmt = $pdo->query($sql);
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode([
                "success" => true,
                "productos" => $productos,
                "total" => count($productos)
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Error al obtener productos: " . $e->getMessage()]);
        }
        break;

    case "POST":
        // Si la acción es desactivar
        if (isset($input['accion']) && $input['accion'] === "desactivar") {
            try {
                $sql = "UPDATE tb_almacen SET activo = 0 WHERE id_producto = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([":id" => $input['id_producto']]);

                echo json_encode([
                    "success" => true,
                    "message" => "Producto desactivado correctamente"
                ]);
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode([
                    "success" => false,
                    "message" => "Error al desactivar producto: " . $e->getMessage()
                ]);
            }
            break;
        }

        try {
            // Si viene código, lo usamos; si no, generamos uno incremental
            if (!empty($input['codigo'])) {
                $codigo = $input['codigo'];
            } else {
                $stmt = $pdo->query("SELECT COUNT(*) as total FROM tb_almacen");
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $codigo = "P-" . str_pad($row['total'] + 1, 5, "0", STR_PAD_LEFT);
            }

            // Procesar imagen si viene en base64
            $rutaImagen = null;
            if (!empty($input['imagen'])) {
                $imgData = base64_decode($input['imagen']);
                $nombreArchivo = "prod_" . time() . ".jpg";
                $rutaArchivo = __DIR__ . "/../../public/img_productos/" . $nombreArchivo;

                // Guardar la imagen comprimida al 69%
                $src = imagecreatefromstring($imgData);
                if ($src !== false) {
                    imagejpeg($src, $rutaArchivo, 69);
                    imagedestroy($src);
                    $rutaImagen = "img_productos/" . $nombreArchivo;
                }
            }

            $sql = "INSERT INTO tb_almacen 
                (codigo, nombre, descripcion, stock, stock_minimo, stock_maximo, 
                 precio_compra, precio_venta, fecha_ingreso, imagen, id_categoria, id_usuario, activo) 
                VALUES 
                (:codigo, :nombre, :descripcion, :stock, :stock_minimo, :stock_maximo, 
                 :precio_compra, :precio_venta, NOW(), :imagen, :id_categoria, :id_usuario, 1)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":codigo" => $codigo,
                ":nombre" => $input['nombre'],
                ":descripcion" => $input['descripcion'],
                ":stock" => $input['stock'],
                ":stock_minimo" => $input['stock_minimo'] ?? 0,
                ":stock_maximo" => $input['stock_maximo'] ?? 1000,
                ":precio_compra" => $input['precio_compra'],
                ":precio_venta" => $input['precio_venta'],
                ":imagen" => $rutaImagen,
                ":id_categoria" => $input['id_categoria'],
                ":id_usuario" => $input['id_usuario'] ?? 1
            ]);

            http_response_code(201);
            echo json_encode([
                "success" => true,
                "message" => "Producto creado correctamente",
                "id_producto" => $pdo->lastInsertId()
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "Error al crear producto: " . $e->getMessage()
            ]);
        }
        break;

    case "PUT":
        if (empty($input['id_producto'])) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "El campo 'id_producto' es requerido"]);
            break;
        }

        // Si la acción es "desactivar"
        if (isset($input['accion']) && $input['accion'] === "desactivar") {
            try {
                $sql = "UPDATE tb_almacen SET activo = 0 WHERE id_producto = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([":id" => $input['id_producto']]);

                echo json_encode(["success" => true, "message" => "Producto desactivado"]);
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(["success" => false, "message" => "Error al desactivar producto: " . $e->getMessage()]);
            }
            break;
        }

        // 🔹 Si no, actualizar
        try {
            $campos = [];
            $valores = [":id" => $input['id_producto']];

            if (!empty($input['nombre'])) {
                $campos[] = "nombre = :nombre";
                $valores[":nombre"] = $input['nombre'];
            }
            if (!empty($input['descripcion'])) {
                $campos[] = "descripcion = :descripcion";
                $valores[":descripcion"] = $input['descripcion'];
            }
            if (isset($input['stock'])) {
                $campos[] = "stock = :stock";
                $valores[":stock"] = $input['stock'];
            }
            if (isset($input['precio_compra'])) {
                $campos[] = "precio_compra = :precio_compra";
                $valores[":precio_compra"] = $input['precio_compra'];
            }
            if (isset($input['precio_venta'])) {
                $campos[] = "precio_venta = :precio_venta";
                $valores[":precio_venta"] = $input['precio_venta'];
            }
            if (isset($input['id_categoria'])) {
                $campos[] = "id_categoria = :id_categoria";
                $valores[":id_categoria"] = $input['id_categoria'];
            }
            if (isset($input['imagen'])) {
                $campos[] = "imagen = :imagen";
                $valores[":imagen"] = $input['imagen'];
            }

            if (empty($campos)) {
                http_response_code(400);
                echo json_encode(["success" => false, "message" => "No se enviaron campos para actualizar"]);
                break;
            }

            $sql = "UPDATE tb_almacen SET " . implode(", ", $campos) . " WHERE id_producto = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($valores);

            echo json_encode(["success" => true, "message" => "Producto actualizado correctamente"]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Error al actualizar producto: " . $e->getMessage()]);
        }
        break;

    case "DELETE":
        echo json_encode(["success" => false, "message" => "Eliminación física no permitida. Use PUT con accion=desactivar"]);
        break;

    default:
        http_response_code(405);
        echo json_encode(["success" => false, "message" => "Método no permitido"]);
        break;
}
