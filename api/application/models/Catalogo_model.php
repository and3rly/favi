<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalogo_model extends General_model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function ver_usuario_sucursal($args=[])
	{	
		if (elemento($args, 'id')) {
			$this->db->where('a.id', $args['id']);
		}

		if (elemento($args, 'usuario_id')) {
			$this->db->where('a.usuario_id', $args['usuario_id']);
		}

		if (elemento($args, 'sucursal_id')) {
			$this->db->where('a.sucursal_id', $args['sucursal_id']);
		}

		if (isset($args['activo'])) {
			$this->db->where('a.activo', $args['activo']);
		} else {
			$this->db->where('a.activo', 1);
		}

		$tmp = $this->db
					->select("a.*, b.nombre as nsucursal, b.empresa_id")
					->join("sucursal b","b.id = a.sucursal_id")
					->get('usuario_sucursal a');

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

	public function ver_empresa($args=[])
	{
		$tmp = $this->db
					->where('activo', 1)
					->get('empresa');

		return verConsulta($tmp, $args);
	}

	public function ver_rol($args=[])
	{	
		$tmp = $this->db
					->where('activo', 1)
					->get('rol');

		return verConsulta($tmp, $args);
	}

	public function ver_um($args=[])
	{	
		$tmp = $this->db
					->where('activo', 1)
					->get('unidad_medida');

		return verConsulta($tmp, $args);
	}

	public function ver_marca($args=[])
	{	
		$tmp = $this->db
					->where('activo', 1)
					->get('marca_producto');

		return verConsulta($tmp, $args);
	}

	public function ver_clasificacion($args=[])
	{	
		$tmp = $this->db
					->where('activo', 1)
					->get('clasificacion_producto');

		return verConsulta($tmp, $args);
	}

	public function ver_estado($args=[])
	{	
		$tmp = $this->db
					->where('activo', 1)
					->get('estado_producto');

		return verConsulta($tmp, $args);
	}

	public function ver_tipo($args=[])
	{	
		$tmp = $this->db
					->where('activo', 1)
					->get('tipo_producto');

		return verConsulta($tmp, $args);
	}

	public function ver_familia($args=[])
	{	
		$tmp = $this->db
					->where('activo', 1)
					->get('familia_producto');

		return verConsulta($tmp, $args);
	}

	public function ver_presentacion($args=[])
	{	
		$tmp = $this->db
					->where('activo', 1)
					->get('presentacion_producto');

		return verConsulta($tmp, $args);
	}

}

/* End of file Catalogo_model.php */
/* Location: ./application/models/Catalogo_model.php */