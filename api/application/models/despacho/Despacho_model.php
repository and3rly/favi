<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Despacho_model extends General_model {

	public $hora_inicio;
	public $hora_fin;
	public $observacion;
	public $marchamo;
	public $usuario_agr;
	public $fecha_agr;
	public $usuario_mod;
	public $fecha_mod;
	public $activo = 1;
	public $vehiculos_id;
	public $bodega_id;
	public $pilotos_id;
	public $ruta_id;
	public $tipo_transaccion_id;
	public $estado;

	public function __construct($id='')
	{
		parent::__construct();
		$this->setTabla("despacho_enc");
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
			b.placa, 
			b.marca, 
			b.modelo, 
			c.nombre as nombre_bodega, 
			d.nombres as nombre_piloto, 
			d.apellidos as apelldiso_piloto,
			e.nombre as nombre_transaccion, 
			r.nombre as nombre_ruta"
		)
		->join("vehiculos b", "b.id = a.vehiculos_id", "left")
		->join("bodega c","c.id = a.bodega_id")
		->join("pilotos d","d.id = a.pilotos_id", "left")
		->join("ruta r","r.id = a.ruta_id", "left")
		->join("tipo_transaccion e","e.id = a.tipo_transaccion_id")
		->order_by("a.id")
		->get("$this->_tabla a");

		return verConsulta($tmp, $args);
	}
}

/* End of file Despacho_model.php */
/* Location: ./application/models/Despacho_model.php */