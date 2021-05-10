<?php 
class Sanitizar{

    function __construct()
    {
        
    }
    static function sanitizaString($datos){
        foreach ($datos as $key => $value) {
            $datos[$key] = strtolower(filter_var(strip_tags($value),FILTER_SANITIZE_STRING));
        }
        return $datos;
    }
    static function sanitizaCorreo($correo){
        $correo = strtolower(filter_var(strip_tags($correo),FILTER_SANITIZE_EMAIL));
        return $correo;
    }
    static function sanitizarContrasenna($contrasena){
        return filter_var(strip_tags($value),FILTER_SANITIZE_STRING);
    }
}



?>
