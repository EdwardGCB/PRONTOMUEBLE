<?php
class Seller extends Person{
    private $administrator;
    private $phones;

    public function getAdministrador() {
        return $this->administrator;
    }

    public function setAdministrator($administrator){
        $this->administrator = $administrator;
    }

    public function getPhones(){
        return $this->phones;
    }
    public function setPhones($phones){
        $this->phones = $phones;
    }

    public function __construct($idPerson=0, $name="", $lastname="", $email="", $password="", $identification=0, $img="", $administrator=null, $phones=null) {
        parent::__construct($idPerson, $name, $lastname, $email, $password, $identification, $img);
        $this->administrator = $administrator;
        $this->phones = $phones;
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

    public function consultarPorId(){
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $sellerDAO = new SellerDAO($this->idPerson);
        $conexion->ejecutarConsulta($sellerDAO -> consultarPorId());
        $registro = $conexion->siguienteRegistro();
        $this->name = $registro[0];
        $this->lastname = $registro[1];
        $this->email = $registro[2];
        $this->identification = $registro[3];
        $this->img = $registro[4];
        $conexion->cerrarConexion();
    }
}
?>