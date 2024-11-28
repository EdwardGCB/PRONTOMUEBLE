<?php
require_once ("../persistence/Conexion.php");
require("../persistence/PropertyDAO.php");
class Property{
    private $idProperty;
    private $name;
    private $type;

    public function getIdProperty(){
        return $this->idProperty;
    }
    public function setIdProperty($idProperty){
        $this->idProperty = $idProperty;
    }
    public function getName(){
        return $this->name;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function getType(){
        return $this->type;
    }
    public function setType($type){
        $this->type = $type;
    }

    public function __construct($idProperty=0, $name= "", $type= null){
        $this->idProperty = $idProperty;
        $this->name = $name;
        $this->type = $type;
    }
}
?>