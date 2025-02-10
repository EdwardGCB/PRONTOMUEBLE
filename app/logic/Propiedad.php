<?php
require_once (__DIR__.'../../persistence/Conexion.php');
require(__DIR__.'../../persistence/PropiedadDAO.php');
class Propiedad{
    private $idPropiedad;
    private $nombre;
    private $tipo;

    public function getIdPropiedad(){
        return $this->idPropiedad;
    }
    public function setIdPropiedad($idPropiedad){
        $this->idPropiedad = $idPropiedad;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function getTipo(){
        return $this->tipo;
    }
    public function setTipo($tipo){
        $this->tipo = $tipo;
    }

    public function __construct($idPropiedad=0, $nombre="", $tipo=null) {
        $this->idPropiedad = $idPropiedad;
        $this->nombre = $nombre;
        $this->tipo = $tipo;
    }
}
?>