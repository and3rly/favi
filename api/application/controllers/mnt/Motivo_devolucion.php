<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Motivo_devolucion extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mnt/Motivo_devolucion_model');
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar(){

		$data = [
			'lista'=> $this->Motivo_devolucion_model->buscar($_GET)
		];

		$this->output->set_output(json_encode($data));
	}


	public function guardar($id="") 
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = (object) $_POST;

			if (verPropiedad($datos, "nombre")) {

				$Motivo_devolucion = new Motivo_devolucion_model($id);

				if ($Motivo_devolucion->existe($datos)) {
					$data['mensaje'] = "Los datos ya se encuentran almacenados.";
				} else {

					if ($Motivo_devolucion->guardar($datos)) {
						$data['exito']   = 1;
						$data['mensaje'] = empty($id) ? "Registro guardado con éxito.":"Registro actualizado.";
						$data['linea']   = $Motivo_devolucion->buscar(['id' => $Motivo_devolucion->getPK(), 'uno' => true]);
					} else {
						$data['mensaje'] = $Motivo_devolucion->getMensaje();
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


/* End of file Motivo_devolucion.php */
/* Location: ./application/controllers/Motivo_devolucion.php */