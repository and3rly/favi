<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Familia_model extends General_model {

	public $nombre;
	public $activo = 1;

	public function __construct($id="")
	{
		parent::__construct();
		$this->setTabla("familia_producto");
		$this->setLlave("id");

		if (!empty($id)) {
			$this->cargar($id);
		}
	}

	public function buscar($args=[])
	{	
		if (elemento($args, 'id')) {
			$this->db->where('id', $args['id']);
		}

		$tmp = $this->db
					->get("$this->_tabla");
					
		return verConsulta($tmp, $args);
	}

	public function existe_fam($args=[]) {
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

/* End of file Familia_producto_model.php */
/* Location: ./application/models/Familia_producto_model.php */