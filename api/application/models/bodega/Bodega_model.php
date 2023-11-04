<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bodega_model extends General_model {

	public $codigo;
	public $nombre;
	public $direccion = null;
	public $telefono = null;
	public $correo = null;
	public $encargado = null;
	public $largo = null;
	public $ancho = null;
	public $alto = null;
	public $activo = 1;
	public $empresa_id;

	public function __construct($id="")
	{
		parent::__construct();
		if (!empty($id)) {
			$this->cargar($id);
		}
	}

}

/* End of file Bodega_model.php */
/* Location: ./application/models/Bodega_model.php */