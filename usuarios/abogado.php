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
            $contrasena = Sanitizar::sanitizarContrasenna($datos['contrasena']);
            $correo = Sanitizar::sanitizaCorreo($datos['correo']);
            $datos = Sanitizar::sanitizaString($datos);
            $datos['correo'] = $correo;
            $contrasena = Cifrar::hashear($contrasena);
            $datos = Cifrar::megaCifrar($datos);
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
        $object = Cifrar::megaCifrar(Sanitizar::sanitizaCorreo($object));
        try{
        $query = $this->conecta->prepare("SELECT * FROM abogado WHERE abogado.correo = ?");
        $query->bindParam(1,$object,PDO::PARAM_STR);
        $query->execute();
        $datos = $query->fetchAll();

        if(count($datos) != 0){
            $contrasena = $datos[0]['contrasena'];
        for($i = 0; $i < count($datos);$i++) {
            $datos[$i] = Cifrar::megaDescifrar($datos[$i]);
        }
        $datos[0]['contrasena'] = $contrasena;
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
                $datos[$i] = Cifrar::megaDescifrar($datos[$i]);
            }
        return $datos;
        }catch(PDOException $e){
            return false;
        }
    }
    function modificarCorreo($correos){
        try{
            $correos[0] = Sanitizar::sanitizaCorreo($correos[0]);
            $correos[1] = Sanitizar::sanitizaCorreo($correos[1]);
            $correos = Cifrar::megaCifrar($correos);
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
            $correo = Sanitizar::sanitizaCorreo($correo);
            $correo = Cifrar::megaCifrar($correo);
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
    function editPathImg($correoActual,$correoNuevo){
        
    }
}
?>
