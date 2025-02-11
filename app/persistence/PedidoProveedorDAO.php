<?php
class PedidoProveedorDAO{
    private $cantidadPost;
    private $cantidadPre;
    private $precio;

    private $ganancia;

    private $precioFinal;
    private $proveedor;
    private $mueble;

    public function __construct($cantidadPost = 0,$cantidadPre=0, $precio = 0, $ganancia = 0, $precioFinal = 0, $proveedor = null, $mueble = null){
        $this->cantidadPost = $cantidadPost;
        $this->cantidadPre = $cantidadPre;
        $this->precio = $precio;
        $this->ganancia = $ganancia;
        $this->precioFinal = $precioFinal;
        $this->proveedor = $proveedor;
        $this->mueble = $mueble;
    }

    public function buscarNombreMueble(){
        return "SELECT cantidadPost, cantidadPre, precio, precioFinal, Proveedor_idProveedor, Mueble_idMueble
                FROM PedidoProveedor JOIN Mueble ON (Mueble_idMueble = idMueble)
                WHERE nombre LIKE '%".$this->mueble->getNombre()."%'
        ";
    }
}
?>