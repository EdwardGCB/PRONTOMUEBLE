<?php
class CotizacionDAO
{
    private $cantidad;
    private $cliente;
    private $vendedor;
    private $producto;
    private $proveedor;

    public function __construct($cantidad = 0, $cliente = null, $vendedor = null, $producto = null, $proveedor = null)
    {
        $this->cantidad = $cantidad;
        $this->cliente = $cliente;
        $this->vendedor = $vendedor;
        $this->producto = $producto;
        $this->proveedor = $proveedor;
    }

    public function consultarPorCliente()
    {
        return "SELECT cantidad, vendedor_idVendedor, PedidoProveedor_Mueble_idMueble, PedidoProveedor_Proveedor_idProveedor
        FROM cotizacion
        where Cliente_idCliente = $this->cliente
        ";
    }

    public function guardar()
    {
        return "INSERT INTO cotizacion (cantidad, Cliente_idCliente, vendedor_idVendedor, PedidoProveedor_Mueble_idMueble, PedidoProveedor_Proveedor_idProveedor)
                VALUES ($this->cantidad, " . $this->cliente->getIdPersona() . "," . $this->vendedor->getIdPersona() . ", " . $this->producto->getIdMueble() . ", " . $this->proveedor->getIdProveedor() . ")";
    }

    public function buscarPorNombreCliente()
    {
        return "SELECT SUM(cantidad), Cliente_idCliente, ct.Vendedor_idVendedor
                FROM cotizacion as ct JOIN cliente ON (Cliente_idCliente = idCliente)
                WHERE nombre LIKE '%" . $this->cliente->getNombres() . "%'"; 
    }
}
