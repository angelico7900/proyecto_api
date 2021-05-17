<?php
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/cliente.php");
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$cliente = new Cliente();
$datos = file_get_contents("php://input");
$datos2 = json_decode($datos);
$datos3 = array();
$datos3['correo'] = $datos2->correo;
$datos3['contrasennaNueva'] = $datos2->contrasennaNueva;
$datos3['contrasennaActual'] = $datos2->contrasennaActual;
$cliente->conectar();
$response = new stdClass();
$clienteAux = $cliente->getCliente($datos3['correo']);
if(count($clienteAux) > 0){

    if($clienteAux[0]['contrasena'] == $datos3['contrasennaActual']){
        if($cliente->modificarContrasenna($datos3['contrasennaNueva'],$datos3['correo'])){
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
echo(json_encode($response));
?>