<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehiculos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mnt/Vehiculos_model');
		$this->output->set_content_type('application/json');

		$this->user = $this->session->userdata('usuario');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar(){

		$data = [
			'lista'=> $this->Vehiculos_model->buscar($_GET)
		];

		$this->output->set_output(json_encode($data));
	}


	public function guardar($id="") 
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = (object) $_POST;

			if (verPropiedad($datos, "tipo") && verPropiedad($datos, "placa") ) {

				$Vehiculos = new Vehiculos_model($id);

				if (empty($id)) {
					$datos->usuario_agr = $this->user['id'];
					$datos->fecha_agr = Hoy(true);
				}

				if ($Vehiculos->existe($datos)) {
					$data['mensaje'] = "Los datos ya se encuentran almacenados.";
				} else {

					if ($Vehiculos->guardar($datos)) {
						$data['exito']   = 1;
						$data['mensaje'] = empty($id) ? "Registro guardado con éxito.":"Registro actualizado.";
						$data['linea']   = $Vehiculos->buscar(['id' => $Vehiculos->getPK(), 'uno' => true]);
					} else {
						$data['mensaje'] = $Vehiculos->getMensaje();
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
