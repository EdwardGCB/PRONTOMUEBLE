<?php
class PreSaleDAO{
    private $lot;
    private $product;
    private $client;
    private $seller;
    public function __construct($lot, $product, $client, $seller){
        $this->lot = $lot;
        $this->product = $product;
        $this->client = $client;
        $this->seller = $seller;
    }
}
?>