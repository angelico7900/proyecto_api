<?php
require('interfaceCliente.php');
require('usuario.php');
class Cliente extends Usuario implements Interfacecliente{
    function __construct()
    {
        parent::__construct();
    }
    function addCliente($datos){
        try{
            $this->conecta->beginTransaction();
            $this->add($datos);
        $auxInsert = $this->conecta->prepare("INSERT INTO cliente(nombre,apellidos,id_usuario) 
            VALUES (?,?,?)");
            $auxInsert->bindParam(1,$datos['nombre'],PDO::PARAM_STR);
            $auxInsert->bindParam(2,$datos['apellidos'],PDO::PARAM_STR);
            $auxInsert->bindParam(3,$this->conecta->lastInsertId(),PDO::PARAM_STR);
            $result = $auxInsert->execute();
            $this->conecta->commit();

        }catch(PDOException $e){
            $this->conecta->rollBack();

        }finally{
            $this->base->close();
        }

    }
    function deleteCliente($datos){

    }
    function editCliente($datos){

    }
    function getCliente($object = null){

    }
}
$a = new Cliente();
$b = new Usuario();
var_dump($a);
var_dump($b);
?>