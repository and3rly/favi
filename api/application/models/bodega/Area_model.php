<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Area_model extends General_model {

	public $codigo;
	public $descripcion;
	public $largo;
	public $ancho;
	public $alto;
	public $activo = 1;
	public $bodega_id;

	public function __construct($id="")
	{
		parent::__construct();
		$this->setTabla("bodega_area");
		$this->setLlave("id");

		if (!empty($id)) {
			$this->cargar($id);
		}
	}

	public function _buscar($args=[])
	{
		if (elemento($args, 'id')) {
			$this->db->where("a.id", $args['id']);
		}

		if (elemento($args, 'bodega_id')) {
			$this->db->where("a.bodega_id", $args['bodega_id']);
		}

		$tmp = $this->db
					->select("a.*, b.nombre as nombre_bodega")
					->join("bodega b","b.id = a.bodega_id")
					->get("$this->_tabla a");

		return verConsulta($tmp, $args);
	}
}

/* End of file Area_model.php */
/* Location: ./application/models/Area_model.php */