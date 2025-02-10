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
}
?>