<?php
require_once (__DIR__.'../../persistence/Conexion.php');
require_once (__DIR__.'../../persistence/TipoDAO.php');
class Tipo{
    private $idTipo;
    private $nombre;
    public function getIdTipo(){
        return $this->idTipo;
    }
    
    public function setIdTipo($idTipo){
        $this->idTipo = $idTipo;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function __construct($idTipo=0, $nombre="") {
        $this->idTipo = $idTipo;
        $this->nombre = $nombre;
    }

    public function consultarPorId(){
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $tipoDAO = new TipoDAO($this->idTipo);
        $this->nombre = $tipoDAO->consultarPorId();
        $conexion->cerrarConexion();
    }
}
?>