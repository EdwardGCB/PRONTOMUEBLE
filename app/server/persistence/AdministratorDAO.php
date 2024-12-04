<?php
class AdministratorDAO{
    private $idPerson;
    private $name;
    private $lastname;
    private $email;
    private $password;
    private $identification;
    private $img;

    public function __construct($idPerson=0, $name="", $lastname="", $email="", $password="", $identification="", $img="") {
        $this -> idPerson = $idPerson;
        $this -> name = $name;
        $this -> lastname = $lastname;
        $this -> email = $email;
        $this -> password = $password;
        $this -> identification = $identification;
        $this -> img = $img;
    }

    public function autentication() {
        return "SELECT idAdministrador
                FROM administrador
                WHERE correo = '$this->email' AND clave = '$this->password'";
    }

    public function consultarPorId(){
        return "SELECT nombre, apellido, correo, identificacion, img
                FROM administrador
                WHERE idAdministrador = $this->idPerson";
    }

}
?>