<?php
require_once('mail/PHPMailer.php');
require_once('mail/SMTP.php');
header('Access-Control-Allow-Origin: *');
header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
$datos = file_get_contents("php://input");
$datos2 = json_decode($datos);
$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Host = "smtp.gmail.com";
$mail->Port = 587;
$mail->Password = "Aa12345678@";
$mail->From = "angelperez2daw@gmail.com";
$mail->FromName = "Angel";
$mail->AddAddress($datos2->correo);
$mail->Username = "angelperez2daw@gmail.com";
$mail ->isHTML(true);
$mail->Subject = "CONTRATO";
$mail->Body = "<span>Le ha sido enviado su documento</span>";
$fichero = $datos2->fichero;
$mail->addAttachment($fichero);
$mail->TimeOut = 30;
$response = new stdClass();
if($mail->Send()){
    $response->exito = 'OK';
}else{
    $response->exito = 'ERR';
}
echo(json_encode($response));
?>