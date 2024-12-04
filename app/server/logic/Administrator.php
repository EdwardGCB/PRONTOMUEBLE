<?php
class Administrator extends Person{
    public function __construct($idPerson=0, $name="", $lastname="", $email="", $password="", $identification=0, $img="") {
        parent::__construct($idPerson, $name, $lastname, $email, $password, $identification, $img);
    }

    public function autenticar(){
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $administratorDAO = new AdministratorDAO(null, null, null, $this -> email, $this -> password);
        $conexion->ejecutarConsulta($administratorDAO -> autentication());
        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        }
        $registro = $conexion->siguienteRegistro();
        $this->idPerson = $registro[0];
        $conexion->cerrarConexion();
        return true;
    }

    public function consultarPorId(){
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $administratorDAO = new AdministratorDAO($this->idPerson);
        $conexion->ejecutarConsulta($administratorDAO -> consultarPorId());
        $registro = $conexion->siguienteRegistro();
        $this->name = $registro[0];
        $this->lastname = $registro[1];
        $this->email = $registro[2];
        $this->identification = $registro[3];
        $this->img = $registro[4];
        $conexion->cerrarConexion();
    }
}
