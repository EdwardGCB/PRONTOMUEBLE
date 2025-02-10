<?php
class Supplier{
    private $idSupplier;
    private $companyname;
    private $personalcontact;
    private $direcction;
    private $nit;
    private $administrator;

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