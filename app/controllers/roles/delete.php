<?php
include('../../config.php');

$id_rol = $_GET['id'];

// Verificar si hay usuarios con ese rol
$sql_verificar = "SELECT COUNT(*) FROM tb_usuarios WHERE id_rol = :id_rol";
$query_verificar = $pdo->prepare($sql_verificar);
$query_verificar->bindParam(':id_rol', $id_rol);
$query_verificar->execute();
$total_usuarios = $query_verificar->fetchColumn();

if ($total_usuarios > 0) {
    // Hay usuarios usando el rol, no podemos borrar
    session_start();
    $_SESSION['mensaje'] = "No se puede eliminar: hay $total_usuarios usuarios usando este rol";
    $_SESSION['icono'] = "error";
    header('Location: '.$URL.'/roles/');
    exit;
}

// Si no hay usuarios con ese rol, podemos eliminar
$sql = "DELETE FROM tb_roles WHERE id_rol = :id_rol";
$query = $pdo->prepare($sql);
$query->bindParam(':id_rol', $id_rol);

if ($query->execute()) {
    session_start();
    $_SESSION['mensaje'] = "Rol eliminado correctamente";
    $_SESSION['icono'] = "success";
} else {
    session_start();
    $_SESSION['mensaje'] = "Error: no se pudo eliminar el rol";
    $_SESSION['icono'] = "error";
}

header('Location: '.$URL.'/roles/');
exit;
?>