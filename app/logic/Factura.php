<?php
require_once (__DIR__.'../../persistence/Conexion.php');
require (__DIR__.'../../persistence/FacturaDAO.php');
class Factura{
    private $idFactura;
    private $total;
    private $subTotal;
    private $fechaCreacion;
    private $horaCreacion;
    private $iva;
    private $cantidadTotal;
    private $vendedor;
    private $cliente;

    public function getIdFactura(){
        return $this->idFactura;
    }
    public function setIdFactura($idFactura){
        $this->idFactura = $idFactura;
    }
    public function getTotal(){
        return $this->total;
    }
    public function setTotal($total){
        $this->total = $total;
    }
    public function getSubTotal(){
        return $this->subTotal;
    }
    public function setSubTotal($subTotal){
        $this->subTotal = $subTotal;
    }
    public function getFechaCreacion(){
        return $this->fechaCreacion;
    }
    public function setFechaCreacion($fechaCreacion){
        $this->fechaCreacion = $fechaCreacion;
    }
    public function getHoraCreacion(){
        return $this->horaCreacion;
    }
    public function setHoraCreacion($horaCreacion){
        $this->horaCreacion = $horaCreacion;
    }
    public function getIva(){
        return $this->iva;
    }
    public function setIva($iva){
        $this->iva = $iva;
    }
    public function getCantidadTotal(){
        return $this->cantidadTotal;
    }
    public function setCantidadTotal($cantidadTotal){
        $this->cantidadTotal = $cantidadTotal;
    }
    public function getVendedor(){
        return $this->vendedor;
    }
    public function setVendedor($vendedor){
        $this->vendedor = $vendedor;
    }
    public function getCliente(){
        return $this->cliente;
    }
    public function setCliente($cliente){
        $this->cliente = $cliente;
    }

    public function __construct($idFactura=0, $total=0, $subTotal=0, $fechaCreacion=null, $horaCreacion=null, $iva=0, $cantidadTotal=0, $vendedor=null, $cliente=null) {
        $this->idFactura = $idFactura;
        $this->total = $total;
        $this->subTotal = $subTotal;
        $this->fechaCreacion = $fechaCreacion;
        $this->horaCreacion = $horaCreacion;
        $this->iva = $iva;
        $this->cantidadTotal = $cantidadTotal;
        $this->vendedor = $vendedor;
        $this->cliente = $cliente;
    }

}

?>