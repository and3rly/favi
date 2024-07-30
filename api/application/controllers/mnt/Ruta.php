<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ruta extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mnt/Ruta_model');
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar(){

		$data = [
			'lista'=> $this->Ruta_model->buscar($_GET)
		];

		$this->output->set_output(json_encode($data));
	}


	public function guardar($id="") 
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = (object) $_POST;

			if (verPropiedad($datos, "codigo") && verPropiedad($datos, "nombre")
				&& verPropiedad($datos, "vendedor")) {

				$ruta = new Ruta_model($id);

				if ($ruta->existe($datos)) {
					$data['mensaje'] = "Los datos ya se encuentran almacenados.";
				} else {

					if ($ruta->guardar($datos)) {
						$data['exito']   = 1;
						$data['mensaje'] = empty($id) ? "Registro guardado con éxito.":"Registro actualizado.";
						$data['linea']   = $ruta->buscar(['id' => $ruta->getPK(), 'uno' => true]);
					} else {
						$data['mensaje'] = $ruta->getMensaje();
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