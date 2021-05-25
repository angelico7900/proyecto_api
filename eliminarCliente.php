<?php
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/cliente.php");
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/abogado.php");
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$response = new stdClass();
try{
  $datos = file_get_contents('php://input');
  $datos2 = json_decode($datos);
  $cliente = new Cliente();
  $cliente->conectar();
  $user = $cliente->getCliente($datos2->correo);
  if(count($user)){
    $response->exito = 'ERR';
  }else{
      if(Cifrar::comprobarHash($datos2->contrasena,$user[0]['contrasena'])){
        if($cliente->deleteCliente($datos2->correo)){
          $response->exito = 'OK';
        }else{
          $response->exito = 'ERR';
        }
      }else{
        $response->exito = 'ERR';
      }
  } 
}catch(Exception $e){
  $response->exito = 'ERR';
}finally{
echo(json_encode($response));
}

?>
