<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menubar extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['Menubar_model']);
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar()
	{
		$this->output->set_output(json_encode([
			'lista' => $this->Menubar_model->buscar()
		]));
	}
}

/* End of file Menu.php */
/* Location: ./application/controllers/Menu.php */