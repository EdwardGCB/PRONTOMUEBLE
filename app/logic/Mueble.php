<?php
require_once (__DIR__.'../../persistence/Conexion.php');
require_once (__DIR__.'../../persistence/MuebleDAO.php');
class Mueble{
    private $idMueble;
    private $nombre;
    private $descripcio;
    private $tipo;
    private $img;
    private $propiedades;
    private $administrador;

    public function getIdMueble(){
        return $this->idMueble;
    }
    public function setIdMueble($idMueble){
        $this->idMueble = $idMueble;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function getDescripcio(){
        return $this->descripcio;
    }
    public function setDescripcio($descripcio){
        $this->descripcio = $descripcio;
    }
    public function getTipo(){
        return $this->tipo;
    }
    public function setTipo($tipo){
        $this->tipo = $tipo;
    }
    public function getPropiedades(){
        return $this->propiedades;
    }
    public function setPropiedades($propiedades){
        $this->propiedades = $propiedades;
    }
    public function getAdministrador(){
        return $this->administrador;
    }
    public function setAdministrador($administrador){
        $this->administrador = $administrador;
    }
    public function getImg(){
        return $this->img;
    }
    public function setImg($img){
        $this->img = $img;
    }
    public function __construct($idMueble=0, $nombre="", $descripcio="", $tipo=null, $propiedades=null, $administrador=null) {
        $this->idMueble = $idMueble;
        $this->nombre = $nombre;
        $this->descripcio = $descripcio;
        $this->tipo = $tipo;
        $this->propiedades = $propiedades;
        $this->administrador = $administrador;
    }

    public function consultarPorId(){
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $muebleDAO = new MuebleDAO($this->idMueble);
        $conexion->ejecutarConsulta($muebleDAO -> consultarPorId());
        $registro = $conexion->siguienteRegistro();
        if($conexion->numeroFilas() == 0){
            $conexion->cerrarConexion();
            return false;
        }
        $this->nombre = $registro[0];
        $this->descripcio = $registro[1];
        $administrador = new Administrador($registro[2]);
        $administrador->consultarPorId();
        $this->administrador = $administrador;
        $tipo = new Tipo($registro[3]);
        $tipo->consultarPorId();
        $this->tipo = $tipo;
        $this->img = $registro[4];
        $conexion->cerrarConexion();
        return true;
    }

    public function buscarPorNombre(){
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $muebleDAO = new MuebleDAO(null, $this->nombre);
        $conexion->ejecutarConsulta($muebleDAO -> buscarPorNombre());
        $muebles = array();
        while($registro = $conexion->siguienteRegistro()){
            $mueble = new Mueble($registro[0]);
            $mueble->consultarPorId();
            array_push($muebles, $mueble);
        }
        $conexion->cerrarConexion();
        return $muebles;
    }
}
?>