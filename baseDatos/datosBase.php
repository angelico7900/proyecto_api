<?php
interface datosBase{
    public function add($datos);
    public function get(object $object = null);
    public function delete();
    public function edit();
    public function close();
}

?>