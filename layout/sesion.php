<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['sesion_email'])){
    $email_sesion = $_SESSION['sesion_email'];
    
    $sql = "SELECT us.id_usuario, us.nombres, us.email, rol.id_rol, rol.rol
            FROM tb_usuarios as us 
            INNER JOIN tb_roles as rol ON us.id_rol = rol.id_rol 
            WHERE us.email = :email";  // 👈 el placeholder es :email
    
    $query = $pdo->prepare($sql);
    $query->execute([':email' => $email_sesion]); // 👈 corregido

    $usuario = $query->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $id_usuario_sesion = $usuario['id_usuario'];
        $nombres_sesion    = $usuario['nombres'];
        $rol_sesion        = $usuario['rol'];
        $_SESSION['sesion_rol'] = $usuario['id_rol']; 
    }
} else {
    header('Location: '.$URL.'/login');
    exit;
}