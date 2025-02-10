<?php
class AdministradorDAO{
    private $idPersona;
    private $nombres;
    private $apellidos;
    private $identificacion;
    private $img;
    private $correo;
    private $password;

    public function __construct($idPersona=0, $nombres="", $apellidos="", $identificacion=0, $img="", $correo="", $password="") {
        $this->idPersona = $idPersona;
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->identificacion = $identificacion;
        $this->img = $img;
        $this->correo = $correo;
        $this->password = $password;
    }

    public function autentication() {
        return "SELECT idAdministrador
                FROM administrador
                WHERE correo = '$this->correo' AND clave = '$this->password'";
    }

    public function consultarPorId(){
        return "SELECT nombre, apellido, correo, identificacion, img
                FROM administrador
                WHERE idAdministrador = $this->idPersona";
    }

}
?>