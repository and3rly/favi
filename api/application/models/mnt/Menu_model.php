<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_model extends General_model {

	public $nombre;
	public $url;
	public $icono;
	public $activo = 1;
	public $titulo = 0;

	public function __construct($id="")
	{
		parent::__construct();
		$this->setTabla("modulo");
		$this->setLlave("id");

		if (!empty($id)) {
			$this->cargar($id);
		}
	}
	
	public function _buscar($args=[])
	{
		if (elemento($args, 'id')) {
			$this->db->where("m.id", $args['id']);
		}

		if (elemento($args, 'rol_id')) {
			$this->db->join("modulo_rol mr", "m.id = mr.modulo_id");
			$this->db->where("mr.rol_id", $args['rol_id']);
			$this->db->where("mr.activo", "1");
		}
		
		$tmp = $this->db
		->select("m.*")
		->where("m.activo", 1)
		->get("modulo m");

		return verConsulta($tmp, $args);
	}
	
	public function existe_menu($args=[])
	{	
		if ($this->getPK()) {
			$this->db->where("m.id <> ", $this->getPk());
		}

		$tmp = $this->db
					->where("m.ruta", $args['ruta'])
					->get("menu m");

		return $tmp->num_rows() == 0;
	}

}

/* End of file Menu_model.php */
/* Location: ./application/models/Menu_model.php */