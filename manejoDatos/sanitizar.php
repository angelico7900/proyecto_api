<?php 
class Sanitizar{

    function __construct()
    {
        
    }
    static function sanitizaString($datos){
        foreach ($datos as $key => $value) {
            $datos[$key] = trim(filter_var(strip_tags($value),FILTER_SANITIZE_STRING));
        }
        return $datos;
    }
    static function sanitizaCorreo($correo){
        $correo = trim(strtolower(filter_var(strip_tags($correo),FILTER_SANITIZE_EMAIL)));
        return $correo;
    }
    static function sanitizarContrasenna($contrasena){
        return trim(filter_var(strip_tags($contrasena),FILTER_SANITIZE_STRING));
    }
}



?>
