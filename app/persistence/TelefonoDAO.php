<?php
class TelefonoDAO
{
    private $numero;
    private $idPersona;

    public function __construct($numero = "", $idPersona = 0)
    {
        $this->numero = $numero;
        $this->idPersona = $idPersona;
    }

    public function consultarNumerosProveedor()
    {
        return "SELECT idTelefonoP
        FROM TelefonoP
        WHERE Proveedor_idProveedor = $this->idPersona";
    }

    public function consultarNumerosCliente()
    {
        return "SELECT idTelefonoC
        FROM TelefonoC
        WHERE Cliente_idCliente = $this->idPersona";
    }

    public function consultarNumerosVendedor(){
        return "SELECT idTelefonoV
        FROM TelefonoV
        WHERE Vendedor_idVendedor = $this->idPersona";
    }

    public function guardarProveedor(){
        return "INSERT INTO TelefonoP (idTelefonoP, Proveedor_idProveedor)
                VALUES ($this->numero, $this->idPersona)
        ";
    }
    public function guardarVendedor(){
        return "INSERT INTO TelefonoV (idTelefonoV, Vendedor_idVendedor)
                VALUES ($this->numero, $this->idPersona)
        ";
    }

    public function guardarCliente(){
        return "INSERT INTO TelefonoC (idTelefonoC, Cliente_idCliente)
                VALUES ($this->numero, $this->idPersona)
        ";
    }
}
