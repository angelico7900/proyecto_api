<?php
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/cliente.php");
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$cliente = new Cliente();
$cliente->conectar();
$obCliente = $cliente->getClientes();
$cliente->cerrar();
$response = new stdClass();
  $response->exito = 'OK';
  $response->clientes = $obCliente;

echo(json_encode($response));
?>
