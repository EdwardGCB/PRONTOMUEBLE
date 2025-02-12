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
    public function guardar(){
        return "INSERT INTO proveedor (razonSocial, direccion, nit, personaContacto, img, Administrador_idAdministrador)
                VALUES ('$this->razonSocial', '$this->direccion', $this->nit, '$this->personaContacto', 'default.png', ".$this->administrator->getIdPersona().")
        ";
    }

    public function consultarTodos(){
        return "SELECT idProveedor, razonSocial, direccion, nit, personaContacto, Administrador_idAdministrador
                FROM proveedor
        ";
    }

    public function consultarPorId(){
        return "SELECT  razonSocial, direccion, nit, personaContacto
                FROM proveedor
                WHERE idProveedor = $this->idProveedor
        ";
    }
}

?>|