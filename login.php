<?php 
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/cliente.php");
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$datos = file_get_contents('php://input');
$usuario = json_decode($datos);
$cliente = new Cliente();
$pass = $usuario->contrasena;
$cliente->conectar();
$user = $cliente->getCliente($usuario->correo);
$response = new stdClass();
$usuario = new stdClass();
if(count($user) > 0){
    if(strcmp($user[0]['contrasena'],$pass) == 0){
        $response->exito = 'OK';
    }else{
        $response->exito = 'ERR';
    }
}else{
    $response->exito = 'ERR';
}
echo(json_encode($response));
/*$result = $cliente->comprobarPass($user['usuario'],$pass);
$response = new stdClass();
if($result){
    $response->exito = 'OK';
    echo(json_encode($response));
}else{
    $response->exito = 'ERR';
    echo(json_encode($response));
}*/
?>