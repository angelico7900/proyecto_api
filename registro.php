<?php
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$json = file_get_contents('php://input');
$datos = json_decode($json);
header('Content-type: application/json');
echo($json);
?>