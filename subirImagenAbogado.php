<?php 
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/abogado.php");
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$datos  = file_get_contents('php://input');
$datos2 = json_decode($datos);
$base = base64_decode($datos2->archivo);
echo($datos);

?>