<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sesion extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

}

/* End of file Sesion.php */
/* Location: ./application/controllers/Sesion.php */