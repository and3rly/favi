<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalogo_model extends General_model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_usuario_sucursal($args=[])
	{
		if (elemento($args, 'usuario_id')) {
			$this->db->where('usuario_id', $args['usuario_id']);
		}

		$tmp = $this->db
					->where('activo', 1)
					->get('usuario_sucursal');

		return verConsulta($tmp, $args);
	}

	public function ver_usuario_rol($args=[])
	{	
		if (elemento($args, 'usuario_id')) {
			$this->db->where('a.usuario_id', $args['usuario_id']);
		}

		if (elemento($args, 'rol_id')) {
			$this->db->where('a.rol_id', $args['rol_id']);
		}

		if (elemento($args, 'id')) {
			$this->db->where('a.id', $args['id']);
		}

		if (isset($args['activo'])) {
			$this->db->where('a.activo', $args['activo']);
		} else {
			$this->db->where('a.activo', 1);
		}

		$tmp = $this->db
					->select("a.*, b.nombre as nrol")
					->join("rol b", "b.id = a.rol_id")
					->get('rol_usuario a');

		return verConsulta($tmp, $args);
	}

	public function ver_sucursal($args=[])
	{
		$tmp = $this->db
					->where('activo', 1)
					->get('sucursal');

		return verConsulta($tmp, $args);
	}

	public function ver_rol($args=[])
	{	
		$tmp = $this->db
					->where('activo', 1)
					->get('rol');

		return verConsulta($tmp, $args);
	}

}

/* End of file Catalogo_model.php */
/* Location: ./application/models/Catalogo_model.php */