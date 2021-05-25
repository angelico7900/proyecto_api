<?php
include_once($_SERVER['DOCUMENT_ROOT']."/api/baseDatos/conBase.php");
include_once($_SERVER['DOCUMENT_ROOT']."/api"."/manejoDatos"."/sanitizar.php");
include_once($_SERVER['DOCUMENT_ROOT']."/api"."/manejoDatos"."/cifrar.php");
class Abogado extends conBase{
    function __construct()
    {
        parent::__construct();
    }
    function addAbogado($datos){
        try{
            $contrasena = Sanitizar::sanitizarContrasenna($datos['contraseña']);
            $correo = Sanitizar::sanitizaCorreo($datos['correo']);
            $datos = Sanitizar::sanitizaString($datos);
            $datos['correo'] = $correo;
            $contrasena = Cifrar::hashear($contrasena);
            foreach ($datos as $key => $value) {
                $datos[$key] = Cifrar::encriptar($value);
                $datos[$key] = Cifrar::cifrar($value);
                $datos[$key] = Cifrar::encriptar($value);
                $datos[$key] = Cifrar::cifrar2($value);
            }
            $query = $this->conecta->prepare("INSERT INTO abogado (nombre,apellidos,DNI,n_letrado,correo,contrasena,provincia,descripcion,imagen) VALUES (?,?,?,?,?,?,?,?,?)");
            $query->bindParam(1,$datos['nombre'],PDO::PARAM_STR);
            $query->bindParam(2,$datos['apellidos'],PDO::PARAM_STR);
            $query->bindParam(3,$datos['DNI'],PDO::PARAM_STR);
            $query->bindParam(4,$datos['n_letrado'],PDO::PARAM_STR);
            $query->bindParam(5,$datos['correo'],PDO::PARAM_STR);
            $query->bindParam(6,$contrasena,PDO::PARAM_STR);
            $query->bindParam(7,$datos['provincia'],PDO::PARAM_STR);
            $query->bindParam(8,$datos['descripcion'],PDO::PARAM_STR);
            $query->bindParam(9,$datos['imagen'],PDO::PARAM_STR);
            $query->execute();
            return true;
        }catch(PDOException $e){
            return false;
        }
    }
    function deleteAbogado($datos){

    }
    function getAbogado($object){
        try{
        $query = $this->conecta->prepare("SELECT * FROM abogado WHERE abogado.correo = ?");
        $query->execute(array($object));
        $datos = $query->fetchAll();
        foreach ($datos as $key => $value) {
            foreach ($datos[$key] as $key2 => $value2) {
                    $datos[$key][$key2] = Cifrar::cifrar2($value2,"descifrar");
                    $datos[$key] = Cifrar::desencriptar($value2);
                    $datos[$key] = Cifrar::cifrar($value2,"descifrar");
                    $datos[$key] = Cifrar::desencriptar($value2);
            }
        }
        return $datos;
        }catch(PDOException $e){
            return false;
        }
    }
      function getAbogados(){
        try{
        $query = $this->conecta->prepare("SELECT * FROM abogado");
        $query->execute();
        $datos = $query->fetchAll();
            for($i = 0; $i < count($datos);$i++){
                unset($datos[$i][0]);
                unset($datos[$i][1]);
                unset($datos[$i][2]);
                unset($datos[$i][3]);
                unset($datos[$i][4]);
                unset($datos[$i][5]);
                unset($datos[$i][6]);
                unset($datos[$i][7]);
                unset($datos[$i][8]);
                unset($datos[$i][9]);
                $abogado = $datos[$i];
                foreach($abogado as $key => $value) {
                    $abogado[$key] = Cifrar::cifrar2($value,"descifrar");
                    $abogado[$key] = Cifrar::desencriptar($value);
                    $abogado[$key] = Cifrar::cifrar($value,"descifrar");
                    $abogado[$key] = Cifrar::desencriptar($value);
            }
            $datos[$i] = $abogado;
        }
        return $datos;
        }catch(PDOException $e){
            return false;
        }
    }
    function modificarCorreo($correos){
        try{
            $correo = Cifrar::encriptar(Sanitizar::sanitizaCorreo($correos));
            $correo = Cifrar::cifrar($correo);
            $correo = Cifrar::encriptar($correo);
            $correo = Cifrar::cifrar2($correo);
            $query = $this->conecta->prepare("UPDATE abogado SET correo = ? WHERE correo = ?");
            $query->bindParam(1,$correos[0],PDO::PARAM_STR);
            $query->bindParam(2,$correos[1],PDO::PARAM_STR);
            $query->execute();
            if($query->rowCount() > 0){
                return true;
            }else{
                return false;
            }
            }catch(PDOException $e){
                return false;
            }
    }
    function modificarContrasenna($contrasena,$correo){
        try{
            $correo = Cifrar::encriptar(Sanitizar::sanitizaCorreo($correo));
            $correo = Cifrar::cifrar($correo);
            $correo = Cifrar::encriptar($correo);
            $correo = Cifrar::cifrar2($correo);
            $contrasena = Sanitizar::sanitizarContrasenna($contrasena);
            $contrasena = Cifrar::hashear($contrasena);
            $query = $this->conecta->prepare("UPDATE abogado SET contrasena = ? WHERE correo = ?");
            $query->bindParam(1,$contrasena,PDO::PARAM_STR);
            $query->bindParam(2,$correo,PDO::PARAM_STR);
            $query->execute();
            if($query->rowCount() > 0){
                return true;
            }else{
                return false;
            }
            }catch(PDOException $e){
                return false;
            }
    }
    function modificarImagen($imagen,$correo){
        try{
            $correo = Cifrar::encriptar(Sanitizar::sanitizaCorreo($correo));
            $correo = Cifrar::cifrar($correo);
            $correo = Cifrar::encriptar($correo);
            $correo = Cifrar::cifrar2($correo);
            $$imagen = Cifrar::encriptar(Sanitizar::sanitizaCorreo($imagen));
            $imagen = Cifrar::cifrar($imagen);
            $imagen = Cifrar::encriptar($imagen);
            $imagen = Cifrar::cifrar2($imagen);
            $query = $this->conecta->prepare("UPDATE abogado SET imagen = ? WHERE correo = ?");
            $query->bindParam(1,$imagen,PDO::PARAM_STR);
            $query->bindParam(2,$correo,PDO::PARAM_STR);
            $query->execute();
                return true;
            }catch(PDOException $e){
                return false;
            }
    }
}
?>
