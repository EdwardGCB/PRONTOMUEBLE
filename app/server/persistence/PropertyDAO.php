<?php
class PropertyDAO{
    private $idProperty;
    private $name;
    private $type;

    public function __construct($idProperty=0, $name= "", $type= null){
        $this->idProperty = $idProperty;
        $this->name = $name;
        $this->type = $type;
    }
}
?>