<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/api"."/usuarios"."/abogado.php");
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$datos = file_get_contents("php://input");
$datos2 = json_decode($datos);
$abogado = new Abogado();
$abogado->conectar();
$response = new stdClass();
$abogadosMorosos = $abogado->obtenerAbogadosMorosos();
$abogado->cerrar();
if($abogadosMorosos === false){
    $response->exito = 'ERR';
}else{
    $response->exito = 'OK';
    $response->abogados = $abogadosMorosos;
}
echo(json_encode($response));
?>