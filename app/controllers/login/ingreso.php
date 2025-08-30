<?php

include('../../config.php'); 
$email = $_POST['email'] ?? ''; 
$password_user = $_POST['password_user'] ?? '';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$contador = 0;
$sql = "SELECT id_usuario, email, nombres, password_user, id_rol FROM tb_usuarios WHERE email = :email"; 
$query = $pdo->prepare($sql);
$query->bindParam(':email', $email, PDO::PARAM_STR);
$query->execute();
$usuarios = $query->fetchAll(PDO::FETCH_ASSOC);

$usuario_encontrado = null;
foreach ($usuarios as $usuario_db){
    $contador++;
    $usuario_encontrado = $usuario_db;
}

if ($usuario_encontrado && password_verify($password_user, $usuario_encontrado['password_user'])) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    $_SESSION['sesion_email'] = $email;
    $_SESSION['sesion_rol'] = $usuario_encontrado['id_rol'];
    $_SESSION['id_usuario'] = $usuario_encontrado['id_usuario']; 
    $_SESSION['nombres_usuario_logueado'] = $usuario_encontrado['nombres'];

    header('Location: ' . $URL . '/index.php');
    exit; 
} else {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['mensaje'] = "Error: Email o contraseña incorrectos.";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/login'); 
    exit; 
}

?>