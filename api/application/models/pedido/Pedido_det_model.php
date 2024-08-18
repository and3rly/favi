<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedido_det_model extends General_model {

	public $pedido_enc_id;
	public $no_linea;
    public $cantidad;
    public $peso;
    public $precio;
    public $cantidad_despachada;
    public $codigo_producto;
    public $nombre_producto;
    public $nombre_presentacion;
    public $nombre_unidad_medida;
    public $nombre_estado_producto;
    public $producto_bodega_id;
    public $presentacion_producto_id;
    public $unidad_medida_id;
    public $estado_producto_id;
    public $activo = 1;
    public $lote;
    public $fecha_vence;
    public $total;

	public function __construct($id='')
	{
		parent::__construct();
		$this->setTabla("pedido_det");
		$this->setLlave("id");

		if (!empty($id)) {
			$this->cargar($id);
		}	
	}

	public function existe($args=[])
	{
		$tmp = $this->db
		->where("pedido_enc_id", $args->pedido_enc_id)
		->where("id", $this->getPK())
		->get("$this->_tabla");

		return $tmp->num_rows() > 0;
	}

	public function ObtenerUltimaLinea($args=[])
	{
		$tmp = $this->db->select("MAX(no_linea) + 1 as numero")
		->where("pedido_enc_id", $args['pedido'])
		->get("$this->_tabla")
		->row();

		return $tmp->numero;
	}

	public function _buscar($args='')
	{	
		if (elemento($args, 'id')) {
			$this->db->where("a.id", $args['id']);
		} else {
			if (elemento($args, 'pedido_enc_id')) {
				$this->db->where("a.pedido_enc_id", $args['pedido_enc_id']);
			}
		}

		$tmp = $this->db
		->select("a.id,
			, a.pedido_enc_id
			, a.no_linea
			, a.cantidad
			, a.peso
			, a.cantidad_despachada
			, a.codigo_producto
			, a.nombre_producto
			, a.nombre_presentacion
			, a.nombre_unidad_medida
			, a.nombre_estado_producto
			, a.producto_bodega_id
			, a.presentacion_producto_id
			, a.unidad_medida_id
			, a.estado_producto_id
			, a.activo
			, a.lote
			, a.fecha_vence
			, a.precio * IFNULL(b.factor, 1) as precio
			, IFNULL(a.total, a.precio * IFNULL(b.factor, 1) * a.cantidad) as total")
		->join('presentacion_producto b', 'a.presentacion_producto_id = b.id', 'left')
		->where('a.activo', 1)
		->order_by("a.no_linea")
		->get("$this->_tabla a");

		return verConsulta($tmp, $args);
	}

	/*public function ObtenerDetalleExistente($args='')
	{	
		$tmp = $this->db
		->select("a.*")
		->where("a.pedido_enc_id", $args->pedido_enc_id)
		->where("a.codigo_producto", $args->codigo_producto)
		->where("a.producto_bodega_id", $args->producto_bodega_id)
		->where("a.presentacion_producto_id", $args->presentacion_producto_id)
		->where("a.unidad_medida_id", $args->unidad_medida_id)
		->where("a.estado_producto_id", $args->estado_producto_id)
		->get("$this->_tabla a");

		return $tmp->num_rows() > 0;
	}*/

	public function ObtenerDetalleExistente($args=[])
	{	
		if(isset($args['datos']->fecha_vence) && !empty($args['datos']->fecha_vence)) {
		    $fecha_vence_obj = DateTime::createFromFormat('Y-m-d H:i:s', $args['datos']->fecha_vence);
		    if ($fecha_vence_obj !== false) {
		        $fecha_vence = $this->db->escape($fecha_vence_obj->format('Y-m-d H:i:s'));
		    } else {
		        $fecha_vence = null;
		    }
		} else {
		    $fecha_vence = null;
		}

		$lote = isset($args['datos']->lote) ? $this->db->escape($args['datos']->lote) : null;

		$condicion = "";

		if ($fecha_vence !== null) {
		    $condicion .= "a.fecha_vence = $fecha_vence";
		} else {
		    $condicion .= "a.fecha_vence IS NULL";
		}

		if ($lote !== null) {
		    $condicion .= " AND a.lote = $lote";
		} else {
		    $condicion .= " AND a.lote IS NULL";
		}

		if (!isset($args['datos']->presentacion_producto_id)) {
			$condicion .= " AND a.presentacion_producto_id IS NULL";
		}else {
			$condicion .= " AND a.presentacion_producto_id = {$args['datos']->presentacion_producto_id}";
		}



		$consulta = $this->db
		->select("a.id")
		->from("$this->_tabla a")
		->where("a.pedido_enc_id", $args['datos']->pedido_enc_id)
		/*->where("a.presentacion_producto_id", $args['datos']->presentacion_producto_id)*/
		->where('a.unidad_medida_id', $args['datos']->unidad_medida_id)
		->where('a.codigo_producto', $args['datos']->codigo_producto)
		->where($condicion)
		->get();

		$resultado = $consulta->result();
		
		return $resultado[0]->id ?? null;
	}

	public function EliminarDetallePedido($id)
	{
		$this->db->delete("$this->_tabla", array('id' => $id));

		if ($this->db->affected_rows() > 0) { 
			return true;
		} else {
			$this->setMensaje("No se elimino el detalle, por favor intente nuevamente.");
			return false;
		}
	}
}

/* End of file Pedido_det_model.php */
/* Location: ./application/models/Pedido_det_model.php */