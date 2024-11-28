<?php
class Seller extends Person{
    private $administrator;

    public function getAdministrador(){
        return $this->administrator;
    }
    public function setAdministrator($administrator){
        $this->administrator = $administrator;
    }

    public function __construct($idPerson=0, $name="", $lastname="", $email="", $password="", $identification=0, $phones=null, $administrator=null) {
        parent::__construct($idPerson, $name, $lastname, $email, $password, $identification, $phones);
        $this->administrator = $administrator;
    }

    public function autenticar(){
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $sellerDAO = new SellerDAO(null,null, null, $this->email, $this->password);
        $conexion->ejecutarConsulta($sellerDAO -> autentication());
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
?>