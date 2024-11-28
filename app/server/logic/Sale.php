<?php
require_once ("../persistence/Conexion.php");
require ("../persistence/SaleDAO.php");
class Sale{
    private $idSale;
    private $totalAmount;
    private $subTotal;
    private $date;
    private $time;
    private $iva;
    private $total;
    private $seller;
    private $client;

    public function setIdSale($idSale){
        $this->idSale = $idSale;
    }

    public function getIdSale(){
        return $this->idSale;
    }
    public function setTotalAmount($totalAmount){
        $this->totalAmount = $totalAmount;
    }
    public function getTotalAmount(){
        return $this->totalAmount;
    }
    public function getSubTotal(){
        return $this->subTotal;
    }
    public function setSubTotal($subTotal){
        $this->subTotal = $subTotal;
    }
    public function getDate(){
        return $this->date;
    }
    public function setDate($date){
        $this->date = $date;
    }
    public function getTime(){
        return $this->time;
    }
    public function setTime($time){
        $this->time = $time;
    }
    public function getIva(){
        return $this->iva;
    }
    public function setIva($iva){
        $this->iva = $iva;
    }
    public function getTotal(){
        return $this->total;
    }
    public function setTotal($total){
        $this->total = $total;
    }
    public function setSeller($seller){
        $this->seller = $seller;
    }
    public function getSeller(){
        return $this->seller;
    }
    public function setClient($client){
        $this->client = $client;
    }
    public function getClient(){
        return $this->client;
    }
    public function __construct($idSale=0, $totalAmount=0, $subTotal=0.0, $date="", $time="", $iva=0.0, $total=0.0, $seller=null, $client=null){
        $this->idSale = $idSale;
        $this->totalAmount = $totalAmount;
        $this->subTotal = $subTotal;
        $this->date = $date;
        $this->time = $time;
        $this->iva = $iva;
        $this->total = $total;
        $this->seller = $seller;
        $this->client = $client;
    }

}

?>