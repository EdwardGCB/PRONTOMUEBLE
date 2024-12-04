<?php
class SellerDAO{
    private $idPerson;
    private $name;
    private $lastname;
    private $email;
    private $password;
    private $identification;
    private $phones;
    private $administrator;

    public function __construct($idPerson="", $name="", $lastname="", $email="", $password="", $identification="", $phones=0, $administrator=null) {
        $this -> idPerson = $idPerson;
        $this -> name = $name;
        $this -> lastname = $lastname;
        $this -> email = $email;
        $this -> password = $password;
        $this -> identification = $identification;
        $this -> phones = $phones;
        $this->administrator = $administrator;
    }

    public function autentication() {
        return "SELECT idVendedor
                FROM vendedor
                WHERE correo = '$this->email' AND clave = '$this->password'";
    }

    public function consultarPorId(){
        return "SELECT nombre, apellido, correo, identificacion, img
                FROM vendedor
                WHERE idVendedor = $this->idPerson";
    }
}
?>