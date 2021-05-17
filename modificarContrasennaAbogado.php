<?php
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/abogado.php");
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$abogado = new Abogado();
$datos = file_get_contents("php://input");
$datos2 = json_decode($datos);
$datos3 = array();
$datos3['correo'] = $datos2->correo;
$datos3['contrasennaNueva'] = $datos2->contrasennaNueva;
$datos3['contrasennaActual'] = $datos2->contrasennaActual;
$abogado->conectar();
$response = new stdClass();
$AboagdoAux = $abogado->getAbogado($datos3['correo']);
if(count($AboagdoAux) > 0){
    if($AboagdoAux[0]['contrasena'] == $datos3['contrasennaActual']){
        if($abogado->modificarContrasenna($datos3['contrasennaNueva'],$datos3['correo'])){
            $response->exito = 'OK';
        }else{
            $response->exito = 'ERR';
        }
    }else{
        $response->exito = 'EXISTS';    
    }
}else{

    $response->exito = 'ERR';
}
$abogado->cerrar();
echo(json_encode($response));
?>