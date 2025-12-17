<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '../../app/config.php';

if (!isset($_SESSION['sesion_email'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Acceso no autorizado. Debes iniciar sesión."
    ]);
    exit;
}

try {
    // 1. Usuarios
    $sqlUsuarios = "SELECT COUNT(*) as total FROM tb_usuarios";
    $usuarios = $pdo->query($sqlUsuarios)->fetch(PDO::FETCH_ASSOC)['total'];

    // 2. Roles
    $sqlRoles = "SELECT COUNT(*) as total FROM tb_roles";
    $roles = $pdo->query($sqlRoles)->fetch(PDO::FETCH_ASSOC)['total'];

    // 3. Categorías
    $sqlCategorias = "SELECT COUNT(*) as total FROM tb_categorias";
    $categorias = $pdo->query($sqlCategorias)->fetch(PDO::FETCH_ASSOC)['total'];

    // 4. Productos
    $sqlProductos = "SELECT COUNT(*) as total FROM tb_almacen";
    $productos = $pdo->query($sqlProductos)->fetch(PDO::FETCH_ASSOC)['total'];

    // 5. Proveedores
    $sqlProveedores = "SELECT COUNT(*) as total FROM tb_proveedores";
    $proveedores = $pdo->query($sqlProveedores)->fetch(PDO::FETCH_ASSOC)['total'];

    // 6. Compras
    $sqlCompras = "SELECT COUNT(*) as total FROM tb_compras";
    $compras = $pdo->query($sqlCompras)->fetch(PDO::FETCH_ASSOC)['total'];

    // 7. Ventas
    $sqlVentas = "SELECT COUNT(*) as total FROM tb_ventas";
    $ventas = $pdo->query($sqlVentas)->fetch(PDO::FETCH_ASSOC)['total'];

    // Respuesta JSON
    echo json_encode([
        "status" => "success",
        "data" => [
            "usuarios" => $usuarios,
            "roles" => $roles,
            "categorias" => $categorias,
            "productos" => $productos,
            "proveedores" => $proveedores,
            "compras" => $compras,
            "ventas" => $ventas
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Error interno: " . $e->getMessage()
    ]);
}