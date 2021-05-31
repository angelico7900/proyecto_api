<?php
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/abogado.php");
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$response = new stdClass();
try{
  $datos = file_get_contents('php://input');
  $datos2 = json_decode($datos);
  $abogado = new Abogado();
  $abogado->conectar();
        if($abogado->deleteAbogado($datos2->correo)){
          $response->exito = 'OK';
        }else{
          $response->exito = 'ERR';
        }
}catch(Exception $e){
  $response->exito = 'ERR';
}finally{
echo(json_encode($response));
}
