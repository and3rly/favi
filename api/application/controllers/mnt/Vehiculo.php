<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehiculo extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mnt/Vehiculo_model');
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar(){

		$data = [
			'lista'=> $this->Vehiculo_model->buscar($_GET)
		];

		$this->output->set_output(json_encode($data));
	}


	public function guardar($id="") 
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = (object) $_POST;

			if (verPropiedad($datos, "placa") && verPropiedad($datos, "activo")) {

				$vehiculo = new Vehiculo_model($id);

				if ($vehiculo->existe($datos)) {
					$data['mensaje'] = "Los datos ya se encuentran almacenados.";
				} else {

					if ($vehiculo->guardar($datos)) {
						$data['exito']   = 1;
						$data['mensaje'] = empty($id) ? "Registro guardado con éxito.":"Registro actualizado.";
						$data['linea']   = $vehiculo->buscar(['id' => $vehiculo->getPK(), 'uno' => true]);
					} else {
						$data['mensaje'] = $vehiculo->getMensaje();
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


/* End of file Ruta.php */
/* Location: ./application/controllers/Ruta.php */