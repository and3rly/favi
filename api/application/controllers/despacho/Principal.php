<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Principal extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(["despacho/Despacho_enc_model"]);
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		die;
	}

	public function get_datos()
	{
		$data = [
			'cat' => [
				'bodega' => $this->catalogo->ver_bodega()
			]
		];

		$this->output->set_output(json_encode($data)); 
	}

	public function buscar()
	{
		$this->output->set_output(json_encode([]));
	}
}

/* End of file Principal.php */
/* Location: ./application/controllers/Principal.php */