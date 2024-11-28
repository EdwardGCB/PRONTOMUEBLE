<?php
require_once ("../persistence/Conexion.php");
require ("../persistence/ProductPropertyDAO.php");
class ProductProperty{
    private $description;
    private $product;
    private $property;
    public function getDescription(){
        return $this->description;
    }
    public function setDescription($description){
        $this->description = $description;
    }
    public function getProduct(){
        return $this->product;
    }
    public function setProduct($product){
        $this->product = $product;
    }
    public function getProperty(){
        return $this->property;
    }
    public function setProperty($property){
        $this->property = $property;
    }

    public function __construct($description, $product, $property){
        $this->description = $description;
        $this->product = $product;
        $this->property = $property;
    }

}
?>