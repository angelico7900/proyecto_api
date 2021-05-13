<?php
include_once($_SERVER['DOCUMENT_ROOT']."/api/baseDatos/conBase.php");
class Abogado extends conBase{
    function __construct()
    {
        parent::__construct();
    }
    function addAbogado($datos){
        try{
            $query = $this->conecta->prepare("INSERT INTO abogado (nombre,apellidos,DNI,n_letrado,correo,contrasena,provincia,descripcion,imagen) VALUES (?,?,?,?,?,?,?,?,?)");
            $query->bindParam(1,$datos['nombre'],PDO::PARAM_STR);
            $query->bindParam(2,$datos['apellidos'],PDO::PARAM_STR);
            $query->bindParam(3,$datos['DNI'],PDO::PARAM_STR);
            $query->bindParam(4,$datos['n_letrado'],PDO::PARAM_STR);
            $query->bindParam(5,$datos['correo'],PDO::PARAM_STR);
            $query->bindParam(6,$datos['contrasena'],PDO::PARAM_STR);
            $query->bindParam(7,$datos['provincia'],PDO::PARAM_STR);
            $query->bindParam(8,$datos['descripcion'],PDO::PARAM_STR);
            $query->bindParam(9,$datos['imagen'],PDO::PARAM_STR);
            $query->execute();
            return true;
        }catch(PDOException $e){
            return false;
        }
    }
    function deleteCliente($datos){

    }
    function editCliente($datos){

    }
    function getAbogado($object){
        try{
        $query = $this->conecta->prepare("SELECT * FROM abogado WHERE abogado.correo = ?");
        $query->execute(array($object));
        $datos = $query->fetchAll();
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
        return $datos;
        }catch(PDOException $e){
            return false;
        }
    }
    function comprobarPass($user,$pass){
        if($user == $pass){
            return true;
        }else{
            return false;
        }
    }
    function modificarCorreo($correo){
        try{
            $query = $this->conecta->prepare("UPDATE abogado SET correo = ? WHERE correo = ?");
            $query->execute(array($correo));
            if($query->rowCount() > 0){
                return true;
            }else{
                return false;
            }
            }catch(PDOException $e){
                return false;
            }
    }
}
?>
