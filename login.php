<?php 
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/cliente.php");
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/abogado.php");
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$datos = file_get_contents('php://input');
$usuario = json_decode($datos);
$user = [];
$pass = $usuario->contrasena;
$opcion = $usuario->tipo;
if($opcion == 'cliente'){
    $cliente = new Cliente();   
    $cliente->conectar();
    $user = $cliente->getCliente($usuario->correo);
}else if($opcion == 'abogado'){
    $abogado = new Abogado();
    $abogado->conectar();
    $user = $abogado->getAbogado($usuario->correo);
    }
$response = new stdClass();
    if(count($user) > 0){
    if(Cifrar::comprobarHash($pass,$user[0]['contrasena'])){
        $response->exito = 'OK';
        $response->tipo = $opcion;
    }else{  
        $response->exito = 'ERR';
    }
}else{
    $response->exito = 'ERR';
}
echo(json_encode($response));
?>
