<?php
require_once("../persistence/Conexion.php");
require("../persistence/ProductDAO.php");
class Product{
    private $idProduct;
    private $name;
    private $description;
    private $type;
    private $properties;

    public function getIdProduct(){
        return $this->idProduct;
    }
    public function setIdProduct($idProduct){
        $this->idProduct = $idProduct;
    }
    public function getName(){
        return $this->name;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function getDescription(){
        return $this->description;
    }
    public function setDescription($description){
        $this->description = $description;
    }
    public function getType(){
        return $this->type;
    }
    public function setType($type){
        $this->type = $type;
    }
    public function getProperties(){
        return $this->properties;
    }
    public function setProperties($properties){
        $this->properties = $properties;
    }

    public function __construct($idProduct=0, $name="", $description="", $type=null, $properties=null) {
        $this->idProduct = $idProduct;
        $this->name = $name;
        $this->description = $description;
        $this->type = $type;
        $this->properties = $properties;
    }
}
?>