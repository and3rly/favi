<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario_model extends General_model {

	public $nombre;
	public $apellido;
	public $usuario;
	public $clave;
	public $telefono = null;
	public $correo = null;
	public $foto = null;
	public $foto_enlace = null;
	public $vence_clave = null;
	public $fecha_clave_vence = null;
	public $fecha_anulado = null;
	public $activo = 1;

	public function __construct($id="")
	{
		parent::__construct();
		if (!empty($id)) {
			$this->cargar($id);
		}
	}

	public function login($args=[])
	{
		$clave = $args['clave'];

		$tmp = $this->db
		->where('usuario', $args['usuario'])
		->where('clave', "md5('{$clave}')", false)
		->where('activo', 1)
		->get('usuario');

		if ($tmp->num_rows() > 0) {
			$tmp = $tmp->row();

			$this->cargar($tmp->id);
			return true;
		}

	}

	public function buscar($args=[])
	{

		if (elemento($args, 'id')) {
			$this->db->where("a.id", $args['id']);
		}

		$tmp = $this->db
					->select("a.*")
					//->join("rol_usuario b","b.usuario_id = a.id", "left")
					//->join("rol c","c.id = b.rol_id", "left")
					//->join("usuario_sucursal d", "d.usuario_id = a.id", "left")
					//->join("sucursal e","e.id = d.sucursal_id", "left")
					//->where("b.activo", 1)
					->where("a.activo", 1)
					->get("usuario a");

		return verConsulta($tmp, $args);
	}

	public function existe($args=[]) {
		if ($this->getPK()) {
			$this->db->where("id <>", $this->getPK());
		}

		$tmp = $this->db
					->where("usuario", $args->usuario)
					->get("$this->_tabla");

		if ($tmp->num_rows() > 0) {
			return true;
		}

		return false;
	}
}

/* End of file Usuario_model.php */
/* Location: ./application/models/Usuario_model.php */