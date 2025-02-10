<?php
class PropiedadDAO{
    private $idPropiedad;
    private $nombre;
    private $tipo;

    public function __construct($idPropiedad=0, $nombre="", $tipo=null) {
        $this->idPropiedad = $idPropiedad;
        $this->nombre = $nombre;
        $this->tipo = $tipo;
    }
}
?>