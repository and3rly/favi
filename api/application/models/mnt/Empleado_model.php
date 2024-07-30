<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empleado_model extends General_model {

	public $codigo;
	public $nombre;
    public $apellido;
    
	public $telefono;
	public $direccion;
	public $correo ;
    public $fecha_nac ;
	public $activo = 1;
	public $usuario_id;

	public function __construct($id="")
	{
		parent::__construct();
		if (!empty($id)) {
			$this->cargar($id);
		}
	}

	public function existe($args=[])
	{
		if ($this->getPK()) {
			$this->db->where("id <> ", $this->getPK());
		}

		$tmp = $this->db
		->where("nombre", $args->nombre)
		->where("apellido", $args->apellido)
		->where("activo",1)
		->get("$this->_tabla");

		if ($tmp->num_rows() > 0) {
			return true;
		}

		return false;
	}

	public function buscar($args=[])
	{

		if (elemento($args, 'id')) {
			$this->db->where("a.id", $args['id']);
		}

		$tmp = $this->db
		->select("a.*")
        ->where('a.activo', 1)
		->get('empleado a');

		return verConsulta($tmp, $args);
	}
}
