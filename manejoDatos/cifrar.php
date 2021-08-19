<?php
class Cifrar{
    function __construct()
    {
        error_reporting(E_ALL ^ E_WARNING);
    }
    
   static function cifrar($dato,$hacer = "cifrar"){
        $dato = strval($dato);
        $hacer = trim($hacer);
        $key = hash('sha256','Gkn#sKPauAuj');
        //No le pongo iv porque este tipo de cifrado tiene como un tamaño máximo de iv de 0 bytes 
        if($hacer == "cifrar"){
        $cifrado = openssl_encrypt($dato,'RC4-40',$key,0);
        return $cifrado;
        }elseif($hacer == "descifrar"){
        $descifrado = openssl_decrypt($dato,'RC4-40',$key,0);
        return $descifrado;
        }
        
    }
    static function encriptar($dato){
        $cripto = base64_encode($dato);
        return $cripto;
    }
    static function desencriptar($dato){
        $descripto = base64_decode($dato);
        return $descripto;
    }
    static function hashear($dato){
        $dato = password_hash($dato,PASSWORD_BCRYPT);
        return $dato;

    }
    static function comprobarHash($dato,$hash){
        return password_verify($dato,$hash);
    }
    static public function  megaCifrar($dato){
        if (is_array($dato)) {
            foreach ($dato as $key => $value) {
                $aux = Cifrar::cifrar($value);
                $aux = Cifrar::encriptar($aux);
                $aux = Cifrar::cifrar($aux);
                $aux = Cifrar::encriptar($aux);
                $dato[$key] = $aux;
            }
        } else {
                $dato = Cifrar::cifrar($dato);
                $dato = Cifrar::encriptar($dato);
                $dato = Cifrar::cifrar($dato);
                $dato = Cifrar::encriptar($dato);
        }
        return $dato;
    }
    static public function megaDescifrar($dato){
        if(is_array($dato)){
        foreach($dato as $key => $value){
        $aux = Cifrar::desencriptar($value);
        $aux = Cifrar::cifrar($aux,"descifrar");
        $aux = Cifrar::desencriptar($aux);
        $aux = Cifrar::cifrar($aux,"descifrar");
        $dato[$key] = $aux;
        }
    }else{
            $dato = Cifrar::desencriptar($dato);
            $dato = Cifrar::cifrar($dato,"descifrar");
            $dato = Cifrar::desencriptar($dato);
            $dato = Cifrar::cifrar($dato,"descifrar");
    }
        return $dato;
    }
}
?>