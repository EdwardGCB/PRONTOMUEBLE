<?php
class ClienteDAO
{
    private $idPersona;
    private $nombres;
    private $apellidos;
    private $identificacion;
    private $img;
    private $correo;

    private $fecha_ini;
    private $asesor;

    private $telefonos;



    public function __construct($idPersona = 0, $nombres = "", $apellidos = "", $identificacion = 0, $img = "", $correo = "", $fecha_ini = "", $asesor = null, $telefonos = null)
    {
        $this->idPersona = $idPersona;
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->identificacion = $identificacion;
        $this->img = $img;
        $this->correo = $correo;
        $this->fecha_ini = $fecha_ini;
        $this->asesor = $asesor;
        $this->telefonos = $telefonos;
    }

    public function consultarPorNombre()
    {
        return "SELECT idCliente, nombre, apellido, correo, identificacion, fechaCreacion, Vendedor_idVendedor
                FROM cliente
                WHERE nombre LIKE '%$this->nombres%'
        ";
    }

    public function consultarTodosClientes()
    {
        return "SELECT idCliente, nombre, apellido, identificacion, correo, fechaCreacion, Vendedor_idVendedor
                FROM cliente";
    }
}
