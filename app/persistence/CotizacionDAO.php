<?php
class CotizacionDAO
{
    private $cantidad;
    private $cliente;
    private $vendedor;
    private $producto;

    public function __construct($cantidad = 0, $cliente = null, $vendedor = null, $producto = null)
    {
        $this->cantidad = $cantidad;
        $this->cliente = $cliente;
        $this->vendedor = $vendedor;
        $this->producto = $producto;
    }

    public function consultarPorCliente()
    {
        return "SELECT cantidad, vendedor_idVendedor, PedidoProveedor_Mueble_idMueble, PedidoProveedor_Proveedor_idProveedor
        FROM cotizacion
        where Cliente_idCliente = $this->cliente
        ";
    }
}
