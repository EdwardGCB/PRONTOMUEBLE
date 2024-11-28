<?php
class SaleDAO{
    private $idSale;
    private $totalAmount;
    private $subTotal;
    private $date;
    private $time;
    private $iva;
    private $total;
    private $seller;
    private $client;
    
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