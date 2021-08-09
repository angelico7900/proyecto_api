<?php
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/abogado.php");
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$abogado = new Abogado();
$datos = file_get_contents("php://input");
$datos2 = json_decode($datos);
$datos3 = array();
$datos3['correo'] = $datos2->correo;
$datos3['nombre'] = $datos2->nombre;
$datos3['apellidos'] = $datos2->apellidos;
$datos3['provincia'] = $datos2->provincia;
$datos3['dni'] = $datos2->dni;
$datos3['n_letrado'] = $datos2->n_letrado;
$abogado->conectar();
$response = new stdClass();
if($abogado->updateAbogado($datos3)){
    $response->exito = 'OK';
}else{

    $response->exito = 'ERR';
}
echo(json_encode($response));