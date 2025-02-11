<?php
class ProveedorDAO{
    private $idProveedor;
    private $razonSocial;
    private $personaContacto;
    private $direccion;
    private $nit;
    private $administrator;
    private $telefonos;

    public function __construct($idProveedor=0, $razonSocial="", $direccion="", $nit="", $personaContacto="", $administrator=null, $telefonos=null) {
        $this->idProveedor = $idProveedor;
        $this->razonSocial = $razonSocial;
        $this->direccion = $direccion;
        $this->nit = $nit;
        $this->personaContacto = $personaContacto;
        $this->administrator = $administrator;
        $this->telefonos = $telefonos;
    }

    public function consultarPorRazonSocial(){
        return "SELECT idProveedor,razonSocial, direccion, nit, personaContacto, Administrador_idAdministrador
                FROM proveedor
                WHERE razonSocial LIKE '%".$this->razonSocial."%'
        ";
    }
}

?>|