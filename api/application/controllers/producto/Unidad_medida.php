<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unidad_medida extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->set_content_type('application/json');
		$this->load->model(['producto/Unidad_medida_model']);
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar() 
	{
		$data = [
			'lista' => $this->Unidad_medida_model->buscar($_GET)
		];

		$this->output->set_output(json_encode($data)); 
	}

	public function guardar($id="") {
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = json_decode(file_get_contents('php://input'));

			if (verPropiedad($datos, "nombre")) {
				$um = new Unidad_medida_model($id);

				if ($um->existe_um($datos)) {
					$data['mensaje'] = "Ya la unidad de medida que intenta guardar.";
				} else {
					if ($um->guardar($datos)) {
						$data['exito'] = 1;
						$data['mensaje'] = empty($id) ? "Registro guardado con éxito":"Registro actualizado";

						$data['linea'] = $um->buscar(['id' => $um->getPK(), 'uno' => true]);
					} else {
						$data['mensaje'] = $um->getMensaje();
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

/* End of file Unidad_medida.php */
/* Location: ./application/controllers/Uniadad_medida.php */