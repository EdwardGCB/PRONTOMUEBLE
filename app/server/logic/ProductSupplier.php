<?php
require_once ("../persistence/Conexion.php");
require ("../persistence/ProductSupplierDAO.php");

class ProductSupplier{
    private $lot;
    private $price;
    private $product;
    private $supplier;

    public function getLot(){
        return $this->lot;
    }
    public function setLot($lot){
        $this->lot = $lot;
    }
    public function getPrice(){
        return $this->price;
    }
    public function setPrice($price){
        $this->price = $price;
    }
    public function getProduct(){
        return $this->product;
    }
    public function setProduct($product){
        $this->product = $product;
    }
    public function getSupplier(){
        return $this->supplier;
    }
    public function setSupplier($supplier){
        $this->supplier = $supplier;
    }

    public function __construct($lot=0, $price=0.0, $product=null, $supplier=null){
        $this->lot = $lot;
        $this->price = $price;
        $this->product = $product;
        $this->supplier = $supplier;
    }
}
?>