<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ubicacion_model extends General_model {

	public $codigo;
	public $descripcion;
	public $largo = 0;
	public $ancho = 0;
	public $alto = 0;
	public $activa = 1;
	public $bodega_id;
	public $bodega_area_id;
	public $bodega_sector_id;
	public $bodega_tramo_id;
	public $rotacion_id;
	public $nivel = null;
	public $danado = 0;
	public $bloqueada = 0;
	public $virtual = 0;
	public $ubicacion_picking = 0;
	public $ubicacion_recepcion = 0;
	public $ubicacion_despacho = 0;
	public $ubicacion_merma = 0;

	public function __construct($id="")
	{
		parent::__construct();
		$this->setTabla("bodega_ubicacion");
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
				c.descripcion as nombre_area,
				d.codigo as codigo_sector,
				d.descripcion as nombre_sector,
				e.codigo as codigo_tramo,
				e.descripcion as nombre_tramo,
				f.nombre as nombre_rotacion")
		->join("bodega b","b.id = a.bodega_id")
		->join("bodega_area c","c.id = a.bodega_area_id")
		->join("bodega_sector d","d.id = a.bodega_sector_id")
		->join("bodega_tramo e","e.id = a.bodega_tramo_id")
		->join("rotacion f","f.id = a.rotacion_id")
		->where('a.activa', 1)
		->get("$this->_tabla a");

		return verConsulta($tmp, $args);
	}
}

/* End of file Area_model.php */
/* Location: ./application/models/Area_model.php */