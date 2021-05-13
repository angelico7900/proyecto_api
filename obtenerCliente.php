<?php
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/cliente.php");
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$cliente = new Cliente();
$datos = file_get_contents('php://input');
$datos2 = json_decode($datos);
$obCliente = $cliente->getCliente($datos2->correo);
$response = new stdClass();
if(count($obCliente) > 0){
  $response->exito = 'OK';
  $response->nombre = $obCliente[0]->nombre;
  $response->apellidos = $obCliente[0]->apellidos;
  $response->correo = $obCliente[0]->correo;
  $response->imagen = $obCliente[0]->imagen;
}else{
  $response->exito = 'ERR';
}
echo(json_encode($response));
?>
