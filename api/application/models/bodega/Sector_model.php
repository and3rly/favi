<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sector_model extends General_model {

	public $codigo;
	public $descripcion;
	public $largo = 0;
	public $ancho = 0;
	public $alto = 0;
	public $activo = 1;
	public $bodega_id;
	public $bodega_area_id;

	public function __construct($id="")
	{
		parent::__construct();
		$this->setTabla("bodega_sector");
		$this->setLlave("id");

		if (!empty($id)) {
			$this->cargar($id);
		}
	}

	public function _buscar($args=[])
	{
		if (elemento($args, 'id')) {
			$this->db->where("a.id", $args['id']);
		}

		if (elemento($args, 'bodega_id')) {
			$this->db->where("a.bodega_id", $args['bodega_id']);
		}

		if (elemento($args, 'bodega_area_id')) {
			$this->db->where("a.bodega_area_id", $args['bodega_area_id']);
		}

		$tmp = $this->db
		->select("a.*, 
				b.nombre as nombre_bodega,
				c.codigo as codigo_area,
				c.descripcion as nombre_area")
		->join("bodega b","b.id = a.bodega_id")
		->join("bodega_area c","c.id = a.bodega_area_id")
		->where('a.activo', 1)
		->get("$this->_tabla a");

		return verConsulta($tmp, $args);
	}
}

/* End of file Area_model.php */
/* Location: ./application/models/Area_model.php */