<?php
include_once($_SERVER['DOCUMENT_ROOT']."/api/usuarios/abogado.php");
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$datos = file_get_contents('php://input');
$datos2 = json_decode($datos);
$datosAbogado['correo'] = $datos2->correo;
$datosAbogado['contrasena'] = $datos2->contrasena;
$datosAbogado['provincia'] = $datos2->provincia;
$datosAbogado['nombre'] = $datos2->nombre;
$datosAbogado['apellidos'] = $datos2->apellidos;
$datosAbogado['DNI'] = $datos2->dni;
$datosAbogado['n_letrado'] = $datos2->n_letrado;
$datosAbogado['descripcion'] = $datos2->descripcion;
$imagen = $datos2->imagen;
list(, $imagen) = explode(';', $imagen);
list(, $imagen) = explode(',', $imagen);
$imgDecode = base64_decode($imagen);
$abogado = new Abogado();
$abogado->conectar();
$response = new stdClass();
$user = $abogado->getAbogado($datosAbogado['correo']);
if(count($user) > 0){
  $response->exito = "EXISTS";
}
else{
    $imgDecode = base64_decode($imagen);
    $imgAux = $datos2->correo;
    $imgAux = Cifrar::megaCifrar($imgAux);
    $ruta = "img/$imgAux.png";
    file_put_contents($ruta,$imgDecode);
    if(file_exists($ruta)){
        $datosAbogado['imagen'] = $ruta;
        if($abogado->addAbogado($datosAbogado)){
            $response->exito = 'OK';
        }else{
            $response->exito = 'ERR';
        }
    }
}
$abogado->cerrar();
echo(json_encode($response));
?>
