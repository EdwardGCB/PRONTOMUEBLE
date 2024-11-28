<?php
class ProductPropertyDAO{
    private $description;
    private $product;
    private $property;

    public function __construct($description, $product, $property){
        $this->description = $description;
        $this->product = $product;
        $this->property = $property;
    }
}
?>