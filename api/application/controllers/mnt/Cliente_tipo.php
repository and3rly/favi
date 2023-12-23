<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cliente_tipo extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mnt/Cliente_tipo_model');
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar(){

		$data = [
			'lista'=> $this->Cliente_tipo_model->buscar($_GET)
		];

		$this->output->set_output(json_encode($data));
	}


	public function guardar($id="") 
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = (object) $_POST;

			if (verPropiedad($datos, "nombre")) {

				$cliente_tipo = new Cliente_tipo_model($id);

				if ($cliente_tipo->existe($datos)) {
					$data['mensaje'] = "Los datos ya se encuentran almacenados.";
				} else {

					if ($cliente_tipo->guardar($datos)) {
						$data['exito']   = 1;
						$data['mensaje'] = empty($id) ? "Registro guardado con éxito.":"Registro actualizado.";
						$data['linea']   = $cliente_tipo->buscar(['id' => $cliente_tipo->getPK(), 'uno' => true]);
					} else {
						$data['mensaje'] = $cliente_tipo->getMensaje();
					}
				}
			} else {
				$data['mensaje'] = "Complete todos los campos marcados con *.";
			}
		} else {
			$data['menasje'] = "Error en el envio de datos";
		}

		$this->output->set_output(json_encode($data));
	}
}
