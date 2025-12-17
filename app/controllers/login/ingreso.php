<?php
/*include('../../config.php'); 

$email = $_POST['email'] ?? ''; 
$password_user = $_POST['password_user'] ?? '';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$sql = "SELECT us.id_usuario, us.email, us.nombres, us.password_user, rol.id_rol, rol.rol
        FROM tb_usuarios AS us
        INNER JOIN tb_roles AS rol ON us.id_rol = rol.id_rol
        WHERE us.email = :email"; 
$query = $pdo->prepare($sql);
$query->bindParam(':email', $email, PDO::PARAM_STR);
$query->execute();
$usuario = $query->fetch(PDO::FETCH_ASSOC);

if ($usuario && password_verify($password_user, $usuario['password_user'])) {
    // Guardar en sesión (usando nombres unificados)
    $_SESSION['id_usuario'] = $usuario['id_usuario'];
    $_SESSION['nombres']    = $usuario['nombres'];
    $_SESSION['email']      = $usuario['email'];
    $_SESSION['id_rol']     = $usuario['id_rol'];
    $_SESSION['rol']        = $usuario['rol'];

    header('Location: ' . $URL . '/index.php');
    exit; 
} else {
    $_SESSION['mensaje'] = "Error: Email o contraseña incorrectos.";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/login/index.php'); 
    exit; 
}
