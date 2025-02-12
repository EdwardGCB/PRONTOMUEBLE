<?php
class TipoDAO{
    private $idTipo;
    private $nombre;

    public function __construct($idTipo=0, $nombre=""){
        $this->idTipo = $idTipo;
        $this->nombre = $nombre;
    }

    public function consultarPorNombre(){
        return "SELECT idTipo, nombre
                FROM tipo
                WHERE nombre LIKE '%".$this->nombre."%'
        ";
    }

    public function consultarPorId(){
        return "SELECT nombre
                FROM tipo
                WHERE idTipo = ".$this->idTipo."
        ";
    }

    public function consultarTodos(){
        return "SELECT idTipo, nombre
                FROM tipo
        ";
    }

    public function guardar(){
        return "INSERT INTO tipo (nombre)
                VALUES ('".$this->nombre."')";
    }
}
?>