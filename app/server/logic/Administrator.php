<?php
class Administrator extends Person{
    public function __construct($idPerson=0, $name="", $lastname="", $email="", $password="", $identification=0, $phones=null) {
        parent::__construct($idPerson, $name, $lastname, $email, $password, $identification, $phones);
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
}
