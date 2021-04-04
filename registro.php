<?php
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/cliente.php");
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$datos = file_get_contents('php://input');
$datos2 = json_decode($datos);
$datosUser['correo'] = $datos2->correo;
$datosUser['contrasena'] = $datos2->contrasena;
$datosUser['usuario'] = $datos2->usuario;
$datosUser['provincia'] = $datos2->provincia;
$datosCliente['nombre'] = $datos2->nombre;
$datosCliente['apellidos'] = $datos2->apellidos;
$datos2->fallo = "hola";
$cliente = new Cliente();
$cliente->conectar();
//$cliente->add($datosUser);
if($cliente->addCliente($datosCliente)){
    echo($datos);
}else{
    echo(json_encode($datos2));
}
/*if($cliente->add($datosUser)){
    $cliente->addCliente($datosCliente);
}*/
/*$response = new stdClass();
if($exito){
    $response->exito = 'OK';
}else{
    $response->exito = 'error';
}
echo(json_encode($response));*/
//echo($datos);

?>