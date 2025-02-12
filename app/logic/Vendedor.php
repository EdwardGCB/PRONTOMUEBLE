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
    public function getTelefonos(){
        return $this->telefonos;
    }
    public function setTelefonos($telefonos){
        $this->telefonos = $telefonos;
    }
    public function getPassword(){
        return $this->password;
    }
    public function setPassword($password){
        $this->password = $password;
    }

    public function __construct($idPersona = 0, $nombres = "", $apellidos = "", $identificacion = 0, $img = "", $correo = "", $telefonos = null, $password = "", $administrador = null){
        parent::__construct($idPersona, $nombres, $apellidos, $identificacion, $img, $correo);
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

    public function consultarPorNombre(){
        $vendedores = array();
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $sellerDAO = new VendedorDAO(null, $this->nombres);
        $conexion->ejecutarConsulta($sellerDAO -> consultarPorNombre());
        while($resultado = $conexion->siguienteRegistro()){
            $telefono = new Telefono(null,$resultado[0]);
            $telefonos = $telefono->consultarNumerosVendedor();
            $vendedor = new Vendedor($resultado[0], $resultado[1], $resultado[2], $resultado[3], null, $resultado[4], $telefonos);
            array_push($vendedores, $vendedor);
        }
        
        $conexion->cerrarConexion();
        return $vendedores;
    }

    public function consultarTodos(){
        $vendedores = array();
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $sellerDAO = new VendedorDAO();
        $conexion->ejecutarConsulta($sellerDAO -> consultarTodos());
        while($resultado = $conexion->siguienteRegistro()){
            $vendedor = new Vendedor($resultado[0], $resultado[1], $resultado[2], $resultado[3], null, $resultado[4]);
            $vendedor->consultarPorId();
            array_push($vendedores, $vendedor);
        }
        
        $conexion->cerrarConexion();
        return $vendedores;
    }

    public function guardar(){
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $vendedorDAO = new VendedorDAO(null, $this->nombres, $this->apellidos, $this->identificacion, 
        $this->img, $this->correo, null, $this->password, $this->administrador);
        $conexion->ejecutarConsulta($vendedorDAO -> guardar());
        $resultado = $conexion->obtenerLlaveAutonumerica();
        $conexion->cerrarConexion();
        return $resultado;
    }
}
?>