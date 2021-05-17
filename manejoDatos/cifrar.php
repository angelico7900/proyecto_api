<?php
error_reporting(E_ALL ^ E_WARNING);
function cifrar($dato,$hacer = "cifrar"){
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
function cifrar2($dato,$hacer="cifrar"){
    $key2 = hash('sha256','Ka&df##6HBlQ');
    $iv2 =strtolower(hash('sha256','cEoOm7iXaX'));
    if($hacer == "cifrar"){
    $cifrado = openssl_encrypt($dato,'AES-256-CBC',$key2,0,$iv2);
    return $cifrado;
    }elseif($hacer == "descifrar"){
    $key2 = hash('sha256','Ka&df##6HBlQ');
    $descifrado = openssl_decrypt($dato,'AES-256-CBC',$key2,0,$iv2);
    return $descifrado;
    }
}
function encriptar($dato){
    $cripto = base64_encode($dato);
    return $cripto;
}
function desencriptar($dato){
    $descripto = base64_decode($dato);
    return $descripto;
}
function hashear($dato){
    $dato = password_hash($dato,PASSWORD_BCRYPT);
    return $dato;

}
function comprobarHash($dato,$hash){
    return password_verify($dato,$hash);

}

?>