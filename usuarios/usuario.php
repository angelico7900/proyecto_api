<?php 
include($_SERVER['DOCUMENT_ROOT']."/api/baseDatos/conBase.php");
class Usuario extends ConBase{
    function __construct(){
        parent::__construct();
    }
    function add($datos){
        try{
            $query = $this->conecta->prepare("INSERT INTO usuario (correo,contrasena,usuario,provincia) VALUES (?,?,?,?)");
            $query->bindParam(1,$datos['correo'],PDO::PARAM_STR);
            $query->bindParam(2,$datos['contrasena'],PDO::PARAM_STR);
            $query->bindParam(3,$datos['usuario'],PDO::PARAM_STR);
            $query->bindParam(4,$datos['provincia'],PDO::PARAM_STR);
            $query->execute();
            return true;
        }catch(PDOException $e){
            return false;
        }
    }
    function get($object = null){

    }
    function delete(){

    }
    function edit(){

    }  
}
?>