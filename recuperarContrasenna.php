<?php
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require_once($_SERVER['DOCUMENT_ROOT']."/api"."/PHPMailer-master"."/src/PHPMailer.php");
require_once($_SERVER['DOCUMENT_ROOT']."/api"."/PHPMailer-master"."/src/SMTP.php");
require_once($_SERVER['DOCUMENT_ROOT']."/api"."/PHPMailer-master"."/src/Exception.php");
$datos = file_get_contents("php://input");
$datos2 = json_decode($datos);
$correo = $datos2->correo;
$mail = new PHPMailer(true);
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
$mail->AddAddress($correo);
$mail->Subject = "Restauración de contraseña";
$mail->isHTML(true);
$mail->Body = "Haga click <a href='localhost:4200/restaurar-contrasena'>aquí</a> para restaurar su contraseña,al clickar su contraseña será
restaurada a 1111, por favor tras ello acceda a su usuario para cambiarala";
    $mail->TimeOut = 30;
$mail->send();
    $response->exito = 'OK';
}catch(Exception $e){
    $response->exito = 'ERR';
}finally{
    echo(json_encode($response));
}

?>