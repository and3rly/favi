<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedido_model extends General_model {

	public $cliente_id;
	public $bodega_id;
	public $tipo_transaccion_id;
	public $pedido_tipo_id;
	public $fecha_pedido;
	public $hora_inicio;
	public $hora_fin;
	public $observacion;
	public $estado;
	public $no_documento;
	public $local;
	public $fecha_entrega;
	public $referencia;
	public $motivo_anulacion_pedido_id;
	public $activo = 1;

	public function __construct($id='')
	{
		parent::__construct();
		$this->setTabla("pedido_enc");
		$this->setLlave("id");

		if (!empty($id)) {
			$this->cargar($id);
		}	
	}

	public function _buscar($args=[])
	{
		if (elemento($args, "id")) {
			$this->db->where("a.id", $args['id']);
		} else {

			if (elemento($args, "bodega_id")) {
				$this->db->where("a.bodega_id", $args['bodega_id']);
			}

			if (elemento($args, 'criterio')) {

				$termino = trim($args['criterio']);

				$campos = [
					'a.observacion',
					'a.no_documento'
				];

				$where = implode(" like '%{$termino}%' or ", $campos);

				$this->db->where("({$where} like '%{$termino}%')", null, false);

			} else {
				if (elemento($args, 'fdel') && 
					elemento($args, 'fal')) {
					$this->db
					->where("CAST(a.fecha_agr as date) >=", $args["fdel"])
					->where("CAST(a.fecha_agr as date) <=", $args["fal"]);
				}
			}
		}

		$tmp = $this->db
		->select("a.*, 
			b.nombre,
			c.nombre as nombre_bodega, 
			d.nombre as nombre_pedido_tipo, 
			d.descripcion as desc_pedido_tipo,
			d.reservar_stock,
			e.nombre as nombre_transaccion"
		)
		->join("motivo_anulacion_pedido b", "b.id = a.motivo_anulacion_pedido_id", "left")
		->join("bodega c","c.id = a.bodega_id")
		->join("pedido_tipo d","d.id = a.pedido_tipo_id", "left")
		->join("tipo_transaccion e","e.id = a.tipo_transaccion_id")
		->order_by("a.id")
		->get("$this->_tabla a");

		return verConsulta($tmp, $args);
	}
}

/* End of file Pedido_model.php */
/* Location: ./application/models/Pedido_model.php */