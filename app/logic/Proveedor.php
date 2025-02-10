<?php
require_once (__DIR__.'../../persistence/Conexion.php');
require (__DIR__.'../../persistence/ProveedorDAO.php');

class Proveedor{
    private $idProveedor;
    private $razonSocial;
    private $direccion;
    private $nit;
    private $personaContacto;
    private $administrator;

    private $telefonos;

    public function getIdProveedor(){
        return $this->idProveedor;
    }
    public function setIdProveedor($idProveedor){
        $this->idProveedor = $idProveedor;
    }
    public function getRazonSocial(){
        return $this->razonSocial;
    }
    public function setRazonSocial($razonSocial){
        $this->razonSocial = $razonSocial;
    }
    public function getDireccion(){
        return $this->direccion;
    }
    public function setDireccion($direccion){
        $this->direccion = $direccion;
    }
    public function getNit(){
        return $this->nit;
    }
    public function setNit($nit){
        $this->nit = $nit;
    }
    public function getPersonaContacto(){
        return $this->personaContacto;
    }
    public function setPersonaContacto($personaContacto){
        $this->personaContacto = $personaContacto;
    }
    public function getAdministrator(){
        return $this->administrator;
    }
    public function setAdministrator($administrator){
        $this->administrator = $administrator;
    }
    public function getTelefonos(){
        return $this->telefonos;
    }
    public function setTelefonos($telefonos){
        $this->telefonos = $telefonos;
    }
    public function __construct($idProveedor=0, $razonSocial="", $direccion="", $nit="", $personaContacto="", $administrator=null, $telefonos=null) {
        $this->idProveedor = $idProveedor;
        $this->razonSocial = $razonSocial;
        $this->direccion = $direccion;
        $this->nit = $nit;
        $this->personaContacto = $personaContacto;
        $this->administrator = $administrator;
        $this->telefonos = $telefonos;
    }

    public function consultarTodos(){
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $proveedores = array();
        $proveedorDAO = new ProveedorDAO();
        $conexion->ejecutarConsulta($proveedorDAO -> consultarTodos());
        while($registro = $conexion->siguienteRegistro()){
            $proveedor = new Proveedor($registro[0], $registro[1], $registro[2], $registro[3], $registro[4], $registro[5]);
            array_push($proveedores, $proveedor);
        }
        $conexion->cerrarConexion();
        return $proveedores;
    }

    public function consultarPorRazonSocial(){
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $proveedores = array();
        $administradores = array();
        $proveedorDAO = new ProveedorDAO(null, $this->razonSocial);
        $conexion->ejecutarConsulta($proveedorDAO -> consultarPorRazonSocial());
        while($registro = $conexion->siguienteRegistro()){
            $administrador=null;
            if(array_key_exists($registro[5], $administradores)){
                $administrador = $administradores[$registro[5]];
            }else{
                $administrador = new Administrador($registro[5]);
                $administrador->consultarPorId();
            }
            $telefono = new Telefono($registro[0]);
            $telefonos = $telefono->consultarNumerosProveedor(); 
            $proveedor = new Proveedor($registro[0], $registro[1], $registro[2], $registro[3], 
            $registro[4], $administrador, $telefonos);
            array_push($proveedores, $proveedor);
        }
        $conexion->cerrarConexion();
        return $proveedores;
    }

    public function consultarPorId(){
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $proveedorDAO = new ProveedorDAO($this->idProveedor);
        $conexion->ejecutarConsulta($proveedorDAO -> consultarPorId());
        if($conexion->numeroFilas() == 0){
            $conexion->cerrarConexion();
            return false;
        }
        $registro = $conexion->siguienteRegistro();
        $this->razonSocial = $registro[0];
        $this->direccion = $registro[1];
        $this->nit = $registro[2];
        $this->personaContacto = $registro[3];
        $conexion->cerrarConexion();
        return true;
    }
}
?>