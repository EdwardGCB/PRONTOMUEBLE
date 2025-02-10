<?php
require_once (__DIR__.'../../persistence/Conexion.php');
require(__DIR__.'../../persistence/DetalleFacturaDAO.php');
class DetalleFactura{
    private $cantidad;
    private $precio;
    private $pedidoProveedor;

    public function getCantidad(){
        return $this->cantidad;
    }
    
    public function setCantidad($cantidad){
        $this->cantidad = $cantidad;
    }
    
    public function getPrecio(){
        return $this->precio;
    }
    
    public function setPrecio($precio){
        $this->precio = $precio;
    }
    
    public function getPedidoProveedor(){
        return $this->pedidoProveedor;
    }
    
    public function setPedidoProveedor($pedidoProveedor){
        $this->pedidoProveedor = $pedidoProveedor;
    }

    public function __construct($cantidad, $precio, $pedidoProveedor){
        $this->cantidad = $cantidad;
        $this->precio = $precio;
        $this->pedidoProveedor = $pedidoProveedor;
    }
}

?>