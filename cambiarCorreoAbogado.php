<?php
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/abogado.php");
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$abogado = new Abogado();
$datos = file_get_contents("php://input");
$datos2 = json_decode($datos);
$correos = [];
$correos[] = $datos2->correoNuevo;
$correos[] = $datos2->correoActual;
$abogado->conectar();
$response = new stdClass();
if($abogado->modificarCorreo($correos)){
    $response->exito = 'OK';
}else{
    $response->exito = 'ERR';
}
echo(json_encode($response));
?>
