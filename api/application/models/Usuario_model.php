<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario_model extends General_model {

	public $nombre;
	public $apellido;
	public $usuario;
	public $clave;
	public $telefono = null;
	public $correo = null;
	public $foto = null;
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
		$tmp = $this->db
					->select("a.*,
							c.nombre as rol,
							e.nombre as nsucursal")
					->join("rol_usuario b","b.usuario_id = a.id", "left")
					->join("rol c","c.id = b.rol_id", "left")
					->join("usuario_sucursal d", "d.usuario_id = a.id", "left")
					->join("sucursal e","e.id = d.sucursal_id", "left")
					->get("$this->_tabla a");

		return verConsulta($tmp, $args);
	}

}

/* End of file Usuario_model.php */
/* Location: ./application/models/Usuario_model.php */