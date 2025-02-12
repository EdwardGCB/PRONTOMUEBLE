<?php
require_once (__DIR__.'../../persistence/Conexion.php');
require (__DIR__.'../../persistence/MueblePropiedadDAO.php');
class MueblePropiedad{
    private $descripcion;
    private $mueble;
    private $propiedad;
    public function getDescripcion(){
        return $this->descripcion;
    }
    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }
    public function getMueble(){
        return $this->mueble;
    }
    public function setMueble($mueble){
        $this->mueble = $mueble;
    }
    public function getPropiedad(){
        return $this->propiedad;
    }
    public function setPropiedad($propiedad){
        $this->propiedad = $propiedad;
    }
    public function __construct($descripcion="", $mueble=null, $propiedad=null){
        $this->descripcion = $descripcion;
        $this->mueble = $mueble;
        $this->propiedad = $propiedad;
    }

    public function guardar(){
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $mueblePropiedadDAO = new MueblePropiedadDAO($this->descripcion, $this->mueble, $this->propiedad);
        $conexion->ejecutarConsulta($mueblePropiedadDAO->guardar());
        $conexion->cerrarConexion();
    }
}
?>