<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sucursal_model extends General_model {

	public $nombre;
	public $razon_social = null;
	public $telefono = null;
	public $direccion = null;
	public $encargado = null;
	public $correo = null;
	public $activo = 1;
	public $empresa_id;
	public $usuario_id; 

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
		}
		
		$tmp = $this->db
					->select("a.*, b.nombre as nempresa")
					->join("empresa b","b.id = a.empresa_id")
					->where("a.activo", 1)
					->get("$this->_tabla a");

		return verConsulta($tmp, $args);
	}

	public function existe_sucursal($args=[])
	{	
		if ($this->getPK()) {
			$this->db->where("id <> ", $this->getPK());
		}

		$tmp = $this->db
					->where("nombre", $args['nombre'])
					->where("empresa_id", $args['empresa_id'])
					->where("activo", 1)
					->get("$this->_tabla");

		return $tmp->num_rows() == 0;
	}

}

/* End of file Sucursal_model.php */
/* Location: ./application/models/Sucursal_model.php */