<?php
include("usuarios/mensajero.php");
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$datos = file_get_contents('php://input');
$datos2 = json_decode($datos);
$parametros['emisor'] = $datos2->emisor;
$parametros['receptor'] = $datos2->receptor;
$parametros['caso'] = $datos2->caso;
$mensajero = new Mensajero();
$mensajero->conectar();
$response = new stdClass();
//echo(json_encode($mensajero->addMensaje($parametros)));
if($mensajero->addMensaje($parametros)){
    $response->exito = 'OK';
}else{
    $response->exito = 'ERR';
}
echo(json_encode($response));
?>