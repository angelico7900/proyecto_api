<?php
include_once($_SERVER['DOCUMENT_ROOT']."/api/baseDatos/conBase.php");
include_once($_SERVER['DOCUMENT_ROOT']."/api"."/manejoDatos"."/sanitizar.php");
include_once($_SERVER['DOCUMENT_ROOT']."/api"."/manejoDatos"."/cifrar.php");
class Mensajero extends conBase{
    function __construct()
    {
        parent::__construct();
    }
    function addMensaje($datos){
        try{
            $datos['caso'] = Cifrar::megaCifrar(Sanitizar::sanitizaString($datos['caso']));
            $emisor = $datos['emisor'];
            $emisor = Cifrar::megaCifrar(Sanitizar::sanitizaCorreo($emisor));
            $receptor = $datos['receptor'];
            $receptor = Cifrar::megaCifrar(Sanitizar::sanitizaCorreo($receptor));
            $query = $this->conecta->prepare("INSERT INTO mensajeria (emisor,receptor,caso) VALUES (?,?,?)");
            $query->bindParam(1,$emisor,PDO::PARAM_STR);
            $query->bindParam(2,$receptor,PDO::PARAM_STR);
            $query->bindParam(3,$datos['caso'],PDO::PARAM_STR);
            $query->execute();
            return true;
        }catch(PDOException $e){
            return false;;
        }
    }
    function obtenerMensajes($correo){
        try{
            $correo = Cifrar::megaCifrar(Sanitizar::sanitizaCorreo($correo));
            $query = $this->conecta->prepare("SELECT receptor,caso,emisor FROM mensajeria WHERE receptor = ? OR emisor = ?");
            $query->bindParam(1,$correo,PDO::PARAM_STR);
            $query->bindParam(2,$correo,PDO::PARAM_STR);
            $query->execute();
            $datos = $query->fetchAll();
            if(count($datos) > 0){
                for($i = 0; $i < count($datos);$i++) {
                    $datos[$i] = Cifrar::megaDescifrar($datos[$i]);
                }
            }
            return $datos;
        }catch(PDOException $e){
            return false;
        }
    }
    function addOpinion($datos){
            try{
                $datos['opinion'] = Cifrar::megaCifrar(Sanitizar::sanitizaString($datos['opinion']));
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
            if(count($datos) > 0){
                for($i = 0; $i < count($datos);$i++) {
                    $idAb = $datos[$i]['id_abogado'];
                    $idCl = $datos[$i]['id_cliente'];
                    $datos[$i] = Cifrar::megaDescifrar($datos[$i]);
                    $datos[$i]['id_abogado'] = $idAb;
                    $datos[$i]['id_cliente'] = $idCl;
                }
            }
            return $datos;
        }catch(PDOException $e){
            return false;
        }
    }
    function enviarAviso(){
        
    }
}
?>