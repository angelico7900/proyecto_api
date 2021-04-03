<?php
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/usuario.php");
//require('usuarios/cliente.php');
header('Access-Control-Allow-Origin: *');
//header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$datos = file_get_contents('php://input');
$a['edad'] = "edad";
$a['si'] = 'si';
$c = json_encode($a);
$c = json_decode($c);
var_dump($c->edad);
$datos2 = json_decode($datos);
$datos2['sirve'] = "sii";
/*$datosUser['correo'] = $datos2['correo'];
$datosUser['contrasena'] = $datos2['contrasena'];
$datosUser['usuario'] = $datos2['usuario'];
$datosUser['provincia'] = $datos2['provincia'];
$datosCliente['nombre'] = $datos2['nombre'];
$datosCliente['provincia'] = $datos2['provincia'];*/
$b = new Usuario();
$b->conectar();
$newDatos = json_encode($datos2);
    echo($datos);

//var_dump($b);
?>