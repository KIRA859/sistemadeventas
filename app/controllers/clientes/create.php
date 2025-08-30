<?php

include('../../config.php');

//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$nombres = $_POST['nombres'];
$cedula = $_POST['cedula'];
$email = $_POST['email'];
$password_user = $_POST['telefono'];
$password_repeat = $_POST['direccion'];


    /*$sentencia = $pdo->prepare("INSERT INTO tb_usuarios 
            (nombres, email, password_user, fyh_creacion) 
    VALUES (:nombres, :email, :password_user, :fyh_creacion)");*/


$sentencia = $pdo->prepare("INSERT INTO tb_clientes
        (nombres, cedula, email, telefono, direccion, fyh_creacion) 
VALUES  (:nombres,:cedula, :email, :telefono, :direccion,:fyh_creacion)");
    //$password_hash = password_hash($password_user, PASSWORD_BCRYPT); // método de encriptación
    $sentencia->bindParam('nombres', $nombres);
    $sentencia->bindParam('cedula', $cedula);
    $sentencia->bindParam('email', $email);
    $sentencia->bindParam('telefono', $telefono);
    $sentencia->bindParam('direccion', $direccion);
    $sentencia->bindParam('fyh_creacion', $fechaHora);
    $sentencia->execute();
    session_start();
    $_SESSION['mensaje'] = "Se registro al cliente de la manera correcta";
    header( 'Location: '.
    $URL.'/usuarios/');

/*else {
    session_start();
    $_SESSION['mensaje'] = "Error, las contraseñas no son iguales";
    header('Location: '.$URL. '/usuarios/create.php');
}




