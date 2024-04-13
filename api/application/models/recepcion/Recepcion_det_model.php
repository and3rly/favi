<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recepcion_det_model extends General_model {

	public $recepcion_enc_id;
	public $codigo_producto;
	public $no_linea;
	public $cantidad_recibida;
	public $nombre_producto;
	public $nombre_presentacion;
	public $nombre_unidad_medida;
	public $nombre_producto_estado;
	public $lote;
	public $fecha_vence;
	public $peso;
	public $peso_minimo;
	public $peso_maximo;
	public $observacion;
	public $costo;
	public $costo_oc;
	public $activo = 1;
	public $producto_bodega_id;
	public $presentacion_producto_id = null;
	public $unidad_medida_id;
	public $estado_producto_id;

	public function __construct($id='')
	{
		parent::__construct();
		$this->setTabla("recepcion_det");
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
		->where('lote', $args->lote)
		->where("fecha_vence", $args->fecha_vence)
		->where("estado_producto_id", $args->estado_producto_id)
		->where("recepcion_enc_id", $args->recepcion_enc_id)
		->where("activo", 1)
		->get("$this->_tabla");


		return $tmp->num_rows() > 0;
	}

	public function existe_oc_rec($args=[])
	{
		$tmp = $this->db
		->where('orden_compra_enc_id', $args['oc'])
		->where('recepcion_enc_id', $args['rec'])
		->get("recepcion_orden");

		return $tmp->num_rows() > 0;
	}

	public function setNoLinea($args=[])
	{
		$tmp = $this->db->select("count(*) + 1 as numero")
		->where("recepcion_enc_id", $args['recepcion'])
		->get("$this->_tabla")
		->row();

		return $tmp->numero;
	}

	public function _buscar($args='')
	{	
		if (elemento($args, 'id')) {
			$this->db->where("a.id", $args['id']);
		} else {
			if (elemento($args, 'recepcion_enc_id')) {
				$this->db->where("a.recepcion_enc_id", $args['recepcion_enc_id']);
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

	public function insert_rec_oc($args = [])
	{
		$this->db->insert('recepcion_orden', $args);

		return $this->db->affected_rows() > 0;
	}

}

/* End of file Recepcion_det_model.php */
/* Location: ./application/models/Recepcion_det_model.php */