<?php
require_once (__DIR__.'../../persistence/Conexion.php');
require_once (__DIR__.'../../persistence/AdministradorDAO.php');
require_once (__DIR__.'../../persistence/ClienteDAO.php');
require_once (__DIR__.'../../persistence/VendedorDAO.php');
class Persona{
    protected $idPersona;
    protected $nombres;
    protected $apellidos;
    protected $identificacion;
    protected $img;
    protected $correo;

    public function getIdPersona(){
        return $this->idPersona;
    }
    public function setIdPersona($idPersona){
        $this->idPersona = $idPersona;
    }
    public function getNombres(){
        return $this->nombres;
    }
    public function setNombres($nombres){
        $this->nombres = $nombres;
    }
    public function getApellidos(){
        return $this->apellidos;
    }
    public function setApellidos($apellidos){
        $this->apellidos = $apellidos;
    }
    public function getIdentificacion(){
        return $this->identificacion;
    }
    public function setIdentificacion($identificacion){
        $this->identificacion = $identificacion;
    }
    public function getImg(){
        return $this->img;
    }
    public function setImg($img){
        $this->img = $img;
    }
    public function getCorreo(){
        return $this->correo;
    }
    public function setCorreo($correo){
        $this->correo = $correo;
    }

    public function __construct($idPersona=0, $nombres="", $apellidos="", $identificacion=0, $img="", $correo="") {
        $this->idPersona = $idPersona;
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->identificacion = $identificacion;
        $this->img = $img;
        $this->correo = $correo;
    }

}
?>