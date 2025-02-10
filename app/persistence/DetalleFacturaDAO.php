<?php 
class DetalleFacturaDAO{
    private $cantidad;
    private $precio;
    private $pedidoProveedor;

    public function __construct($cantidad, $precio, $pedidoProveedor){
        $this->cantidad = $cantidad;
        $this->precio = $precio;
        $this->pedidoProveedor = $pedidoProveedor;
    }
}

?>