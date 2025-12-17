<?php
// define('SERVIDOR', 'sql111.infinityfree.com');
// define('USUARIO', 'if0_40020347');
// define('PASSWORD', 'nmHWBvTbZOrnfM');
// define('BD', 'if0_40020347_sistemadeventas'); 

// $servidor = "mysql:dbname=" . BD . ";host=" . SERVIDOR;

// try {
//     $pdo = new PDO($servidor, USUARIO, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
// } catch (PDOException $e) {
//     echo "Error al conectar a la base de datos: " . $e->getMessage();
// }
// $URL = "https://sistemadeventas.infinityfree.me/"; 

// date_default_timezone_set("America/Bogota");


define('SERVIDOR', 'localhost');
define('USUARIO', 'root'); 
define('PASSWORD', '');    
define('BD', 'sistemadeventas');

//  Conexión PDO
$servidor = "mysql:dbname=" . BD . ";host=" . SERVIDOR;

try {
    $pdo = new PDO($servidor, USUARIO, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo " Error al conectar a la base de datos: " . $e->getMessage();
}


$URL = "http://localhost/sistema_de_ventas"; 

//  Zona horaria
date_default_timezone_set("America/Bogota");
?>

