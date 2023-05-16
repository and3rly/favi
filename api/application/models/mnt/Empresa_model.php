<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empresa_model extends General_model {

	public $nombre;
	public $razon_social = null;
	public $representante;
	public $nit;
	public $direccion = null;
	public $telefono = null;
	public $correo = null;
	public $logo = null;
	public $activo = 1;

	public function __construct($id="")
	{
		parent::__construct();
		if (!empty($id)) {				
			$this->cargar($id);
		}		
	}

}

/* End of file Empresa_model.php */
/* Location: ./application/models/Empresa_model.php */