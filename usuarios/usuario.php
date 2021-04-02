<?php 
require('../baseDatos/conBase.php');
require('../baseDatos/datosBase.php');
class Usuario implements datosBase{
    private $base;
    function __construct(){
        $this->base = new ConBase();
    }
    function add($datos){
        try{
            $queryUsuario = "INSERT INTO usuario (correo,contrasena,usuario,provincia) VALUES (?,?,?)";
            $queryCliente = "INSERT INTO cliente (nombre,apellidos,id_usuario) VALUES (?,?,?)";
            $this->base->conecta->beginTransaction();
            $this->base->realizarQuery($queryUsuario,$datos);
            $datos[] = $this->base->conecta->LastInsertId();
            $this->base->realizarQuery($queryCliente,$datos);
            $this->base->conecta->commit();
        }catch(PDOException $e){
            $this->base->conecta->rollBack();
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