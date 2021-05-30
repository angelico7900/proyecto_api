<?php
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require_once($_SERVER['DOCUMENT_ROOT']."/api"."/PHPMailer-master"."/src/PHPMailer.php");
require_once($_SERVER['DOCUMENT_ROOT']."/api"."/PHPMailer-master"."/src/SMTP.php");
require_once($_SERVER['DOCUMENT_ROOT']."/api"."/PHPMailer-master"."/src/Exception.php");
$datos = file_get_contents("php://input");
$datos2 = json_decode($datos);
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
$mail->AddAddress("angelperez2daw@gmail.com");
$mail->Subject = "Asunto";
$mail->isHTML(true);
$mail->Body = $datos2->nombre." ".$datos2->apellidos." le ha enviado este contenido:<br>".$datos2->asunto
."<br> Además su correo es: ".$datos2->correo;
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