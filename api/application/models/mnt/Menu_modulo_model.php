<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_modulo_model extends General_model {

	public $nombre;
	public $icono;
	public $url;
	public $activo = 1;
	public $modulo_id;

	public function __construct($id="")
	{
		parent::__construct();
		if (!empty($id)) {
			$this->cargar($id);
		}
	}

	public function _buscar($args=[])
	{	
		if (elemento($args, 'modulo')) {
			$this->db->where('modulo_id', $args['modulo']);
		}

		if (elemento($args, 'id')) {
			$this->db->where('id', $args['id']);
		}
		
		$tmp = $this->db
		->where("activo", 1)
		->get("menu_modulo");

		return verConsulta($tmp, $args);
	}

}

/* End of file Menu_modulo_model.php */
/* Location: ./application/models/Menu_modulo_model.php */