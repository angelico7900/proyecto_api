<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require_once($_SERVER['DOCUMENT_ROOT']."/api"."/PHPMailer-master"."/src/PHPMailer.php");
require_once($_SERVER['DOCUMENT_ROOT']."/api"."/PHPMailer-master"."/src/SMTP.php");
require_once($_SERVER['DOCUMENT_ROOT']."/api"."/PHPMailer-master"."/src/Exception.php");
$mail = new PHPMailer(true);
$datos = file_get_contents("php://input");
$datos2 = json_decode($datos);
$response = new stdClass();
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
    $mail->Subject = "aviso de impago";
    $mail->isHTML(true);
    $mail->Body = "Tiene la cuenta desactivada por imago,por favor pague la mensualidad para poder";
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