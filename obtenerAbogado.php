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
  $response->nombre = $obAbogado[0]['nombre'];
  $response->apellidos = $obAbogado[0]['apellidos'];
  $response->correo = $obAbogado[0]['correo'];
  $response->descripcion = $obAbogado[0]['descripcion'];
  $response->imagen = "data:image/png;base64,".base64_encode(file_get_contents($obAbogado[0]['imagen']));
  $response->descripcion = $obAbogado[0]['descripcion'];
  $response->numero = $obAbogado[0]['n_letrado'];
}else{
  $response->exito = 'ERR';
}
echo(json_encode($response));
?>