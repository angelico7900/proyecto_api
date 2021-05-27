<?php 
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/abogado.php");
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$datos  = file_get_contents('php://input');
$datos2 = json_decode($datos);
$imagen = $datos2->archivo;
list(, $imagen) = explode(';', $imagen);
list(, $imagen) = explode(',', $imagen);
$imgDecode = base64_decode($imagen);
$imgAux = Cifrar::megaCifrar($datos2->correo);
$img = "$imgAux.png";
$ruta = "img/".$img;
file_put_contents($ruta,$imgDecode);
$response = new stdClass();
if(file_exists($ruta)){
    $abogado = new Abogado();
    $abogado->conectar();
    $abogadoAux = $abogado->getAbogado($datos2->correo);
    if(count($abogadoAux) > 0){
        if($abogado->modificarImagen($ruta,$datos2->correo)){
            $response->exito = 'OK';
        }else{
            $response->exito = 'ERR';    
        }
    }else{
        $response->exito = 'ERR';
    }
}else{
    $response->exito = 'ERR';
}
echo(json_encode($response));

?>