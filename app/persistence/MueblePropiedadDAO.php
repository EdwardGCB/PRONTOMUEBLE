<?php
class MueblePropiedadDAO{
    private $descripcion;
    private $mueble;
    private $propiedad;

    public function __construct($descripcion="", $mueble=null, $propiedad=null){
        $this->descripcion = $descripcion;
        $this->mueble = $mueble;
        $this->propiedad = $propiedad;
    }

    public function guardar(){
        return "INSERT INTO propiedadmueble (descripcion, mueble_idmueble, propiedad_idpropiedad) 
                VALUES ('".$this->descripcion."', ".$this->mueble->getIdMueble().", ".$this->propiedad->getIdPropiedad().")
        ";
    }
}
?>