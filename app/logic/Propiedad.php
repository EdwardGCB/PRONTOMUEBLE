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

    public function consultarPorNombre(){
        $propiedades = array();
        $tipos = array();
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $propiedadDAO = new PropiedadDAO(null,$this->nombre);
        $conexion->ejecutarConsulta($propiedadDAO->consultarPorNombre());
        while($registro = $conexion->siguienteRegistro()){
            if(array_key_exists($registro[2], $tipos)){
                $tipo = $tipos[$registro[2]];
            }else{
                $tipo = new Tipo($registro[2]);
                $tipo->consultarPorId();
            }
            $propiedad = new Propiedad($registro[0], $registro[1], $tipo);
            array_push($propiedades, $propiedad);
        }
        return $propiedades;
    }
}
?>