<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sucursal extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['mnt/Sucursal_model']);
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function get_catalogo()
	{
		$data = [
			'catalogo' => [
				'sucursal' => $this->Sucursal_model->buscar($_GET)
			]
		];

		$this->output->set_output(json_encode($data));
	}

}

/* End of file Sucursal.php */
/* Location: ./application/controllers/Sucursal.php */