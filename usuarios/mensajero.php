<?php
include_once($_SERVER['DOCUMENT_ROOT']."/api/baseDatos/conBase.php");
class Mensajero extends conBase{
    function __construct()
    {
        parent::__construct();
    }
    function addMensaje($datos){
        try{
            $query = $this->conecta->prepare("INSERT INTO mensajeria (emisor,receptor,caso) VALUES (?,?,?)");
            $query->bindParam(1,$datos['emisor'],PDO::PARAM_STR);
            $query->bindParam(2,$datos['receptor'],PDO::PARAM_STR);
            $query->bindParam(3,$datos['caso'],PDO::PARAM_STR);
            $query->execute();
            return true;
        }catch(PDOException $e){
            return false;
        }
    }
}
?>