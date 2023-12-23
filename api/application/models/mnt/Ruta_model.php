<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ruta_model extends General_model {
	public $codigo;
	public $nombre;
	public $vendedor;
	public $venta;

	public function __construct($id="")
	{
		parent::__construct();
		if (!empty($id)) {				
			$this->cargar($id);
		}		
	}

	public function buscar($args=[])
	{
		if (elemento($args,'id')) {
			$this->db->where('id',$args['id']);
		}

		$tmp = $this->db->get("$this->_tabla");

		return verConsulta($tmp, $args);
	}

	public function existe($args=[]) {
		if ($this->getPK()) {
			$this->db->where("id <>", $this->getPK());
		}

		$tmp = $this->db
					->where("codigo", $args->codigo)
					->where("nombre", $args->nombre)
					->where("vendedor", $args->vendedor)
					->get("$this->_tabla");

		if ($tmp->num_rows() > 0) {
			return true;
		}

		return false;
	}	

}

/* End of file Rutal_model.php */
/* Location: ./application/models/Ruta_model.php */