<?php
class ProductSupplierDAO{
    private $lot;
    private $price;
    private $product;
    private $supplier;

    public function __construct($lot=0, $price=0.0, $product=null, $supplier=null){
        $this->lot = $lot;
        $this->price = $price;
        $this->product = $product;
        $this->supplier = $supplier;
    }
}
?>