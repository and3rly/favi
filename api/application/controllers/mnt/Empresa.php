<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empresa extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mnt/Empresa_model');
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

}

/* End of file Empresa.php */
/* Location: ./application/controllers/Empresa.php */