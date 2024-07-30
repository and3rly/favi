<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empresa_model extends General_model {

	public $nombre;
	public $razon_social = null;
	public $representante;
	public $nit;
	public $direccion = null;
	public $telefono = null;
	public $correo = null;
	public $logo = null;
	public $logo_enlance = null;
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
		if (elemento($args,'id')) {
			$this->db->where('a.id',$args['id']);
		}

		$tmp = $this->db->get("$this->_tabla");

		return verConsulta($tmp, $args);
	}

	public function existe($args=[]) {
		if ($this->getPK()) {
			$this->db->where("id <>", $this->getPK());
		}

		$tmp = $this->db
					->where("nit", $args->nit)
					->where("nombre", $args->empresa)
					->where("razon_social", $args->razon_social)
					->where("representante", $args->nit)
					->get("$this->_tabla");

		if ($tmp->num_rows() > 0) {
			return true;
		}

		return false;
	}	

}

/* End of file Empresa_model.php */
/* Location: ./application/models/Empresa_model.php */