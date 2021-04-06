<?php
//require($_SERVER['DOCUMENT_ROOT']."/api/usuarios/interfaceCliente.php");
include($_SERVER['DOCUMENT_ROOT']."/api/usuarios/usuario.php");
class Cliente extends Usuario{
    function __construct()
    {
        parent::__construct();
    }
    function addCliente($datos){
        try{
            //$dato = $this->conecta->lastInsertId();
            $query = $this->conecta->prepare("INSERT INTO cliente (nombre,apellidos,id_usuario) VALUES (?,?,?)");
            $query->bindParam(1,$datos['nombre'],PDO::PARAM_STR);
            $query->bindParam(2,$datos['apellidos'],PDO::PARAM_STR);
            $query->bindParam(3,$datos['id'],PDO::PARAM_STR);
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
    function getCliente($object = null){
        try{
        $query = $this->conecta->prepare("SELECT * FROM usuario,cliente WHERE usuario.id = cliente.id_usuario AND usuario.usuario = ?");
        $query->bindParam(1,$object,PDO::PARAM_STR);
        $query->execute();
        $datos = $query->fetch(PDO::FETCH_ASSOC);
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