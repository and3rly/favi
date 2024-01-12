<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_model extends General_model {

	public $titulo;
	public $nombre;
	public $nivel;
	public $padre;
	public $solicita_clave;
	public $icono;
	public $ruta;
	public $activo = 1;

	public function __construct($id="")
	{
		parent::__construct();
		if (!empty($id)) {
			$this->cargar($id);
		}
	}
	
	public function _buscar($args=[])
	{	
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