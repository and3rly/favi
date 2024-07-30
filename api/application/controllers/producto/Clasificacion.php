<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clasificacion extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->set_content_type('application/json');
		$this->load->model(['producto/Clasificacion_model']);
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar() 
	{
		$data = [
			'lista' => $this->Clasificacion_model->buscar($_GET)
		];

		$this->output->set_output(json_encode($data)); 
	}

	public function guardar($id="") 
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = json_decode(file_get_contents('php://input'));

			if (verPropiedad($datos, "nombre")) {
				$clas = new Clasificacion_model($id);

				if ($clas->existe_clas($datos)) {
					$data['mensaje'] = "Ya existe la clasificación que esta intentado guardar.";
				} else {
					if ($clas->guardar($datos)) {
						$data['exito'] = 1;
						$data['mensaje'] = empty($id) ? "Registro guardado con éxito.":"Registro actualizado.";

						$data['linea'] = $clas->buscar(['id' => $clas->getPK(), 'uno' => true]);
					} else {
						$data['mensaje'] = $clas->getMensaje();
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

/* End of file Clasificacion.php */
/* Location: ./application/controllers/Clasificacion.php */