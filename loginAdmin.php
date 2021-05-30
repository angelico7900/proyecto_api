<?php
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/administrador.php");
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$datos = file_get_contents('php://input');
$datos2 = json_decode($datos);
$admin = new Administrador();
$admin->conectar();
$obAdmin = $admin->getAdmin($datos2->nombre);
$response = new stdClass();
if(count($obAdmin) > 0){
    if(Cifrar::comprobarHash($datos2->contrasena,$obAdmin[0]['contrasena'])){
        $response->exito = 'OK';
    }else{
        $response->exito = 'ERR';
    }
}else{
    $response->exito = 'ERR';
}
echo(json_encode($response));
?>