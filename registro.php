<?php
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/cliente.php");
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$datos = file_get_contents('php://input');
$datos2 = json_decode($datos);
$datosUser['correo'] = $datos2->correo;
$datosUser['contrasena'] = $datos2->contrasena;
$datosUser['provincia'] = $datos2->provincia;
$datosUser['nombre'] = $datos2->nombre;
$datosUser['apellidos'] = $datos2->apellidos;
$cliente = new Cliente();
$cliente->conectar();
$response = new stdClass();
$user = $cliente->getCliente($datosUser['correo']);
count($user);
if(count($user) > 0){
  $response->exito = "EXISTS";
}
else{
    if($cliente->addCliente($datosUser)){
        $response->exito = 'OK';
    }else{
        $response->exito = 'ERR';
    }
}
$cliente->cerrar();
echo(json_encode($response));
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