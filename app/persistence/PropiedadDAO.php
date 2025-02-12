<?php
class PropiedadDAO
{
    private $idPropiedad;
    private $nombre;
    private $tipo;

    public function __construct($idPropiedad = 0, $nombre = "", $tipo = null)
    {
        $this->idPropiedad = $idPropiedad;
        $this->nombre = $nombre;
        $this->tipo = $tipo;
    }

    public function consultarPorNombre()
    {
        return "SELECT idPropiedad, nombre, Tipo_idTipo
                FROM propiedad
                WHERE nombre LIKE '%" . $this->nombre . "%'
        ";
    }

    public function consultarPorTipo(){
        return "SELECT idPropiedad, nombre, Tipo_idTipo
                FROM propiedad
                WHERE Tipo_idTipo = ". $this->tipo->getIdTipo(). "
        ";
    }

    public function guardar(){
        return "INSERT INTO propiedad (nombre, Tipo_idTipo) 
                VALUES ('$this->nombre', $this->tipo)";
    }
}
?>
