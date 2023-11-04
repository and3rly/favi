<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bodega extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('bodega/Bodega_model');
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar()
	{
		// code...
	}

	public function guardar($id='')
	{
		// code...
	}
}

/* End of file Bodega.php */
/* Location: ./application/controllers/Bodega.php */