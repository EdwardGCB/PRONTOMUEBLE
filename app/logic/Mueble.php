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

    private $cantVendida;

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
    public function getCantVendida(){
        return $this->cantVendida;
    }
    public function setCantVendida($cantVendida){
        $this->cantVendida = $cantVendida;
    }
    public function __construct($idMueble=0, $nombre="", $descripcio="", $img="", $tipo=null, $propiedades=null, $administrador=null, $cantVendida=0) {
        $this->idMueble = $idMueble;
        $this->nombre = $nombre;
        $this->descripcio = $descripcio;
        $this->img = $img;
        $this->tipo = $tipo;
        $this->propiedades = $propiedades;
        $this->administrador = $administrador;
        $this->cantVendida = $cantVendida;
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

    public function guardar(){
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $muebleDAO = new MuebleDAO( null, $this->nombre, $this->descripcio, $this->img,$this->tipo,  null, $this->administrador);
        $conexion->ejecutarConsulta($muebleDAO -> guardar());
        $this->idMueble = $conexion->obtenerLlaveAutonumerica();
        if($this->idMueble == null){
            $conexion->cerrarConexion();
            return false;
        }
        $conexion->cerrarConexion();
        return true;
    }

    public function productosMasVendidos(){
        $muebLes=array();
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $muebleDAO = new MuebleDAO();
        $conexion->ejecutarConsulta($muebleDAO -> productosMasVendidos());
        $muebles = array();
        while($registro = $conexion->siguienteRegistro()){
            $mueble = new Mueble($registro[0], $registro[1], null,null,null,null,null,$registro[3]);
            array_push($muebles, $mueble);
        }
        $conexion->cerrarConexion();
        return $muebles;
    }
}
?>