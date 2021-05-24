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
    function obtenerMensajes($correo){
        try{
            $query = $this->conecta->prepare("SELECT receptor,caso,emisor FROM mensajeria WHERE receptor = ? OR emisor = ?");
            $query->bindParam(1,$correo,PDO::PARAM_STR);
            $query->bindParam(2,$correo,PDO::PARAM_STR);
            $query->execute();
            $datos = $query->fetchAll();
            return $datos;
        }catch(PDOException $e){
            return false;
        }
    }
    function addOpinion($datos){
            try{
                $query = $this->conecta->prepare("INSERT INTO opiniones (opinion,id_abogado,id_cliente) VALUES (?,?,?)");
                $query->bindParam(1,$datos['opinion'],PDO::PARAM_STR);
                $query->bindParam(2,$datos['id_abogado'],PDO::PARAM_INT);
                $query->bindParam(3,$datos['id_cliente'],PDO::PARAM_INT);
                $query->execute();
                return true;
            }catch(PDOException $e){
                return false;
            }
        }
    function getOpiniones($id){
        try{
            $query = $this->conecta->prepare("SELECT * FROM opiniones WHERE id_abogado = ?");
            $query->bindParam(1,$id,PDO::PARAM_INT);
            $query->execute();
            $datos = $query->fetchAll();
            return $datos;
        }catch(PDOException $e){
            return false;
        }
    }
}
?>