<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tipo_producto_model extends General_model {

	public $nombre;
	public $activo = 1;

	public function __construct($id="")
	{
		parent::__construct();
		if (!empty($id)) {
			$this->cargar($id);
		}
	}

	public function buscar($args=[])
	{	
		if (elemento($args, 'id')) {
			$this->db->where('id', $args['id']);
		}

		if (isset($args['activo'])) {
			$this->db->where('activo', $args['activo']);
		} else {
			$this->db->where('activo', 1);
		}

		$tmp = $this->db
					->get("$this->_tabla");
					
		return verConsulta($tmp, $args);
	}

	public function existe_tipo($args=[]) {
		if ($this->getPK()) {
			$this->db->where("id <>", $this->getPK());
		}

		$tmp = $this->db
					->where("nombre", $args->nombre)
					->get("$this->_tabla");

		if ($tmp->num_rows() > 0) {
			return true;
		}

		return false;
	}
}

/* End of file Tipo_producto_model.php */
/* Location: ./application/models/Tipo_producto_model.php */