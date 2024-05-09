<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Despacho_det_model extends General_model {

	public $despacho_enc_id;
	public $codigo_producto;
	public $no_linea;
	public $cantidad_despachada;
	public $peso_despachado;
	public $nombre_producto;
	public $nombre_presentacion;
	public $nombre_unidad_medida;
	public $nombre_estado_producto;
	public $activo = 1;
	public $producto_bodega_id;
	public $presentacion_producto_id = null;
	public $unidad_medida_id;
	public $estado_producto_id;
	public $pedido_enc_id;
	public $pedido_det_id;

	public function __construct($id='')
	{
		parent::__construct();
		$this->setTabla("despacho_det");
		$this->setLlave("id");

		if (!empty($id)) {
			$this->cargar($id);
		}	
	}

	public function existe($args=[])
	{
		if ($this->getPK()) {
			$this->db->where('id <> ', $this->getPK());
		}

		$tmp = $this->db
		->where('presentacion_producto_id', $args->presentacion_producto_id)
		->where('producto_bodega_id', $args->producto_bodega_id)
		->where("estado_producto_id", $args->estado_producto_id)
		->where("despacho_enc_id", $args->despacho_enc_id)
		->where("activo", 1)
		->get("$this->_tabla");


		return $tmp->num_rows() > 0;
	}

	public function existe_pedido_despacho($args=[])
	{
		$tmp = $this->db
		->where('pedido_enc_id', $args['oc'])
		->where('pedido_det_id', $args['det'])
		->where('despacho_enc_id', $args['rec'])
		->get("despacho_det");

		return $tmp->num_rows() > 0;
	}

	public function setNoLinea($args=[])
	{
		$tmp = $this->db->select("count(*) + 1 as numero")
		->where("despacho_enc_id", $args['despacho'])
		->get("$this->_tabla")
		->row();

		return $tmp->numero;
	}

	public function _buscar($args='')
	{	
		if (elemento($args, 'id')) {
			$this->db->where("a.id", $args['id']);
		} else {
			if (elemento($args, 'despacho_enc_id')) {
				$this->db->where("a.despacho_enc_id", $args['despacho_enc_id']);
			}
		}

		$tmp = $this->db
		->select("a.*, c.id as id_producto, c.control_vence")
		->join("producto_bodega b","b.id = a.producto_bodega_id")
		->join("producto c","c.id = b.producto_id")
		->where("a.activo", 1)
		->order_by("a.no_linea")
		->get("$this->_tabla a");

		return verConsulta($tmp, $args);
	}

}

/* End of file Despacho_det_model.php */
/* Location: ./application/models/Despacho_det_model.php */