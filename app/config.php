<?php

define('SERVIDOR','localhost');
define('USUARIO','root');
define('PASSWORD','');
define('BD','sitemadeventas');

$servidor = "mysql:dbname=".BD.";host=".SERVIDOR;

try{
    $pdo = new PDO($servidor,USUARIO,PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
    //echo "La conexión a la base de datos fue con exito";
} catch (PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}


$URL = "http://localhost/sistema_de_ventas";

date_default_timezone_set("America/Caracas");
$fechaHora = date('Y-m-d H:i:s');


