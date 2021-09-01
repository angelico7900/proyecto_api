<?php
include_once($_SERVER['DOCUMENT_ROOT']."/api/usuarios/cliente.php");
include_once($_SERVER['DOCUMENT_ROOT']."/api/usuarios/abogado.php");
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
$cliente = new Cliente();
$cliente->conectar();
$obCliente = $cliente->getCliente($correo);
$abogado = new Abogado();
$abogado->conectar();
$obAbogado = $abogado->getAbogado($correo);
$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
$password = "";
$resultado = true;
for($i=0;$i<10;$i++) {
    $password .= substr($str,rand(0,62),1);
}
if(count($obCliente) == 0){
    if(count($obAbogado) == 0){

    }else{
        $resultado = $abogado->modificarContrasenna($password,$correo);
    }
}else{
   $resultado = $cliente->modificarContrasenna($password,$correo);
}
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
$mail->Subject = "Restaurar de contraseña";
$mail->isHTML(true);
$mail->Body = "
<html>
<head>
<title>Restablecer contraseña</title>
</head>
<body>
Su contraseña ha sido modificada a : $password , por favor cambiela en cuanto acceda a su cuenta
</body>
</html>
";
    $mail->TimeOut = 30;
$mail->send();
    $response->exito = 'OK';
}catch(Exception $e){
    $response->exito = 'ERR';
}finally{
    echo(json_encode($response));
}

?>