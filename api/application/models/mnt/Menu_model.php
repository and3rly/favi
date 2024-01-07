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
	
	public function buscar($args=[])
	{

		if (elemento($args, 'id')) {
			$this->db->where("m.id", $args['id']);
		}

		$tmp = $this->db
					->select("m.*, mn.titulo as titulo_padre, mn.nombre as nombre_padre")
					->join("menu mn","m.padre = mn.id", "left")
					->where("m.activo", 1)
					->get("menu m");

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