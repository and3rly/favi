<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Familia_model extends General_model {

	public $nombre;
	public $activo = 1;

	public function __construct($id="")
	{
		parent::__construct();
		if (!empty($id)) {
			$this->cargar($id);
		}
	}

}

/* End of file Familia_model.php */
/* Location: ./application/models/Familia_producto_model.php */