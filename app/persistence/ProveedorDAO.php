<?php
class ProveedorDAO
{
    private $idProveedor;
    private $razonSocial;
    private $personaContacto;
    private $direccion;
    private $nit;
    private $administrator;
    private $telefonos;
    private $cantPedidos;

    public function __construct($idProveedor = 0, $razonSocial = "", $direccion = "", $nit = "", $personaContacto = "", $administrator = null, $telefonos = null, $cantPedidos=0)
    {
        $this->idProveedor = $idProveedor;
        $this->razonSocial = $razonSocial;
        $this->direccion = $direccion;
        $this->nit = $nit;
        $this->personaContacto = $personaContacto;
        $this->administrator = $administrator;
        $this->telefonos = $telefonos;
        $this->cantPedidos = $cantPedidos;
    }

    public function consultarPorRazonSocial()
    {
        return "SELECT idProveedor,razonSocial, direccion, nit, personaContacto, Administrador_idAdministrador
                FROM proveedor
                WHERE razonSocial LIKE '%" . $this->razonSocial . "%'
        ";
    }
    public function guardar()
    {
        return "INSERT INTO proveedor (razonSocial, direccion, nit, personaContacto, img, Administrador_idAdministrador)
                VALUES ('$this->razonSocial', '$this->direccion', $this->nit, '$this->personaContacto', 'default.png', " . $this->administrator->getIdPersona() . ")
        ";
    }

    public function consultarTodos()
    {
        return "SELECT idProveedor, razonSocial, direccion, nit, personaContacto, Administrador_idAdministrador
                FROM proveedor
        ";
    }

    public function consultarPorId()
    {
        return "SELECT  razonSocial, direccion, nit, personaContacto
                FROM proveedor
                WHERE idProveedor = $this->idProveedor
        ";
    }

    public function cantidadPedidos()
    {
        return "SELECT p.idProveedor, p.razonSocial,
                    (SELECT COUNT(*) 
                    FROM PedidoProveedor pp 
                    WHERE pp.Proveedor_idProveedor = p.idProveedor) AS total_pedidos
                FROM Proveedor p
                ORDER BY total_pedidos DESC
                LIMIT 5;
        ";
    }
}

?>