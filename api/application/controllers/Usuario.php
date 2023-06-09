<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['Usuario_model']);
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar()
	{
		$this->output->set_output(json_encode([
			'lista' => $this->Usuario_model->buscar($_GET)
		]));
	}

	public function guardar($id='')
	{
		$data = ['exito' => 0];

		if ($this->input->method() === 'post') {

			$us = new Usuario_model($id);

			if (elemento($_FILES, 'foto') && 
				elemento($_FILES['foto'], 'tmp_name')) {
				
				$foto = subirArchivo([
					'tmp_name' => $_FILES['foto']['tmp_name'],
					'type'     => $_FILES['foto']['type'],
					'name'     => $_FILES['foto']['name'],
					'carpeta'  => 'perfil'
				]);

			echo "<pre>";
			print_r ($foto);
			echo "</pre>";
			}
		}
	}
}

/* End of file Usuario.php */
/* Location: ./application/controllers/Usuario.php */