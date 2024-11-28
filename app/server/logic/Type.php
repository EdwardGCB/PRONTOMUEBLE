<?php
require_once("../persistence/Conexion.php");
require("../persistence/TypeDAO.php");
class Type{
    private $idType;
    private $name;
    public function setIdType($idType){
        $this->idType = $idType;
    }
    public function getIdType(){
        return $this->idType;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function getName(){
        return $this->name;
    }

    public function __construct($idType, $name){
        $this->idType = $idType;
        $this->name = $name;
    }
}
?>