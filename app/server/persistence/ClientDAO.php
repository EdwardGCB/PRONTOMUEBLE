<?php
require_once ("Conexion.php");

class ClienteDAO{
    private $conexion;
    private $idPersona;
    private $nombre;
    private $apellido;
    private $correo;
    private $clave;
    private $identificacion;
    private $telefonos;
    private $dateInit;
    private $vendedor;
    

    public function __construct($idPersona=0, $nombre="", $apellido="", $correo="", $clave="", $identificacion=0, $telefonos=null,$dateInit="", $vendedor="") {
        $this->idPersona = $idPersona;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->identificacion = $identificacion;
        $this->telefonos = $telefonos;
        $this->dateInit = $dateInit;
        $this->vendedor = $vendedor;
        $this->conexion = new Conexion();
    }

     // Método para obtener clientes desde la base de datos
     public function obtenerClientes() {
        $this->conexion->abrirConexion();
        $query = "SELECT idPersona, nombre, apellido, correo, identificacion, fechaCreacion, vendedor_idVendedor FROM cliente"; 
        $resultado = $this->conexion->ejecutarConsulta($query);

        $clientes = [];

        while ($fila = $resultado->fetch_assoc()) {
            $clientes[] = new Client(
                $fila['idPersona'],
                $fila['nombre'],
                $fila['apellido'],
                $fila['correo'],
                $fila['identificacion'],
                $fila['fechaCreacion'],
                $fila['vendedor_idVendedor']
            );
        }

        $this->conexion->cerrarConexion();
        return $clientes;
    }
}
?>