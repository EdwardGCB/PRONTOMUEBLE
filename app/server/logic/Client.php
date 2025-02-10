<?php
class Client extends Person{
    private $dateInit;
    private $seller;

    public function getDateInit(): string{
        return $this->dateInit;
    }

    public function setDateInit(string $dateInit): void{
        $this->dateInit = $dateInit;
    }
    public function getSeller(){

        return $this->seller;
    }

    public function setSeller(string $seller): void{
        $this->seller = $seller;
    }
    
    public function __construct($idPerson=0, $name="", $lastname="", $email="", $password="", $identification=0, $phones=null, $dateInit="", $seller=null) {
        parent::__construct($idPerson, $name, $lastname, $email, $password, $identification, $phones);
        $this->dateInit = $dateInit;
        $this->seller = $seller;
    }
}
?>