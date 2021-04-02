<?php 
require('../baseDatos/conBase.php');
class Usuario extends ConBase implements datosBase{
    function __construct()
    {
        parent::__construct();
    }
    function add($datos){
        try{
        $auxInsert = $this->conecta->prepare("INSERT INTO usuario (correo,contrasena,usuario,provincia) 
            VALUES (?,?,?,?)");
            $auxInsert->bindParam(1,$datos['correo'],PDO::PARAM_STR);
            $auxInsert->bindParam(2,$datos['contrasena'],PDO::PARAM_STR);
            $auxInsert->bindParam(3,$datos['usuario'],PDO::PARAM_STR);
            $auxInsert->bindParam(4,$datos['provincia'],PDO::PARAM_STR);
            $result = $auxInsert->execute();
        }catch(PDOException $e){
        }
    }
    function get($object = null){

    }
    function delete(){

    }
    function edit(){

    }
    
}
$a = new ConBase();
?>