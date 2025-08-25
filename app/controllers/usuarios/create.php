<?php
include ('../../config.php');

// Habilitar CORS para desarrollo
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Determinar si los datos vienen como JSON o form-data
$input = file_get_contents('php://input');
if (strpos($input, '{') === 0) {
    // Es JSON
    $data = json_decode($input, true);
    $nombres = isset($data['nombres']) ? trim($data['nombres']) : '';
    $email = isset($data['email']) ? trim($data['email']) : '';
    $rol = isset($data['rol']) ? intval($data['rol']) : 0;
    $password_user = isset($data['password_user']) ? $data['password_user'] : '';
    $password_repeat = isset($data['password_repeat']) ? $data['password_repeat'] : '';
} else {
    // Es form-data tradicional
    $nombres = isset($_POST['nombres']) ? trim($_POST['nombres']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $rol = isset($_POST['rol']) ? intval($_POST['rol']) : 0;
    $password_user = isset($_POST['password_user']) ? $_POST['password_user'] : '';
    $password_repeat = isset($_POST['password_repeat']) ? $_POST['password_repeat'] : '';
}

// Validaciones básicas
$errors = [];

if (empty($nombres)) {
    $errors[] = "El nombre es obligatorio";
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "El email no es válido";
}

if (empty($password_user) || strlen($password_user) < 6) {
    $errors[] = "La contraseña debe tener al menos 6 caracteres";
}

if ($password_user !== $password_repeat) {
    $errors[] = "Las contraseñas no coinciden";
}

if ($rol < 1) {
    $errors[] = "Debe seleccionar un rol válido";
}

// Si hay errores, devolverlos
if (!empty($errors)) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
    exit;
}

try {
    // Verificar si el email ya existe
    $query_check = "SELECT id_usuario FROM tb_usuarios WHERE email = :email";
    $stmt_check = $pdo->prepare($query_check);
    $stmt_check->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt_check->execute();
    
    if ($stmt_check->rowCount() > 0) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'El email ya está registrado']);
        exit;
    }
    
    // Hash de la contraseña
    $password_hash = password_hash($password_user, PASSWORD_DEFAULT);
    
    // Insertar nuevo usuario
    $query = "INSERT INTO tb_usuarios (nombres, email, password_user, id_rol, fyh_creacion) 
              VALUES (:nombres, :email, :password_user, :id_rol, NOW())";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nombres', $nombres, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password_user', $password_hash, PDO::PARAM_STR);
    $stmt->bindParam(':id_rol', $rol, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        $response = [
            'success' => true, 
            'message' => 'Usuario registrado con éxito'
        ];
    } else {
        $response = [
            'success' => false, 
            'message' => 'Error al registrar el usuario en la base de datos'
        ];
    }
    
} catch (PDOException $e) {
    $response = [
        'success' => false, 
        'message' => 'Error de base de datos: ' . $e->getMessage()
    ];
}

// Devolver respuesta JSON
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>