<?php
include_once($_SERVER['DOCUMENT_ROOT']."/api/baseDatos/conBase.php");
class Cliente extends conBase{
    function __construct()
    {
        parent::__construct();
    }
    function addCliente($datos){
        try{
            $contrasena = Sanitizar::sanitizarContrasenna($datos['contrasena']);
            $correo = Sanitizar::sanitizaCorreo($datos['correo']);
            $datos = Sanitizar::sanitizaString($datos);
            $datos['correo'] = $correo;
            $contrasena = Cifrar::hashear($contrasena);
            $datos = Cifrar::megaCifrar($datos);
            $query = $this->conecta->prepare("INSERT INTO cliente (nombre,apellidos,correo,contrasena,provincia) VALUES (?,?,?,?,?)");
            $query->bindParam(1,$datos['nombre'],PDO::PARAM_STR);
            $query->bindParam(2,$datos['apellidos'],PDO::PARAM_STR);
            $query->bindParam(3,$datos['correo'],PDO::PARAM_STR);
            $query->bindParam(4,$contrasena,PDO::PARAM_STR);
            $query->bindParam(5,$datos['provincia'],PDO::PARAM_STR);
            $query->execute();
            return true;
        }catch(PDOException $e){
            return false;
        }

    }
    function deleteCliente($datos){
         try{
        $query = $this->conecta->prepare("DELETE FROM cliente WHERE cliente.correo = ?");
        $query->execute(array($datos));
        if($query->rowCount() > 0){
            return true;
        }else{
            return false;
        }
        }catch(PDOException $e){
            return false;
        }

    }
    function getCliente($object){
        try{
        $object = Cifrar::megaCifrar(Sanitizar::sanitizaCorreo($object));
        $query = $this->conecta->prepare("SELECT * FROM cliente WHERE cliente.correo = ?");
        $query->bindParam(1,$object,PDO::PARAM_STR);
        $query->execute();
        $datos = $query->fetchAll();
        if(count($datos) != 0){
            $contrasena = $datos[0]['contrasena'];
        for($i = 0; $i < count($datos);$i++) {
            $datos = Cifrar::megaDescifrar($datos[$i]);
        }
        $datos[0]['contrasena'] = $contrasena;
        } 
        return $datos;
        }catch(PDOException $e){
            return false;
        }
    }
    function getClienteId($id){
        try{
            $query = $this->conecta->prepare("SELECT * FROM cliente WHERE cliente.id = ?");
            $query->bindParam(1,$id,PDO::PARAM_INT);
            $query->execute();
            $datos = $query->fetchAll();
            foreach ($datos as $key => $value) {
                foreach ($datos[$key] as $key2 => $value2) {
                        $datos[$key][$key2] = Cifrar::cifrar2($value2,"descifrar");
                        $datos[$key] = Cifrar::desencriptar($value2);
                        $datos[$key] = Cifrar::cifrar($value2,"descifrar");
                        $datos[$key] = Cifrar::desencriptar($value2);
                }
            }
            return $datos;
            }catch(PDOException $e){
                return false;
            }
    }
    function modificarCorreo($correos){
        try{
            $correos[0] = Sanitizar::sanitizaCorreo($correos[0]);
            $correos[1] = Sanitizar::sanitizaCorreo($correos[1]);
            $correos = Cifrar::megaCifrar($correos);
            $query = $this->conecta->prepare("UPDATE cliente SET correo = ? WHERE correo = ?");
            $query->bindParam(1,$correos['correoNuevo'],PDO::PARAM_STR);
            $query->bindParam(2,$correos['correoActual'],PDO::PARAM_STR);
            $query->execute();
            if($query->rowCount() > 0){
                return true;
            }else{
                return false;
            }
            }catch(PDOException $e){
                return false;
            }
    }
    function modificarContrasenna($contrasena,$correo){
        try{
            $correo = Sanitizar::sanitizaCorreo($correo);
            $correo = Cifrar::megaCifrar($correo);
            $contrasena = Sanitizar::sanitizarContrasenna($contrasena);
            $contrasena = Cifrar::hashear($contrasena);
            $query = $this->conecta->prepare("UPDATE cliente SET contrasena = ? WHERE correo = ?");
            $query->bindParam(1,$contrasena,PDO::PARAM_STR);
            $query->bindParam(2,$correo,PDO::PARAM_STR);
            $query->execute();
            if($query->rowCount() > 0){
                return true;
            }else{
                return false;
            }
            }catch(PDOException $e){
                return false;
            }
    }
}
?>
