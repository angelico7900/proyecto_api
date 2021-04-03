<?php
    class  ConBase{
        public $user;
        public $pass;
        public $conecta;
    
        function __construct(){
            try{
                $this->user = 'root';
                $this->pass = '';
    
            }catch(Exception $e){
                echo($e->getMessage());
            }
        }
        public function conectar(){
            try{
            $this->conecta = new PDO("mysql:dbname=abogados;host:localhost",
                $this->user,$this->pass);
                $this->conecta->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER);
                $this->conecta->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            }catch(Exception $e){
                echo($e->getMessage());
            }
        }
        public function close(){
            $this->conecta = null;
        }
        public function realizarQuery($query,$valores){
            $insert = $this->conecta->prepare($query);
            for($i = 1; $i <= $valores;$i++){
                echo("adfsdaf");
                $insert->bindParam($i,$valores[$i--],PDO::PARAM_STR);
            }
            return $insert->execute();
            
        }
    }
?>
