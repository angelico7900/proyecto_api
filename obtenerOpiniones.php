<?php
include("usuarios/mensajero.php");
include("usuarios/abogado.php");
include("usuarios/cliente.php");
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$datos = file_get_contents('php://input');
$datos2 = json_decode($datos);
$abogado = new Abogado();
$abogado->conectar();
$obAbogado = $abogado->getAbogado($datos2->correo);
$response = new stdClass();
if(count($obAbogado) > 0){
    $mensajero = new Mensajero();
    $mensajero->conectar();
    $opiniones = $mensajero->getOpiniones($obAbogado[0]['id']);
    $response->exito = $opiniones;
    if(count($opiniones) > 0){
        $cliente = new Cliente();
        $cliente->conectar();
        foreach($opiniones as $key => $value){
            $aux = $cliente->getClienteId($value['id_cliente']);
            $opiniones[$key]['id_cliente'] = $aux[0]['nombre']." ".$aux[0]['apellidos'];
        }
        $response->exito = 'OK';
        $response->opiniones = $opiniones;
        }else{
            $response->exito = 'ERR';
    }
}else{
    $response->exito = 'ERR';
}
echo(json_encode($response));
?>