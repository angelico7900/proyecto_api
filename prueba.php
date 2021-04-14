<?php
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/cliente.php");
$cliente = new Cliente();
$cliente->conectar();
$a = $cliente->getCliente("b");
var_dump($a);
echo($a[0]['contrasena']);
foreach($a as $value){
//var_dump($value);
}
?>