<?php
require_once("../persistence/Conexion.php");
require("../persistence/Pre-SaleDAO.php");

class PreSale{
    private $lot;
    private $product;
    private $client;
    private $seller;
    public function getLot(){
        return $this->lot;
    }
    public function setLot($lot){
        $this->lot = $lot;
    }
    public function getProduct(){
        return $this->product;
    }
    public function setProduct($product){
        $this->product = $product;
    }
    public function getClient(){
        return $this->client;
    }
    public function setClient($client){
        $this->client = $client;
    }
    public function getSeller(){
        return $this->seller;
    }
    public function setSeller($seller){
        $this->seller = $seller;
    }
    public function __construct($lot, $product, $client, $seller){
        $this->lot = $lot;
        $this->product = $product;
        $this->client = $client;
        $this->seller = $seller;
    }
}
?>