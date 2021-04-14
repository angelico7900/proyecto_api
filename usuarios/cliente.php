<?php
include($_SERVER['DOCUMENT_ROOT']."/api/baseDatos/conBase.php");
class Cliente extends conBase{
    function __construct()
    {
        parent::__construct();
    }
    function addCliente($datos){
        try{
            $query = $this->conecta->prepare("INSERT INTO cliente (nombre,apellidos,correo,contrasena,provincia) VALUES (?,?,?,?,?)");
            $query->bindParam(1,$datos['nombre'],PDO::PARAM_STR);
            $query->bindParam(2,$datos['apellidos'],PDO::PARAM_STR);
            $query->bindParam(3,$datos['correo'],PDO::PARAM_STR);
            $query->bindParam(4,$datos['contrasena'],PDO::PARAM_STR);
            $query->bindParam(5,$datos['provincia'],PDO::PARAM_STR);
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
    function getCliente($object){
        try{
        $query = $this->conecta->prepare("SELECT * FROM cliente WHERE cliente.correo = ?");
        $query->execute(array($object));
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
}
?>