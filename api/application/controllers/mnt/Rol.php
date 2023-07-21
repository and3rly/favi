<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rol extends CI_Controller {

	public function __construct()
	{
		$this->load->model(['mnt/Rol_model']);
		parent::__construct();
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}
}

/* End of file Rol.php */
/* Location: ./application/controllers/Rol.php */