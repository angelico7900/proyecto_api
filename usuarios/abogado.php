<?php
include_once($_SERVER['DOCUMENT_ROOT']."/api/baseDatos/conBase.php");
include_once($_SERVER['DOCUMENT_ROOT']."/api"."/manejoDatos"."/sanitizar.php");
include_once($_SERVER['DOCUMENT_ROOT']."/api"."/manejoDatos"."/cifrar.php");
class Abogado extends conBase{
    function __construct()
    {
        parent::__construct();
    }
    function addAbogado($datos){
        try{
            $contrasena = Sanitizar::sanitizarContrasenna($datos['contrasena']);
            $correo = Sanitizar::sanitizaCorreo($datos['correo']);
            $datos = Sanitizar::sanitizaString($datos);
            $datos['correo'] = $correo;
            $contrasena = Cifrar::hashear($contrasena);
            $datos = Cifrar::megaCifrar($datos);
            $query = $this->conecta->prepare("INSERT INTO abogado (nombre,apellidos,DNI,n_letrado,correo,contrasena,provincia,descripcion,imagen) VALUES (?,?,?,?,?,?,?,?,?)");
            $query->bindParam(1,$datos['nombre'],PDO::PARAM_STR);
            $query->bindParam(2,$datos['apellidos'],PDO::PARAM_STR);
            $query->bindParam(3,$datos['DNI'],PDO::PARAM_STR);
            $query->bindParam(4,$datos['n_letrado'],PDO::PARAM_STR);
            $query->bindParam(5,$datos['correo'],PDO::PARAM_STR);
            $query->bindParam(6,$contrasena,PDO::PARAM_STR);
            $query->bindParam(7,$datos['provincia'],PDO::PARAM_STR);
            $query->bindParam(8,$datos['descripcion'],PDO::PARAM_STR);
            $query->bindParam(9,$datos['imagen'],PDO::PARAM_STR);
            $query->execute();
            return true;
        }catch(PDOException $e){
            return false;
        }
    }
    function updateAbogado($object){
        try{
            $correo = Cifrar::megaCifrar(Sanitizar::sanitizaString($object['correo']));
            $object = Cifrar::megaCifrar(Sanitizar::sanitizaString($object));
            $object['correo'] = $correo;
            $query = $this->conecta->prepare("UPDATE abogado SET nombre = ?,apellidos = ?,dni = ?,n_letrado = ?,correo = ?,provincia = ? WHERE correo = ?");
            $query->bindParam(1,$object['nombre'],PDO::PARAM_STR);
            $query->bindParam(2,$object['apellidos'],PDO::PARAM_STR);
            $query->bindParam(3,$object['dni'],PDO::PARAM_STR);
            $query->bindParam(4,$object['n_letrado'],PDO::PARAM_STR);
            $query->bindParam(5,$object['correo'],PDO::PARAM_STR);
            $query->bindParam(6,$object['provincia'],PDO::PARAM_STR);
            $query->bindParam(7,$object['correo'],PDO::PARAM_STR);
            $query->execute();
            return true;
            }catch(PDOException){
                return false;
            }
    }
    function deleteAbogado($datos){
        $datos = Cifrar::megaCifrar(Sanitizar::sanitizaCorreo($datos));
        try{
        $query = $this->conecta->prepare("DELETE FROM abogado WHERE abogado.correo = ?");
        $query->bindParam(1,$datos,PDO::PARAM_STR);
        $query->execute();
        return true;
        }catch(PDOException $e){
            return false;
        }

    }
    function getAbogado($object,$letrado = null){
        $object = Cifrar::megaCifrar(Sanitizar::sanitizaCorreo($object));
        $letrado = Cifrar::megaCifrar(Sanitizar::sanitizaCorreo($letrado));
        try{
            $query = null;
            if($letrado == null){
                $query = $this->conecta->prepare("SELECT * FROM abogado WHERE abogado.correo = ?");
                $query->bindParam(1,$object,PDO::PARAM_STR);
            }else{
                $query = $this->conecta->prepare("SELECT * FROM abogado WHERE abogado.correo = ? OR abogado.n_letrado = ?");
                $query->bindParam(1,$object,PDO::PARAM_STR);
                $query->bindParam(2,$letrado,PDO::PARAM_STR);
            }
            $query->execute();
            $datos = $query->fetchAll();

            if(count($datos) != 0){
                $contrasena = $datos[0]['contrasena'];
                $id = $datos[0]['id'];
            for($i = 0; $i < count($datos);$i++) {
                $datos[$i] = Cifrar::megaDescifrar($datos[$i]);
            }
            $datos[0]['contrasena'] = $contrasena;
            $datos[0]['id'] = $id;
            } 
            return $datos;
        }catch(PDOException $e){
            return false;
        }
    }
      function getAbogados(){
        try{
        $query = $this->conecta->prepare("SELECT * FROM abogado");
        $query->execute();
        $datos = $query->fetchAll();
            for($i = 0; $i <  count($datos);$i++){
                $id = $datos[$i]['id'];
                $datos[$i] = Cifrar::megaDescifrar($datos[$i]);
                $datos[$i]['id'] = $id;
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
            $query = $this->conecta->prepare("UPDATE abogado SET correo = ? WHERE correo = ?");
            $query->bindParam(1,$correos[0],PDO::PARAM_STR);
            $query->bindParam(2,$correos[1],PDO::PARAM_STR);
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
            $query = $this->conecta->prepare("UPDATE abogado SET contrasena = ? WHERE correo = ?");
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
    function modificarImagen($imagen,$correo){
        try{
            $imagen = Cifrar::megaCifrar(Sanitizar::sanitizaString($imagen));
            $correo = Cifrar::megaCifrar(Sanitizar::sanitizaString($correo));
            $query = $this->conecta->prepare("UPDATE abogado SET imagen = ? WHERE correo = ?");
            $query->bindParam(1,$imagen,PDO::PARAM_STR);
            $query->bindParam(2,$correo,PDO::PARAM_STR);
            $query->execute();
                return true;
            }catch(PDOException $e){
                return false;
            }
    }
    function editPathImg($correoActual,$correoNuevo){
        try{
            $correoActual = Sanitizar::sanitizaCorreo($correoActual);
            $correoActual = Cifrar::megaCifrar($correoActual);
            $correoNuevo = Sanitizar::sanitizaCorreo($correoNuevo);
            $correoNuevo = Cifrar::megaCifrar($correoNuevo);
            $rutaActual = "img/".$correoActual.".png";
            $rutaNuevo = "img/".$correoNuevo.".png";
            if(rename($rutaActual,$rutaNuevo)){
                return true;
            }else{
                return false;
            }
        }catch(Exception $e){
            return false;
        }
    }
    function obtenerAbogadosWhere($datos){
        try{
            $datos = Cifrar::megaCifrar(Sanitizar::sanitizaString($datos));
            $query = $this->conecta->prepare("SELECT * FROM abogado WHERE provincia = ?");
            $query->bindParam(1,$datos,PDO::PARAM_STR);
            $query->execute();
            $resultado = $query->fetchAll();
            if(count($resultado) == 0){
                return $resultado;
            }
            for($i = 0; $i < count($resultado);$i++){
                $resultado[$i] = Cifrar::megaDescifrar($resultado[$i]);
            }
            return $resultado;
        }catch(Exception $e){
            return false;
        }
    }
    function obtenerAbogadoMoroso($abogado){
        $abogado = Cifrar::megaCifrar(Sanitizar::sanitizaCorreo($abogado));
        $query = $this->conecta->prepare("SELECT pagado from abogado_pago INNER JOIN abogado ON abogado_pago.id_abogado = abogado.id 
        WHERE abogado.id = (SELECT id FROM abogado WHERE abogado.correo = ?)");
        $query->bindParam(1,$abogado,PDO::PARAM_STR);
        $query->execute();
        $dato = $query->fetchAll();
        return $dato;
    }
    function obtenerAbogadosMorosos(){
        try{
        $query = $this->conecta->prepare("SELECT abogado.id,abogado.nombre,abogado.apellidos,abogado.correo FROM abogado,abogado_pago where abogado_pago.id_abogado = abogado.id and abogado_pago.pagado < now()");
        $query->execute();
        $datos = $query->fetchAll();
        $query2 = $this->conecta->prepare("SELECT abogado.id,abogado.nombre,abogado.apellidos,abogado.correo from abogado where abogado.id not IN (SELECT id_abogado from abogado_pago)");
        $query2->execute();
        $datos2 = $query2->fetchAll();
        if(count($datos) > 0){
        for ($i=0; $i < count($datos2); $i++) { 
            $fechaActual = strval(date("Y-m-d"));
            if($fechaActual > $datos2[$i]['pagado']){
                $datos[] = $datos2[$i];
            }else{
                
            }
        }
    }else{
        $datos = $datos2;
    }
        for($i = 0; $i < count($datos);$i++){
            $id = $datos[$i]['id'];
            unset($datos[$i]['id']);
            $datos[$i] = Cifrar::megaDescifrar($datos[$i]);
            $datos[$i]['id'] = $id;
            for($j = 0; $j < 4;$j++){
                unset($datos[$i][$j]);
            }
        }
        return $datos;
        }catch(PDOException $e){
            return false;
        }
    }
    function addPago($datos){
        try{
        $query = $this->conecta->prepare("INSERT INTO abogado_pago (id_abogado,pagado) VALUES (?,?)");
        $query->bindParam(1,$datos['id_abogado'],PDO::PARAM_STR);
        $query->bindParam(2,$datos['pagado'],PDO::PARAM_STR);
        $query->execute();
        return true;
        }catch(PDOException $e){
            return false;
        }
    }
}
