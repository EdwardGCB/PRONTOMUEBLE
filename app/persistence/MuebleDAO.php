<?php
class MuebleDAO
{
    private $idMueble;
    private $nombre;
    private $descripcio;
    private $tipo;
    private $propiedades;
    private $administrador;

    public function __construct($idMueble = 0, $nombre = "", $descripcio = "", $tipo = null, $propiedades = null, $administrador = null)
    {
        $this->idMueble = $idMueble;
        $this->nombre = $nombre;
        $this->descripcio = $descripcio;
        $this->tipo = $tipo;
        $this->propiedades = $propiedades;
        $this->administrador = $administrador;
    }

    public function consultarPorId()
    {
        return "SELECT nombre, descripcion, administrador_administrador, Tipo_idTipo, img
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
}
