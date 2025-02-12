<?php
class Cliente extends Persona
{
    private $fecha_ini;
    private $asesor;

    private $telefonos;

    public function getFecha_ini()
    {
        return $this->fecha_ini;
    }
    public function setFecha_ini($fecha_ini)
    {
        $this->fecha_ini = $fecha_ini;
    }
    public function getAsesor()
    {
        return $this->asesor;
    }
    public function setAsesor($asesor)
    {
        $this->asesor = $asesor;
    }
    public function getTelefonos()
    {
        return $this->telefonos;
    }
    public function setTelefonos($telefonos)
    {
        $this->telefonos = $telefonos;
    }

    public function __construct($idPersona = 0, $nombres = "", $apellidos = "", $identificacion = 0, $img = "", $correo = "", $fecha_ini = "", $asesor = null, $telefonos = null)
    {
        parent::__construct($idPersona, $nombres, $apellidos, $identificacion, $img, $correo);
        $this->fecha_ini = $fecha_ini;
        $this->asesor = $asesor;
        $this->telefonos = $telefonos;
    }

    public function crearCliente()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $clienteDAO = new ClienteDAO(null, $this->nombres, $this->apellidos, $this->identificacion, $this->img, $this->fecha_ini, $this->asesor, $this->telefonos);
        $conexion->ejecutarConsulta($clienteDAO->crearCliente());
        $this->idPersona = $conexion->obtenerLlaveAutonumerica();
        $conexion->cerrarConexion();
    }

    public function consultarCliente()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $clienteDAO = new ClienteDAO($this->idPersona);
        $conexion->ejecutarConsulta($clienteDAO->consultarCliente());
        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        } else {
            $registro = $conexion->siguienteRegistro();
            $this->nombres = $registro[0];
            $this->apellidos = $registro[1];
            $this->identificacion = $registro[2];
            $this->img = $registro[3];
            $this->fecha_ini = $registro[4];
            $this->correo = $registro[5];
            $asesor = new Vendedor($registro[6]);
            $this->asesor = $asesor->consultarPorId();
            $telefono = new Telefono($registro[0], "Cliente");
            $this->telefonos = $telefono->consultarTelefonos();
            $conexion->cerrarConexion();
            return true;
        }
    }

    public function actualizarCliente()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $clienteDAO = new ClienteDAO($this->idPersona, $this->nombres, $this->apellidos, $this->identificacion, $this->img, $this->fecha_ini, $this->asesor, $this->telefonos);
        $conexion->ejecutarConsulta($clienteDAO->actualizarCliente());
        $conexion->cerrarConexion();
    }

    public function consultarTodosClientes()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $clienteDAO = new ClienteDAO();
        $conexion->ejecutarConsulta($clienteDAO->consultarTodosClientes());
        $clientes = array();
        $asesores = array();
        while (($registro = $conexion->siguienteRegistro()) != null) {
            $asesor = null;
            if (array_key_exists($registro[6], $asesores)) {
                $asesor = $asesores[$registro[6]];
            } else {
                $asesor = new Vendedor($registro[6]);
                $asesor->consultarPorId();
            }
            $telefono = new Telefono(null,$registro[0]);
            $telefonos = $telefono->consultarNumerosCliente();
            $cliente = new Cliente($registro[0], $registro[1], $registro[2], $registro[3], $registro[4], $registro[5], $asesor, $telefonos);
            array_push($clientes, $cliente);
        }
        $conexion->cerrarConexion();
        return $clientes;
    }

    public function consultarPorNombre(){
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $clienteDAO = new ClienteDAO(null,$this->nombres);
        $conexion->ejecutarConsulta($clienteDAO->consultarPorNombre());
        $asesores = array();
        $clientes = array();
        while($registro = $conexion->siguienteRegistro()){
            $asesor = null;
            if(array_key_exists($registro[6], $asesores)){
                $asesor = $asesores[$registro[6]];
            } else {
                $asesor = new Vendedor($registro[6]);
                $asesor->consultarPorId();
            }
            $telefono = new Telefono(null,$registro[0]);
            $telefonos = $telefono->consultarNumerosCliente();
            $cliente = new Cliente($registro[0], $registro[1], $registro[2], $registro[3], 
            null,$registro[4], $registro[5], $asesor, $telefonos);
            array_push($clientes, $cliente);
        }
        $conexion->cerrarConexion();
        return $clientes;
    }

    public function guardar(){
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $clienteDAO = new ClienteDAO(null, $this->nombres, $this->apellidos, $this->identificacion, null,$this->correo, $this->fecha_ini, $this->asesor);
        $conexion->ejecutarConsulta($clienteDAO->guardar());
        $this->idPersona = $conexion->obtenerLlaveAutonumerica();
        $conexion->cerrarConexion();
        return $this->idPersona;
    }
}
