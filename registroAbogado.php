<?php
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/abogado.php");
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$datos = file_get_contents('php://input');
$datos2 = json_decode($datos);
$datosAbogado['correo'] = $datos2->correo;
$datosAbogado['contrasena'] = $datos2->contrasena;
$datosAbogado['provincia'] = $datos2->provincia;
$datosAbogado['nombre'] = $datos2->nombre;
$datosAbogado['apellidos'] = $datos2->apellidos;
$datosAbogado['DNI'] = $datos2->dni;
$datosAbogado['n_letrado'] = $datos2->n_letrado;
$abogado = new Abogado();
$abogado->conectar();
$response = new stdClass();
$user = $abogado->getAbogado($datosAbogado['correo']);
count($user);
if(count($user) > 0){
  $response->exito = "EXISTS";
}
else{
    if($abogado->addCliente($datosAbogado)){
        $response->exito = 'OK';
    }else{
        $response->exito = 'ERR';
    }
}
$abogado->cerrar();
echo(json_encode($response));
/*if($abogado->add($datosAbogado)){
    $abogado->addCliente($datosCliente);
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