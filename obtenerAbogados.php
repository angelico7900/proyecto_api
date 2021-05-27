<?php
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/abogado.php");
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$abogado = new Abogado();
$abogado->conectar();
$abogados = $abogado->getAbogados();
$longitud = count($abogados);
$response = new stdClass();
if($longitud > 0){
    for($i = 0; $i < $longitud; ++$i){
        unset($abogados[$i]['contrasena']);
    }
    $abogado->cerrar();
    $response->exito = 'OK';
    for($i = 0; $i < $longitud; ++$i){
        $abogados[$i]['imagen'] = "data:image/png;base64,".base64_encode(file_get_contents($abogados[$i]['imagen']));
    }
        $response->resultado = $abogados; 
    }else{
        $response->exito = 'ERR';
    }
echo(json_encode($response));
?>
