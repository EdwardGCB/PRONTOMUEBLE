<?php
class ProductDAO{
    private $idProduct;
    private $name;
    private $description;
    private $type;
    private $properties;

    public function __construct($idProduct=0, $name="", $description="", $type=null, $properties=null) {
        $this->idProduct = $idProduct;
        $this->name = $name;
        $this->description = $description;
        $this->type = $type;
        $this->properties = $properties;
    }
}
?>