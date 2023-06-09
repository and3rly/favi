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

}

/* End of file Sucursal_model.php */
/* Location: ./application/models/Sucursal_model.php */