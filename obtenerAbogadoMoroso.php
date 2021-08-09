<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/api"."/usuarios"."/abogado.php");
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$datos = file_get_contents("php://input");
$datos2 = json_decode($datos);
$abogado = new Abogado();
$abogado->conectar();
    $pago = $abogado->obtenerAbogadoMoroso($datos2->correo);
$response = new stdClass();
$response->exito = 'OK';
if(count($pago) == 0){
    $response->pagado = 'ERR';
}else{
    $fechaActual = strval(date("Y-m-d"));
    if($fechaActual > $pago[count($pago) - 1]['pagado']){
        $response->pagado = 'ERR';
    }else{
        $response->pagado = 'OK';
    }
}
echo(json_encode($response));
?>