<?php
include_once($_SERVER['DOCUMENT_ROOT']."/api/baseDatos/conBase.php");
include_once($_SERVER['DOCUMENT_ROOT']."/api"."/manejoDatos"."/sanitizar.php");
include_once($_SERVER['DOCUMENT_ROOT']."/api"."/manejoDatos"."/cifrar.php");
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
        $datos = Cifrar::megaCifrar(Sanitizar::sanitizaCorreo($datos));
         try{
        $query = $this->conecta->prepare("DELETE FROM cliente WHERE cliente.correo = ?");
        $query->bindParam(1,$datos,PDO::PARAM_STR);
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
    function updateCliente($object){
        try{
        $correo = Cifrar::megaCifrar(Sanitizar::sanitizaString($object['correo']));
        $object = Cifrar::megaCifrar(Sanitizar::sanitizaString($object));
        $object['correo'] = $correo;
        $query = $this->conecta->prepare("UPDATE cliente SET nombre = ?,apellidos = ?,correo = ?,provincia = ? WHERE correo = ?");
        $query->bindParam(1,$object['nombre'],PDO::PARAM_STR);
        $query->bindParam(2,$object['apellidos'],PDO::PARAM_STR);
        $query->bindParam(3,$object['correo'],PDO::PARAM_STR);
        $query->bindParam(4,$object['provincia'],PDO::PARAM_STR);
        $query->bindParam(5,$object['correo'],PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() > 0){
        return true;
        }else{
            return false;
        }
        }catch(PDOException){
            return false;
        }
    }
    function getCliente($object){
        $object = Cifrar::megaCifrar(Sanitizar::sanitizaCorreo($object));
        try{
            $query = $this->conecta->prepare("SELECT * FROM cliente WHERE cliente.correo = ?");
            $query->bindParam(1,$object,PDO::PARAM_STR);
            $query->execute();
            $datos = $query->fetchAll();
            if(count($datos) > 0){
                $contrasena = $datos[0]['contrasena'];
                $id = $datos[0]['id'];
            for($i = 0; $i < count($datos);$i++) {
                $datos[$i] = Cifrar::megaDescifrar($datos[$i]);
            }
            $datos[0]['id'] = $id;
            $datos[0]['contrasena'] = $contrasena;
            } 
            return $datos;
        }catch(PDOException $e){
            return false;
        }
    }
    function getClientes(){        
        try{
        $query = $this->conecta->prepare("SELECT * FROM cliente");
        $query->execute();
        $datos = $query->fetchAll();
        if(count($datos) > 0){
            $contrasena = $datos[0]['contrasena'];
            $id = $datos[0]['id'];
        for($i = 0; $i < count($datos);$i++) {
            $datos[$i] = Cifrar::megaDescifrar($datos[$i]);
        }
        $datos[0]['id'] = $id;
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
    function modificarCorreo($correos){
        try{
            $correos['correoNuevo'] = Sanitizar::sanitizaCorreo($correos['correoNuevo']);
            $correos['correoActual'] = Sanitizar::sanitizaCorreo($correos['correoActual']);
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
