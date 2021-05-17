<?php
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/abogado.php");
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$abogado = new Abogado();
$abogado->conectar();
$abogados = $abogado->getAbogados();
$longitud = count($abogados);
for($i = 0; $i < $longitud; ++$i){
  unset($abogados[$i]['contrasena']);
}
$abogado->cerrar();
$response = new stdClass();
if($abogados == null){
$response->exito = 'ERR';
}else{
$response->exito = 'OK';
$response->resultado = $abogados; 
}
echo(json_encode($response));
?>
