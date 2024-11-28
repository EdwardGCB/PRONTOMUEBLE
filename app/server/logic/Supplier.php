<?php
require_once ("../persistence/Conexion.php");
require("../persistence/SupplierDAO.php");
class Supplier{
    private $idSupplier;
    private $companyname;
    private $personalcontact;
    private $direcction;
    private $nit;
    private $administrator;

    public function getIdSupplier(){
        return $this->idSupplier;
    }
    public function getCompanyname(){
        return $this->companyname;
    }
    public function setCompanyname(string $companyname){
        $this->companyname = $companyname;
    }
    public function getPersonalcontact(){
        return $this->personalcontact;
    }
    public function setPersonalcontact(string $personalcontact){
        $this->personalcontact = $personalcontact;
    }
    public function getDirecction(){
        return $this->direcction;
    }
    public function setDirecction(string $direcction){
        $this->direcction = $direcction;
    }
    public function getNit() {
        return $this->nit;
    }
    public function setNit(string $nit){
        $this->nit = $nit;
    }
    public function getAdministrator(){
        return $this->administrator;
    }
    public function setAdministrator(string $administrator){
        $this->administrator = $administrator;
    }

    public function __construct($idSupplier=0, $companyname="", $personalcontact="", $direcction="", $nit="", $administrator=null){
        $this->idSupplier = $idSupplier;
        $this->companyname = $companyname;
        $this->personalcontact = $personalcontact;
        $this->direcction = $direcction;
        $this->nit = $nit;
        $this->administrator = $administrator;
    }
}
?>