<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '../../../app/config.php';

// Iniciar sesión (antes de setear $_SESSION)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Método no permitido. Solo se acepta POST."]);
    exit;
}

$email = trim($_POST['email'] ?? '');
$password_user = $_POST['password_user'] ?? '';

// Validar campos
if (empty($email) || empty($password_user)) {
    echo json_encode(["status" => "error", "message" => "Los campos de correo electrónico y contraseña son obligatorios."]);
    exit;
}

try {
    $sql = "SELECT id_usuario, email, password_user, id_rol
            FROM tb_usuarios
            WHERE email = :email
            LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($password_user, $usuario['password_user'])) {
        // Guardar todas las variantes de sesión útiles (compatibilidad con sesion.php)
        $_SESSION['id_usuario']    = $usuario['id_usuario'];
        $_SESSION['email']         = $usuario['email'];
        $_SESSION['id_rol']        = $usuario['id_rol'];

        // Nombres que usa tu sesion.php e index.php
        $_SESSION['sesion_email']  = $usuario['email'];
        $_SESSION['sesion_rol']    = $usuario['id_rol'];
        $_SESSION['sesion_id']     = $usuario['id_usuario'];

        echo json_encode([
            "status" => "success",
            "message" => "Autenticación exitosa.",
            "redirect_url" => isset($URL) ? $URL . "/index.php" : "/index.php"
        ]);
        exit;
    } else {
        echo json_encode(["status" => "error", "message" => "Correo electrónico o contraseña incorrectos."]);
        exit;
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    exit;
}
?>
