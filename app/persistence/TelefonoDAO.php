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
        WHERE idProveedor = $this->idPersona";
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
        WHERE idVendedor = $this->idPersona";
    }
}
