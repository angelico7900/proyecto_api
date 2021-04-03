<?php 
//include();
include($_SERVER['DOCUMENT_ROOT']."/api/baseDatos/conBase.php");
class Usuario extends ConBase{
    //public $base;
    function __construct(){
        parent::__construct();
    }
    function add($datos){
        try{
            $queryUsuario = "INSERT INTO usuario (correo,contrasena,usuario,provincia) VALUES (?,?,?,?)";
            $query = $this->conecta->prepare($queryUsuario);
            $query->bindParam(1,$datos['correo'],PDO::PARAM_STR);
            $query->bindParam(2,$datos['contrasena'],PDO::PARAM_STR);
            $query->bindParam(3,$datos['usuario'],PDO::PARAM_STR);
            $query->bindParam(4,$datos['provincia'],PDO::PARAM_STR);
            $result = $query->execute();
            return $result;
        }catch(PDOException $e){
            echo("a");
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