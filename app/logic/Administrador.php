<?php
class Administrador extends Persona{
    private $password;
    public function __construct($idPersona = 0, $nombres = "", $apellidos = "", $identificacion = 0, $img = "", $correo = "", $password="")
    {
        parent::__construct($idPersona, $nombres, $apellidos, $identificacion, $img, $correo);
        $this->password = $password;
    }

    public function autenticar(){
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $administradorDAO = new AdministradorDAO(null, null, null, null,null,$this -> correo, $this -> password);
        $conexion->ejecutarConsulta($administradorDAO -> autentication());
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
        $administradorDAO = new AdministradorDAO($this->idPersona);
        $conexion->ejecutarConsulta($administradorDAO -> consultarPorId());
        $registro = $conexion->siguienteRegistro();
        if($conexion->numeroFilas() == 0){
            $conexion->cerrarConexion();
            return false;
        }
        $this->nombres = $registro[0];
        $this->apellidos = $registro[1];
        $this->correo = $registro[2];
        $this->identificacion = $registro[3];
        $this->img = $registro[4];
        $conexion->cerrarConexion();
        return true;
    }
}
