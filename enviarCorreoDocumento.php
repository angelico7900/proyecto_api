<?php

require_once('mail/PHPMailer.php');
use PHPMailer\PHPMailer\PHPMailer;
// require_once('mail/SMTP.php');
// header('Access-Control-Allow-Origin: *');
// header('Acces-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept');
// $datos = file_get_contents("php://input");
// $datos2 = json_decode($datos);
$mail = new PHPMailer();
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Host = "smtp.gmail.com";
$mail->Port = 587;
$mail->Password = "Aa12345678@";
$mail->From = "angelperez2daw@gmail.com";
$mail->FromName = "angelperez2daw@gmail.com";
$mail->AddAddress("angelperezmartinez2000@gmail.com");
$mail->Username = "angelperez2daw@gmail.com";
$mail->Subject = "contrato";
$mail->Body = "Le ha sido enviado su contrato";
// $fichero = $datos2->fichero;
// foreach($fichero as $value){
    //     // $mail->addAttachment($value);
    // }
    $mail->TimeOut = 30;
    var_dump($mail);
    $mail->Send();
    echo("preuba");
$response = new stdClass();
// var_dump($mail);

// if($mail->Send()){
//     echo("saf");
// }else{
//     echo("sajflsaflñksj");
// }
?>