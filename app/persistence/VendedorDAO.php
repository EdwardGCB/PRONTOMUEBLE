<?php
class VendedorDAO{
    private $idPersona;
    private $nombres;
    private $apellidos;
    private $identificacion;
    private $img;
    private $correo;

    private $telefonos;

    private $password;
    private $administrador;

    public function __construct($idPersona=0, $nombres="", $apellidos="", $identificacion=0, $img="", $correo="", $telefonos = null, $password="", $administrador = null) {
        $this->idPersona = $idPersona;
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->identificacion = $identificacion;
        $this->img = $img;
        $this->correo = $correo;
        $this->telefonos = $telefonos;
        $this->password = $password;
        $this->administrador = $administrador;
    }

    public function consultarPorNombre(){
        return "SELECT idCliente, nombre, apellido, correo, identificacion, fechaCreacion, vendedor
                FROM cliente
                WHERE nombre LIKE '%$this->nombres%'
        ";
    }

    public function autentication() {
        return "SELECT idVendedor
                FROM vendedor
                WHERE correo = '$this->correo' AND clave = '$this->password'";
    }

    public function consultarPorId(){
        return "SELECT nombre, apellido, correo, identificacion, img
                FROM vendedor
                WHERE idVendedor = $this->idPersona";
    }
}
?>