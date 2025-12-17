<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Conexión y variables globales
require_once __DIR__ . "/../app/config.php";

// Validar sesión
if (!isset($_SESSION['sesion_email'])) {
    header("Location: $URL/login/index.php");
    exit;
}

$email_sesion = $_SESSION['sesion_email'];

$sql = "SELECT us.id_usuario, us.nombres, us.email, rol.id_rol, rol.rol
        FROM tb_usuarios AS us
        INNER JOIN tb_roles AS rol ON us.id_rol = rol.id_rol
        WHERE us.email = :email
        LIMIT 1";

$query = $pdo->prepare($sql);
$query->execute([':email' => $email_sesion]);

$usuario = $query->fetch(PDO::FETCH_ASSOC);

if ($usuario) {
    // Variables disponibles en index.php
    $id_usuario_sesion  = $usuario['id_usuario'];
    $nombres_sesion     = $usuario['nombres'];
    $rol_sesion         = $usuario['rol'];

    // Guardamos rol en sesión
    $_SESSION['sesion_rol'] = $usuario['id_rol'];
} else {
    // Si no encuentra usuario, cerrar sesión y mandar a login
    session_unset();
    session_destroy();
    header("Location: $URL/login/index.php");
    exit;
}
