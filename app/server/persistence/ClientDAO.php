<?php
class ClienteDAO{
    private $idPersona;
    private $nombre;
    private $apellido;
    private $correo;
    private $clave;
    private $identificacion;
    private $telefonos;
    private $vendedor;

    public function __construct($idPersona=0, $nombre="", $apellido="", $correo="", $clave="", $identificacion=0, $telefonos=null, $vendedor=null) {
        $this->idPersona = $idPersona;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->identificacion = $identificacion;
        $this->telefonos = $telefonos;
        $this->vendedor = $vendedor;
    }
}
?>