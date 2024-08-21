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

}

/* End of file Principal.php */
/* Location: ./application/controllers/Principal.php */