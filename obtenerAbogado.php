<?php
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/abogado.php");
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$abogado = new Abogado();
$datos = file_get_contents('php://input');
$datos2 = json_decode($datos);
$abogado->conectar();
$obAbogado = $abogado->getAbogado($datos2->correo);
$response = new stdClass();
if(count($obAbogado) > 0){
  $response->exito = 'OK';
  $response->abogado = $obAbogado[0];
}else{
  $response->exito = 'ERR';
}
echo(json_encode($response));
?>