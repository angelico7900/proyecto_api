<?php 
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/cliente.php");
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$datos = file_get_contents('php://input');
$usuario = json_decode($datos);
$user = array();
$pass = $usuario->contrasena;
if($usuario->opcion == 'cliente'){
    $cliente = new Cliente();   
    $cliente->conectar();
    $user = $cliente->getCliente($usuario->correo);
}else if($usuario->opcion == 'abogado'){
    $abogado = new Abogado();
    $abogado->conectar();
    $user = $cliente->getAbogado($usuario->correo);
}else if($usuario->opcion == 'despacho'){
    $despacho = new Despacho();
    $despacho->conectar();
    $user = $despacho->getDespacho($usuario->correo);
}
$response = new stdClass();
if(count($user) > 0){
    if(strcmp($user[0]['contrasena'],$pass) == 0){
        $response->exito = 'OK';
        $response->tipo = $usuario->opcion;
    }else{
        $response->exito = 'ERR';
    }
}else{
    $response->exito = 'ERR';
}
echo(json_encode($response));
?>
