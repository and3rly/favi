<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Despacho_det_model extends General_model {

	public $despacho_enc_id;
	public $no_linea;
	public $codigo_producto = null;
	public $nombre_producto = null;
	public $nombre_estado_producto = null;
	public $cantidad_despachada = null;
	public $peso_despachado = null;
	public $usuario_agr;
	public $usuario_mod = null;
	public $fecha_mod = null;
	public $activo = 1;
	public $pedido_enc_id;
	public $pedido_det_id;
	public $producto_bodega_id;
	public $presentacion_producto_id;
	public $unidad_medida_id;
	public $estado_producto_id;
	public $total;

	public function __construct($id="")
	{
		parent::__construct();
		
		if (!empty($id)) {
			$this->cargar($id);
		}
	}

	public function _buscar($args=[])
	{
		if (elemento($args, "id")) {
			$this->db->where("a.id", $args["id"]);
		} else {
			
			if (elemento($args, "despacho_enc_id")) {
				$this->db->where("a.despacho_enc_id", $args["despacho_enc_id"]);
			}
		}

		$tmp = $this->db
		->select("a.*,
			b.nombre as nombre_um,
			c.precio,
			c.total,
			d.telefono"
		)
		->join("unidad_medida b", "a.unidad_medida_id = b.id", "left")
		->join("pedido_det c", "a.pedido_det_id = c.id", "left")
		->join("pedido_enc d", "c.pedido_enc_id = d.id", "left")
		->where("a.activo", 1)
		->order_by("a.no_linea")
		->get("$this->_tabla a");

		return verConsulta($tmp, $args);
	}

	public function actCantPedDet($args=[])
	{
		$this->db
		->set("cantidad_despachada", $args["cantidad"])
		->where("id", $args['pedido_det'])
		->update("pedido_det");

		return $this->db->affected_rows() > 0;
	}
}

/* End of file Despacho_det_model.php */
/* Location: ./application/models/Despacho_det_model.php */