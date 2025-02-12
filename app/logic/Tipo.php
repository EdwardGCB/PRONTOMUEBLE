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
        $conexion->ejecutarConsulta($tipoDAO -> consultarPorId());
        if($conexion->numeroFilas() == 0){
            $conexion->cerrarConexion();
            return false;
        }
        $this->nombre = $conexion->siguienteRegistro()[0];
        $conexion->cerrarConexion();
        return true;
    }

    public function consultarPorNombre(){
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $tipoDAO = new TipoDAO(null, $this->nombre);
        $conexion->ejecutarConsulta($tipoDAO -> consultarPorNombre());
        $tipos = array();
        while($registro = $conexion->siguienteRegistro()){
            $tipo = new Tipo($registro[0], $registro[1]);
            array_push($tipos, $tipo);
        }
        $conexion->cerrarConexion();
        return $tipos;
    }

    public function consultarTodos(){
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $tipoDAO = new TipoDAO();
        $conexion->ejecutarConsulta($tipoDAO -> consultarTodos());
        $tipos = array();
        while($registro = $conexion->siguienteRegistro()){
            $tipo = new Tipo($registro[0], $registro[1]);
            array_push($tipos, $tipo);
        }
        $conexion->cerrarConexion();
        return $tipos;
    }

    public function guardar(){
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $tipoDAO = new TipoDAO(null, $this->nombre);
        $conexion->ejecutarConsulta($tipoDAO->guardar());
        $resultado = $conexion->obtenerLlaveAutonumerica();
        $conexion->cerrarConexion();
        return $resultado;
    }
}
?>