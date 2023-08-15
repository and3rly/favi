<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Presentacion_model extends General_model {

	public $codigo;
	public $nombre;
	public $factor;
	public $activo = 1;

	public function __construct($id="")
	{
		parent::__construct();
		if (!empty($id)) {
			$this->cargar($id);
		}
	}

}

/* End of file Presentacion_model.php */
/* Location: ./application/models/Presentacion_model.php */