<?php
require_once("../persistence/Conexion.php");
require("../persistence/PhoneDAO.php");
class Phone{
    private $number;
    public function __construct($number){
        $this->number = $number;
    }
    public function getNumber(){
        return $this->number;
    }
    public function setNumber($number){
        $this->number = $number;
    }
}
?>