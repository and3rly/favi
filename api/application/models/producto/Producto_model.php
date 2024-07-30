<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Producto_model extends General_model {

	public $codigo;
	public $barra;
	public $nombre;
	public $descripcion;
	public $imagen;
	public $img_enlace;
	public $costo;
	public $peso;
	public $largo;
	public $altura;
	public $anchura;
	public $precio;
	public $control_vence = 0;
	public $existencia_maxima;
	public $existencia_minima;
	public $activo = 1;
	public $unidad_medida_id = null;
	public $marca_producto_id = null;
	public $clasificacion_producto_id = null;
	public $estado_producto_id = null;
	public $tipo_producto_id = null;
	public $familia_producto_id = null;
	public $usuario_agr;

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
			$this->db->where('a.id', $args['id']);
		} else {
			if (isset($args['activo'])) {
				$this->db->where('a.activo', $args['activo']);
			} else {
				$this->db->where('a.activo', 1);
			}
		}

		$tmp = $this->db
		->select("a.*,
			b.nombre as um,
			c.nombre as nmarca,
			d.nombre as nclasificacion,
			e.nombre as nestado,
			e.utilizable, 
			e.danado,
			f.nombre as ntipo,
			h.nombre as nfamilia")
		->join("unidad_medida b","b.id = a.unidad_medida_id","left")
		->join("marca_producto c","c.id = a.marca_producto_id","left")
		->join("clasificacion_producto d","d.id = a.clasificacion_producto_id","left")
		->join("estado_producto e","e.id = a.estado_producto_id","left")
		->join("tipo_producto f","f.id = a.tipo_producto_id","left")
		->join("familia_producto h","h.id = a.familia_producto_id","left")
		->get("$this->_tabla a");
					
		return verConsulta($tmp, $args);
	}

	public function existe($args=[]) {
		if ($this->getPK()) {
			$this->db->where("id <>", $this->getPK());
		}

		$tmp = $this->db
					->where("nombre", $args->nombre)
					->where("codigo", $args->codigo)
					->where("barra", $args->barra)
					->get("$this->_tabla");

		if ($tmp->num_rows() > 0) {
			return true;
		}

		return false;
	}

}

/* End of file Producto_model.php */
/* Location: ./application/models/Producto_model.php */