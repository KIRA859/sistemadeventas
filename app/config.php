<?php

define('SERVIDOR', 'localhost');
define('USUARIO', 'root');
define('PASSWORD', '');
define('BD', 'sistemadeventas');

$servidor = "mysql:dbname=" . BD . ";host=" . SERVIDOR;

try {
    $pdo = new PDO($servidor, USUARIO, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    //echo "La conexión a la base de datos fue con exito";
} catch (PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}
/*header("Content-Type: application/json");
$metodo = $_SERVER['REQUEST_METHOD']; //ecibimos el metodo
$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';

$buscarid =  explode('/', $path);

$id = ($path !== '/') ? end($buscarid) : null;

switch ($metodo) {
    //Consulta SELECT usuarios
    case 'GET':
        consulta($pdo, $id);
        break;
    //INSERT
    case 'POST':
        insertar($pdo);
        break;
    //UPDATE    
    case 'PUT':
        actualizar($pdo, $id);

        break;
    //UPDATE    
    case 'DELETE':
        borrar($pdo, $id);
        break;
    default:
        echo "Metodo no permitido";
}

function consulta($conexion, $id)
{
    $sql = ($id===null) ? "SELECT * FROM tb_usuarios":"SELECT * FROM  tb_usuarios WHERE id_usuario=$id" ;
    $resultado = $conexion->query($sql);

    if ($resultado) {
        $datos = array();
        while ($fila = $resultado->fetchALL(PDO::FETCH_ASSOC)) {
            $datos[] = $fila;
        }
        echo json_encode($datos);
    }
}

function insertar($conexion)
{
    //recibir los datos en formato JSON 
    $dato = json_decode(file_get_contents('php://input'), true);
    //Se toma el campo nombres
    $nombre = $dato['nombres'];
    $id_rol = $dato['id_rol'];

    print_r($nombre);
    print_r($id_rol);


    //Consulta simple
    $sql = "INSERT INTO tb_usuarios(nombres, id_rol) VALUES ('$nombre', '$id_rol')";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        $dato['id'] = $conexion->lastInsertId();
        echo json_encode($dato);
    } else {
        echo json_encode(array('error' => 'Error al crear usuario'));
    }
}
function borrar($conexion, $id_usuario)
{
    echo "El id a borrar es: ", $id_usuario;

    //Consulta simple
    $sql = "DELETE FROM tb_usuarios where id_usuario = $id_usuario";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        echo json_encode(array('mensaje' => 'Usuario borrado'));
    } else {
        echo json_encode(array('error' => 'Error al borrar usuario'));
    }
}

function actualizar($conexion, $id){
     //recibir los datos en formato JSON 
    $dato = json_decode(file_get_contents('php://input'), true);

    $nombre = $dato['nombres'];

    echo "El id a editar es: ".$id." con el dato ". $nombre;

    //Consulta simple
    $sql = "UPDATE tb_usuarios SET nombres = '$nombre' WHERE id_usuario = $id";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        echo json_encode(array('mensaje' => 'Usuario actualizado'));
    } else {
        echo json_encode(array('error' => 'Error al actualizar el usuario'));
    }


}*/

$URL = "http://localhost/sistema_de_ventas";

date_default_timezone_set("America/Bogota");
$fechaHora = date('Y-m-d H:i:s');
