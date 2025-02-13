<?php
require_once (__DIR__.'../../persistence/Conexion.php');
require(__DIR__.'../../persistence/cotizacionDAO.php');

class Cotizacion{
    private $cantidad;
    private $cliente;
    private $vendedor;
    private $producto;

    private $proveedor;

    public function getCantidad(){
        return $this->cantidad;
    }
    public function setCantidad($cantidad){
        $this->cantidad = $cantidad;
    }
    public function getCliente(){
        return $this->cliente;
    }
    public function setCliente($cliente){
        $this->cliente = $cliente;
    }
    public function getVendedor(){
        return $this->vendedor;
    }
    public function setVendedor($vendedor){
        $this->vendedor = $vendedor;
    }
    public function getProducto(){
        return $this->producto;
    }
    public function setProducto($producto){
        $this->producto = $producto;
    }
    public function getProveedor(){
        return $this->proveedor;
    }
    public function setProveedor($proveedor){
        $this->proveedor = $proveedor;
    }

    public function __construct($cantidad = 0, $cliente = null, $vendedor = null, $producto = null, $proveedor = null){
        $this->cantidad = $cantidad;
        $this->cliente = $cliente;
        $this->vendedor = $vendedor;
        $this->producto = $producto;
        $this->proveedor = $proveedor;
    }

    public function consultarPorCliente(){
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $productos = array();
        $cotizacionDAO = new CotizacionDAO(null, $this->cliente);
        $conexion->ejecutarConsulta($cotizacionDAO->consultarPorCliente());
        $productos = array();
        while($resultado = $conexion->siguienteRegistro()){
            $producto = null;
            if(array_key_exists($resultado[3], $productos)){
                $producto = $productos[$resultado[3]];
            }else{
                $producto = new Mueble($resultado[3]);
                $producto->consultarPorId();
                $productos[$resultado[5]] = $productos;
            }
            $vendedor = new Vendedor($resultado[2]);
            $cotizacion = new Cotizacion($resultado[0], $this->cliente, $vendedor, $producto);
            array_push($productos, $cotizacion);
        }
        $conexion->cerrarConexion();
    }

    public function guardar(){
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $cotizacionDAO = new CotizacionDAO($this->cantidad, $this->cliente, $this->vendedor, $this->producto, $this->proveedor);
        $conexion->ejecutarConsulta($cotizacionDAO->guardar());
        $conexion->cerrarConexion();
    }

    public function buscarPorNombreCliente(){
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $cotizaciones = array();
        $vendedores = array();
        $cotizacionDAO = new CotizacionDAO(null, $this->cliente);
        $conexion->ejecutarConsulta($cotizacionDAO->buscarPorNombreCliente());
        while($resultado = $conexion->siguienteRegistro()){
            $vendedor = null;
            if(array_key_exists($resultado[2], $vendedores)){
                $vendedor = $vendedores[$resultado[2]];
            } else{
                $vendedor = new Vendedor($resultado[2]);
                $vendedor->consultarPorId();
                $vendedores[$resultado[2]] = $vendedor;
            }
            $telefono = new Telefono(null, $resultado[1]);
            $telefonos = $telefono->consultarNumerosCliente();
            $cliente = new Cliente($resultado[1], null, null, null, null, null, null, null,$telefonos);
            $cliente->consultarPorId();
            $this->cliente = $cliente;
            $cotizacion = new Cotizacion($resultado[0], $this->cliente, $vendedor);
            array_push($cotizaciones, $cotizacion);
        }
        $conexion->cerrarConexion();
        return $cotizaciones;
    }
}
?>