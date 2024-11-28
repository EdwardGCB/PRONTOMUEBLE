<?php
class SaleDetail{
    private $amount;
    private $price;
    private $sale;
    private $product;

    public function getAmount(){
        return $this->amount;
    }
    public function setAmount($amount){
        $this->amount = $amount;
    }
    public function getPrice(){
        return $this->price;
    }
    public function setPrice($price){
        $this->price = $price;
    }
    public function getSale(){
        return $this->sale;
    }
    public function setSale($sale){
        $this->sale = $sale;
    }
    public function getProduct(){
        return $this->product;
    }
    public function setProduct($product){
        $this->product = $product;
    }
    
    public function __construct($amount=0, $price=0.0, $sale=null, $product=null){
        $this->amount = $amount;
        $this->price = $price;
        $this->sale = $sale;
        $this->product = $product;
    }
}

?>