<?php
//include('interfaceCliente.php');
class Cliente extends Usuario{
    function __construct()
    {
        parent::__construct();
    }
    function addCliente($datosUser,$datosCliente){
        try{
            $this->base->conecta->beginTransaction();
            $this->add($datosUser);
            $dato = $this->base->conecta->lastInsertId();
        $auxInsert = "INSERT INTO cliente(nombre,apellidos,$dato) VALUES (?,?,?)";
            $this->base->realizarQuery($auxInsert,$datosCliente);
            $this->base->commit();
            
        }catch(PDOException $e){
            $this->base->conecta->rollBack();
        }

    }
    function deleteCliente($datos){

    }
    function editCliente($datos){

    }
    function getCliente($object = null){

    }
}
?>