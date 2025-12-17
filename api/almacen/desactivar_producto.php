<?php
include('./app/config.php');
$id = $_GET['id'] ?? 0;
$sql = "UPDATE tb_almacen SET activo = 0 WHERE id_producto = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
header('Location: index.php?success=1');
