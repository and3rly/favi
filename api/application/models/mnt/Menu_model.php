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
			$this->db->where("id", $args['id']);
		}	
		
		$tmp = $this->db
		->where("activo", 1)
		->get("modulo");

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