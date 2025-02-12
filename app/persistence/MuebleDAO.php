<?php
class MuebleDAO
{
    private $idMueble;
    private $nombre;
    private $descripcio;
    private $img;
    private $tipo;
    private $propiedades;
    private $administrador;

    public function __construct($idMueble = 0, $nombre = "", $descripcio = "", $img="", $tipo = null, $propiedades = null, $administrador = null)
    {
        $this->idMueble = $idMueble;
        $this->nombre = $nombre;
        $this->descripcio = $descripcio;
        $this->img = $img;
        $this->tipo = $tipo;
        $this->propiedades = $propiedades;
        $this->administrador = $administrador;
    }

    public function consultarPorId()
    {
        return "SELECT nombre, descripcion, Administrador_idAdministrador, Tipo_idTipo, img
                FROM mueble
                WHERE idMueble = $this->idMueble
        ";
    }

    public function buscarPorNombre(){
        return "SELECT idMueble, nombre, descripcion, img
                FROM mueble
                WHERE nombre LIKE '%$this->nombre%'
        ";
    }

    public function guardar(){
        return "INSERT INTO mueble (nombre, descripcion, img, Administrador_idAdministrador, Tipo_idTipo)
                VALUES ('$this->nombre', '$this->descripcio', 'defaul.png', $this->administrador, $this->tipo)
        ";
    }

    public function productosMasVendidos(){
        return "SELECT m.idMueble, m.nombre,
                    (SELECT SUM(df.cantidad) 
                    FROM DetalleFactura df 
                    WHERE df.PedidoProveedor_Mueble_idMueble = m.idMueble) AS total_vendido
                FROM Mueble m
                ORDER BY total_vendido DESC
                LIMIT 5";
    }
}
