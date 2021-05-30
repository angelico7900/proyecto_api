<?php 
include_once($_SERVER["DOCUMENT_ROOT"]."/api"."/usuarios"."/abogado.php");
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$datos = file_get_contents("php://input");
$datos2 = json_decode($datos);
$abogado = new Abogado();
$abogado->conectar();
$obAbogado = $abogado->getAbogado($datos2->correo);
$response = new stdClass();
if(count($obAbogado) > 0){
    $parametros['id_abogado'] = $obAbogado[0]['id'];
    $parametros['pagado'] = $fechaVencimiento = strval(date("Y-m-d",strtotime(date("Y-m-d")."+ 1 month")));
    if($abogado->addPago($parametros)){
        $response->exito = 'OK';
    }
}else{
    $response->exito = 'ERR';
    
}
echo(json_encode($response));
?>