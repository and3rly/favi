<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bodega_model extends General_model {

	public $codigo;
	public $nombre;
	public $direccion = null;
	public $telefono = null;
	public $correo = null;
	public $encargado = null;
	public $largo = null;
	public $ancho = null;
	public $alto = null;
	public $activo = 1;
	public $empresa_id;

	public function __construct($id="")
	{
		parent::__construct();
		if (!empty($id)) {
			$this->cargar($id);
		}
	}

	public function existe($args=[]) {
		if ($this->getPK()) {
			$this->db->where("id <>", $this->getPK());
		}

		$tmp = $this->db
					->where("codigo", $args->codigo)
					->where("nombre", $args->nombre)
					->where("empresa_id", $args->empresa_id)
					->where("activo", 1)
					->get("$this->_tabla");

		if ($tmp->num_rows() > 0) {
			return true;
		}

		return false;
	}

	public function _buscar($args=[])
	{
		if (elemento($args, 'id')) {
			$this->db->where("a.id", $args['id']);
		}

		if (isset($args['activo'])) {
			$this->db->where('a.activo', $args['activo']);
		} else {
			$this->db->where('a.activo', 1);
		}

		$tmp = $this->db
					->select("a.*, b.nombre as nempresa")
					->join("empresa b","b.id = a.empresa_id")
					->get("$this->_tabla a");

		return verConsulta($tmp, $args);
	}

}

/* End of file Bodega_model.php */
/* Location: ./application/models/Bodega_model.php */