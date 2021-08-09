<?php
include_once($_SERVER['DOCUMENT_ROOT']."/api/usuarios/abogado.php");
include_once($_SERVER['DOCUMENT_ROOT']."/api/usuarios/cliente.php");
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$datos = file_get_contents('php://input');
$datos2 = json_decode($datos);
$response = new stdClass();
if($datos2->tipo == 'abogado'){
$abogado = new Abogado();
$abogado->conectar();
$obAbogado = $abogado->getAbogado($datos2->correo);
    if(count($obAbogado) > 0){
        if(Cifrar::comprobarHash($datos2->contrasena,$obAbogado[0]['contrasena'])){
            if($abogado->deleteAbogado($datos2->correo)){
                $response->exito = 'OK';
            }else{
                $response->exito = 'ERR';        
            }
        }else{
            $response->exito = 'NO';
        }
    
    }else{
        $response->exito = 'FOUND';
    }
}else{
    $cliente = new Cliente();
$cliente->conectar();
$obCliente = $cliente->getCliente($datos2->correo);
    if(count($obCliente) > 0){
        if(Cifrar::comprobarHash($datos2->contrasena,$obCliente[0]['contrasena'])){
            if($cliente->deleteCliente($datos2->correo)){
                $response->exito = 'OK';
            }else{
                $response->exito = 'ERR';        
            }
        }else{
            $response->exito = 'NO';
        }
    
    }else{
        $response->exito = 'FOUND';
    }

}
echo(json_encode($response));
?>