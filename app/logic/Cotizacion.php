<?php
require_once (__DIR__.'../../persistence/Conexion.php');
require(__DIR__.'../../persistence/cotizacionDAO.php');

class Cotizacion{
    private $cantidad;
    private $cliente;
    private $vendedor;
    private $producto;

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

    public function __construct($cantidad = 0, $cliente = null, $vendedor = null, $producto = null){
        $this->cantidad = $cantidad;
        $this->cliente = $cliente;
        $this->vendedor = $vendedor;
        $this->producto = $producto;
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
}
?>