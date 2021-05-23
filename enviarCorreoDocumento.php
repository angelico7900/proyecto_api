<?php
//incluyendo libreria
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require_once($_SERVER['DOCUMENT_ROOT']."/api"."/PHPMailer-master"."/src/PHPMailer.php");
require_once($_SERVER['DOCUMENT_ROOT']."/api"."/PHPMailer-master"."/src/SMTP.php");
require_once($_SERVER['DOCUMENT_ROOT']."/api"."/PHPMailer-master"."/src/Exception.php");
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
$datos = file_get_contents("php://input");
$datos2 = json_decode($datos);
$contrato = $datos2->contrato;
list(, $contrato) = explode(';', $contrato);
list(, $contrato) = explode(',', $contrato);
$contratoDecode = base64_decode($contrato);
$mail = new PHPMailer(true);
try{
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Host = "smtp.gmail.com";
$mail->Port = 587;
$mail->Password = "Aa12345678@";
$mail->Username = "angelperez2daw@gmail.com";
$mail->setFrom("angelperez2daw@gmail.com","Angel");
$mail->From = "angelperez2daw@gmail.com";
$mail->FromName = "angelperez2daw@gmail.com";
$mail->AddAddress($datos2->correo);
$mail->Subject = "contrato";
$mail->isHTML(true);
$mail->Body = "Ha recibido el contrato para la contratación de un abogado";
$mail->addStringAttachment($contratoDecode,"contrato.pdf","base64","application/pdf");
    $mail->TimeOut = 30;
    $response = new stdClass();
$mail->send();
    $response->exito = 'OK';
}catch(Exception $e){
    $response->exito = 'ERR';
}finally{
    echo(json_encode($response));
}
?>