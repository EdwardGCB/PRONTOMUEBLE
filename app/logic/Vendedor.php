<?php
class Vendedor extends Persona{
    private $administrador;
    private $telefonos;
    private $password;

    public function getAdministrador() {
        return $this->administrador;
    }
    public function setAdministrador($administrador){
        $this->administrador = $administrador;
    }
    public function getPhones(){
        return $this->telefonos;
    }
    public function setPhones($telefonos){
        $this->telefonos = $telefonos;
    }
    public function getPassword(){
        return $this->password;
    }
    public function setPassword($password){
        $this->password = $password;
    }

    public function __construct($idPerson = 0, $name = "", $lastname = "", $identification = 0, $img = "", $correo = "", $administrador = null, $telefonos = null, $password = ""){
        parent::__construct($idPerson, $name, $lastname, $identification, $img, $correo);
        $this->administrador = $administrador;
        $this->telefonos = $telefonos;
        $this->password = $password;
    }

    public function autenticar(){
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $sellerDAO = new VendedorDAO(null,null, null, null, null,$this->correo,null, $this->password);
        $conexion->ejecutarConsulta($sellerDAO -> autentication());
        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        }
        $registro = $conexion->siguienteRegistro();
        $this->idPersona = $registro[0];
        $conexion->cerrarConexion();
        return true;
    }

    public function consultarPorId(){
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $sellerDAO = new vendedorDAO($this->idPersona);
        $conexion->ejecutarConsulta($sellerDAO -> consultarPorId());
        if($conexion->numeroFilas() == 0){
            $conexion->cerrarConexion();
            return false;
        }
        $registro = $conexion->siguienteRegistro();
        $this->nombres = $registro[0];
        $this->apellidos = $registro[1];
        $this->correo = $registro[2];
        $this->identificacion = $registro[3];
        $this->img = $registro[4];
        $conexion->cerrarConexion();
        return true;
    }
}
?>