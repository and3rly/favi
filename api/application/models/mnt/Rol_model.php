<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rol_model extends General_model {

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
			$this->db->where("r.id", $args['id']);
		}

		$tmp = $this->db
					->select("r.*")
					->where("r.activo", 1)
					->get("rol r");

		return verConsulta($tmp, $args);
	}
	
	public function existe_rol($args=[])
	{	
		if ($this->getPK()) {
			$this->db->where("id <> ", $this->getPk());
		}

		$tmp = $this->db
					->where("nombre", $args['nombre'])
					->get("rol r");

		return $tmp->num_rows() == 0;
	}

}

/* End of file Rol_model.php */
/* Location: ./application/models/Rol_model.php */