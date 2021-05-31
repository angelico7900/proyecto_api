<?php
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/cliente.php");
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$cliente = new Cliente();
$datos = file_get_contents("php://input");
$datos2 = json_decode($datos);
$datos3 = array();
$datos3['correo'] = $datos2->correo;
$datos3['nombre'] = $datos2->nombre;
$datos3['apellidos'] = $datos2->apellidos;
$datos3['provincia'] = $datos2->provincia;
$cliente->conectar();
$response = new stdClass();
if($cliente->updateCliente($datos3)){
    $response->exito = 'OK';
}else{

    $response->exito = 'ERR';
}
echo(json_encode($response));