<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/api"."/usuarios"."/abogado.php");
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$datos = file_get_contents("php://input");
$datos2 = json_decode($datos);
$abogado = new Abogado();
$abogado->conectar();
$parametros['ciudad'] = $datos2->ciudad;
$abogados = $abogado->obtenerAbogadosWhere($parametros);
$response = new stdClass();
$longitud = count($abogados);
if($longitud == 0){
  $response->exito = 'NO';
}else{
  $response->exito = 'OK';
  for($i = 0; $i < $longitud; ++$i){
    $abogados[$i]['imagen'] = "data:image/png;base64,".base64_encode(file_get_contents($abogados[$i]['imagen']));
}
}
$response->abogados = $abogados;
echo(json_encode($response));
