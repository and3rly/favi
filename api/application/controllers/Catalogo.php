<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogo extends CI_Controller {

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function ver_lista()
	{	
		$lista = [];
		$args = [];
		
		if (array_key_exists('args', $_GET)) {
			$args = json_decode(json_encode($_GET["args"]), true);
		}

		foreach ($_GET["lista"] as $key => $value) {
			$tmp = "ver_{$value}";
			$ar = elemento($args, $value, []);

			$lista[$value] = $this->catalogo->$tmp($ar);
		}
		
		$this->output->set_output(json_encode([
			'exito' => true,
			'lista' => $lista
		]));
	}
}

/* End of file Catalogo.php */
/* Location: ./application/controllers/Catalogo.php */