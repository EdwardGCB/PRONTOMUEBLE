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

    private $totalCompras;



    public function __construct($idPersona = 0, $nombres = "", $apellidos = "", $identificacion = 0, $img = "", $correo = "", $fecha_ini = "", $asesor = null, $telefonos = null, $totalCompras = 0)
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
        $this->totalCompras = $totalCompras;
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

    public function guardar()
    {
        return "INSERT INTO cliente (nombre, apellido, identificacion, correo, fechaCreacion, Vendedor_idVendedor)
                VALUES ('" . $this->nombres . "', '" . $this->apellidos . "', " . $this->identificacion . ", '" . $this->correo . "', CURDATE(), " . $this->asesor . ")";
    }

    public function clienteMasCompras()
    {
        return "SELECT c.idCliente, c.nombre, c.apellido,
                    (SELECT SUM(f.total) 
                    FROM Factura f 
                    WHERE f.Cliente_idCliente = c.idCliente) AS total_compras
                FROM Cliente c
                ORDER BY total_compras DESC
                LIMIT 10
                ";
    }

    public function consultarPorCedula()
    {
        return "SELECT idCliente, nombre, apellido, correo, Vendedor_idVendedor
            FROM cliente 
            WHERE identificacion = ".$this->identificacion."";
    }

    public function validarCotizacion(){
        return "SELECT Vendedor_idVendedor, PedidoProveedor_Proveedor_idProveedor, PedidoProveedor_Mueble_idMueble
                FROM cotizacion
                WHERE Cliente_idCliente = $this->idPersona";
    }

    public function consultarPorId(){
        return "SELECT nombre, apellido, identificacion, fechaCreacion, correo
                FROM cliente
                WHERE idCliente = $this->idPersona";
    }

}
?>