<?php
include_once($_SERVER['DOCUMENT_ROOT']."/api/baseDatos/conBase.php");
include_once($_SERVER['DOCUMENT_ROOT']."/api"."/manejoDatos"."/sanitizar.php");
include_once($_SERVER['DOCUMENT_ROOT']."/api"."/manejoDatos"."/cifrar.php");
class Administrador extends conBase{
    function __construct()
    {
        parent::__construct();
    }
    function getAdmin($object){
        $object = Cifrar::megaCifrar(Sanitizar::sanitizaString($object));
        try{
        $query = $this->conecta->prepare("SELECT * FROM administrador WHERE administrador.nombre = ?");
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
}
?>
