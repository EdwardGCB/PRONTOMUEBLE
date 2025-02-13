<?php
class FacturaDAO
{
    private $idFactura;
    private $total;
    private $subTotal;
    private $fechaCreacion;
    private $horaCreacion;
    private $iva;
    private $cantidadTotal;
    private $vendedor;
    private $cliente;

    public function __construct($idFactura = 0, $total = 0, $subTotal = 0, $fechaCreacion = null, $horaCreacion = null, $iva = 0, $cantidadTotal = 0, $vendedor = null, $cliente = null)
    {
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

    public function buscarPorNombreCliente()
    {
        return "SELECT idFactura, total, f.fechaCreacion, horaCreacion, cantidad, f.Vendedor_idVendedor, Cliente_idCliente
        FROM Factura f JOIN Cliente ON (Cliente_idCliente = idCliente)
        WHERE nombre LIKE '%" . $this->cliente->getNombres() . "%'";
    }
}
