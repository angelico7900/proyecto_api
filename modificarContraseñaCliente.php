<?php
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/cliente.php");
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$cliente = new Cliente();
$datos = file_get_contents("php://input");
$datos2 = json_decode($datos);
$correos = array();
$correos['correoNuevo'] = $datos2->correoNuevo;
$correos['correoActual'] = $datos2->correoActual;
$cliente->conectar();
$response = new stdClass();
$clienteAux = $cliente->getCliente($correos['correoNuevo']);
if(count($clienteAux) > 0){
    $response->exito = 'EXISTS';
}else{
    if($cliente->modificarCorreo($correos)){
        $response->exito = 'OK';
    }else{
        $response->exito = 'ERR';
    }
}
echo(json_encode($response));
?>