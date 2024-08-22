<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Despacho_enc_model extends General_model {

	public $bodega_id = null;
	public $vehiculos_id = null;
	public $pilotos_id = null;
	public $ruta_id = null;
	public $observacion = null;
	public $hora_inicio = null;
	public $hora_fin = null;
	public $marchamo = null;
	public $usuario_agr;
	public $usuario_mod = null;
	public $activo = 1;
	public $tipo_transaccion_id = null;
	public $estado_despacho_id;


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
			$this->db->where("a.id", $args['id']);
		} else {

			if (elemento($args, "bodega_id")) {
				$this->db->where("a.bodega_id", $args['bodega_id']);
			}

			if (elemento($args, 'criterio')) {

				$termino = trim($args['criterio']);

				$campos = [
					'a.observacion'
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
			b.nombre as nombre_bodega,
			c.nombre as nombre_transaccion,
			d.nombre as nombre_estado,
			d.color
		")
		->join("bodega b","b.id = a.bodega_id")
		->join("tipo_transaccion c","c.id = a.tipo_transaccion_id")
		->join("estado_despacho d","d.id = a.estado_despacho_id")
		->order_by("a.fecha_agr", "desc")
		->get("$this->_tabla a");

		return verConsulta($tmp, $args);
	}
}

/* End of file Despacho_enc_model.php */
/* Location: ./application/models/Despacho_enc_model.php */