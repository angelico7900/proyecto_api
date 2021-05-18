<?php
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/mensajero.php");
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$datos = file_get_contents("php://input");
$datos2 = json_decode($datos);
$mensajero = new Mensajero();
$mensajero->conectar();
$mensajes = $mensajero->obtenerMensajes($datos2->correo);
$response = new stdClass();
if($mensajes === false){
    $response->exito = 'ERR';
}else{
    $response->exito = 'OK';
    $response->mensajes = $mensajes;
}
echo(json_encode($response));
?>