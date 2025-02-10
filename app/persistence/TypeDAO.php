<?php
class TypeDAO{
    private $idType;
    private $name;

    public function __construct($idType, $name){
        $this->idType = $idType;
        $this->name = $name;
    }
}
?>