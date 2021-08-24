<?php
include_once("usuarios/mensajero.php");
include_once("usuarios/cliente.php");
include_once("usuarios/abogado.php");
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$datos = file_get_contents('php://input');
$datos2 = json_decode($datos);
$parametros['opinion'] = $datos2->opinion;
$cliente = new Cliente();
$abogado = new Abogado();
$mensajero = new Mensajero();
$cliente->conectar();
$mensajero->conectar();
$abogado->conectar();
$obCliente = $cliente->getCliente($datos2->correoCliente);
$obAbogado = $abogado->getAbogado($datos2->correoAbogado);
$response = new stdClass();
if((count($obCliente) > 0) &&  (count($obAbogado) > 0)){
    $parametros['id_cliente'] = $obCliente[0]['id'];
    $parametros['id_abogado'] = $obAbogado[0]['id'];
    if($mensajero->addOpinion($parametros)){
        $response->exito = 'OK';
    }else{
        $response->exito = 'NO';
    }
}else{
    $response->exito = 'ERR';
}
echo(json_encode($response));
?>