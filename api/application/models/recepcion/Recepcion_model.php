<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recepcion_model extends General_model {

	public $fecha_recepcion;
	public $hora_inicio;
	public $hora_fin;
	public $observacion;
	public $no_guia;
	public $anulada = 0;
	public $ingresa_stock = 0;
	public $no_marchamo;
	public $usuario_agr;
	public $fecha_agr;
	public $usuario_mod;
	public $fecha_mod;
	public $activo = 1;
	public $vehiculos_id;
	public $bodega_id;
	public $pilotos_id;
	public $tipo_transaccion_id;
	public $estado_recepcion_id;
	public $recepcion_tipo_id;

	public function __construct($id='')
	{
		parent::__construct();
		$this->setTabla("recepcion_enc");
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
					'a.no_guia'
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
			f.nombre as nombre_estado,
			f.color as nombre_color,
			g.ingresa_productos"
		)
		->join("vehiculos b", "b.id = a.vehiculos_id", "left")
		->join("bodega c","c.id = a.bodega_id")
		->join("pilotos d","d.id = a.pilotos_id", "left")
		->join("tipo_transaccion e","e.id = a.tipo_transaccion_id")
		->join("estado_recepcion f","f.id = a.estado_recepcion_id")
		->join("recepcion_tipo g","g.id = a.recepcion_tipo_id", "left")
		->order_by("a.id")
		->get("$this->_tabla a");

		return verConsulta($tmp, $args);
	}
}

/* End of file Recepcion_model.php */
/* Location: ./application/models/Recepcion_model.php */