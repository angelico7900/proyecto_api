<?php 
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/abogado.php");
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$datos  = file_get_contents('php://input');
$datos2 = json_decode($datos);
$imagen = $datos2->archivo;
list(, $imagen) = explode(';', $imagen);
list(, $imagen) = explode(',', $imagen);
//Decodificamos $Base64Img codificada en base64.
$imgDecode = base64_decode($imagen);
$img = "$datos2->correo.png";
file_put_contents("img/".$img,$imgDecode);
$abogado = new Abogado();
$abogado->conectar();
$abogadoAux = $abogado->getAbogado($datos2->correo);
$response = new stdClass();
if(count($abogadoAux) > 0){
    // if($abogado->modificarImagen($datos2))
}else{
    $response->exito = 'ERR';
}
// $abogado->modificarImagen($datos2->);
echo(json_encode($datos2));

?>