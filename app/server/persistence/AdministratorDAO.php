<?php
class AdministratorDAO{
    private $idPerson;
    private $name;
    private $lastname;
    private $email;
    private $password;
    private $identification;
    private $phones;

    public function __construct($idPerson=0, $name="", $lastname="", $email="", $password="", $identification="", $phones=0) {
        $this -> idPerson = $idPerson;
        $this -> name = $name;
        $this -> lastname = $lastname;
        $this -> email = $email;
        $this -> password = $password;
        $this -> identification = $identification;
        $this -> phones = $phones;
    }

    public function autentication() {
        return "SELECT idAdministrador
                FROM administrador
                WHERE correo = '$this->email' AND clave = '$this->password'";
    }

}
?>