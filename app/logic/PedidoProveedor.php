<?php
require_once(__DIR__ . '../../persistence/Conexion.php');
require_once(__DIR__ . '../../persistence/PedidoProveedorDAO.php');

class PedidoProveedor
{
    private $cantidadPost;
    private $cantidadPre;
    private $precio;

    private $ganancia;

    private $precioFinal;
    private $proveedor;
    private $mueble;

    public function getCantidadPost()
    {
        return $this->cantidadPost;
    }
    public function setCantidadPost($cantidadPost)
    {
        $this->cantidadPost = $cantidadPost;
    }
    public function getCantidadPre()
    {
        return $this->cantidadPre;
    }
    public function setCantidadPre($cantidadPre)
    {
        $this->cantidadPre = $cantidadPre;
    }
    public function getPrecio()
    {
        return $this->precio;
    }
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }
    public function getGanancia()
    {
        return $this->ganancia;
    }
    public function setGanancia($ganancia)
    {
        $this->ganancia = $ganancia;
    }
    public function getPrecioFinal()
    {
        return $this->precioFinal;
    }
    public function setPrecioFinal($precioFinal)
    {
        $this->precioFinal = $precioFinal;
    }
    public function getProveedor()
    {
        return $this->proveedor;
    }
    public function setProveedor($proveedor)
    {
        $this->proveedor = $proveedor;
    }
    public function getMueble()
    {
        return $this->mueble;
    }
    public function setMueble($mueble)
    {
        $this->mueble = $mueble;
    }
    public function __construct($cantidadPost = 0, $cantidadPre = 0, $precio = 0, $ganancia = 0, $precioFinal = 0, $proveedor = null, $mueble = null)
    {
        $this->cantidadPost = $cantidadPost;
        $this->cantidadPre = $cantidadPre;
        $this->precio = $precio;
        $this->ganancia = $ganancia;
        $this->precioFinal = $precioFinal;
        $this->proveedor = $proveedor;
        $this->mueble = $mueble;
    }

    public function buscarNombreMueble()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $productos = array();
        $proveedores = array();
        $muebles = array();
        $pedidoProveedorDAO = new PedidoProveedorDAO(null, null, null, null, null, null, $this->mueble);
        $conexion->ejecutarConsulta($pedidoProveedorDAO->buscarNombreMueble());
        while ($resultado = $conexion->siguienteRegistro()) {
            if (array_key_exists($resultado[5], $proveedores)) {
                $proveedor = $proveedores[$resultado[5]];
            } else {
                $proveedor = new Proveedor($resultado[5]);
                $proveedor->consultarPorId();
            }
            if (array_key_exists($resultado[6], $muebles)) {
                $mueble = $muebles[$resultado[6]];
            } else {
                $mueble = new Mueble($resultado[6]);
                $mueble->consultarPorId();
            }
            $pedidoProveedor = new PedidoProveedor($resultado[0], $resultado[1], $resultado[2], $resultado[3], 
            $resultado[4], $proveedor, $mueble);
            array_push($productos, $pedidoProveedor);
        }
        $conexion->cerrarConexion();
        return $productos;
    }

    public function guardar(){
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $pedidoProveedorDAO = new PedidoProveedorDAO( $this->cantidadPost, $this->cantidadPre, $this->precio, $this->ganancia, 
        $this->precioFinal, $this->proveedor, $this->mueble);
        $conexion->ejecutarConsulta($pedidoProveedorDAO->guardar());
        $conexion->cerrarConexion();
    }
}
