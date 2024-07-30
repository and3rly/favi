<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Presentacion_model extends General_model {

	public $codigo;
	public $nombre;
	public $factor;
	public $producto_id;
	public $activo = 1;

	public function __construct($id="")
	{
		parent::__construct();
		$this->setTabla("presentacion_producto");
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

		if (isset($args['activo'])) {
			$this->db->where('activo', $args['activo']);
		} else {
			$this->db->where('activo', 1);
		}

		if (elemento($args, 'producto')) {
			$this->db->where('producto_id', $args['producto']);
		}

		$tmp = $this->db
					->get("$this->_tabla");
					
		return verConsulta($tmp, $args);
	}

	public function existe($args=[]) 
	{
		if ($this->getPK()) {
			$this->db->where("id <>", $this->getPK());
		}

		$tmp = $this->db
		->where("codigo", $args->codigo)
		->where("factor", $args->factor)
		->where("producto_id", $args->producto_id)
		->get("$this->_tabla");

		if ($tmp->num_rows() > 0) {
			return true;
		}

		return false;
	}

}

/* End of file Presentacion_model.php */
/* Location: ./application/models/Presentacion_model.php */