<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Area extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['bodega/Area_model']);
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar()
	{
		$data = [
			'lista' => $this->Area_model->_buscar($_GET)
		];

		$this->output->set_output(json_encode($data)); 
	}

	public function guardar($id="") 
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = json_decode(file_get_contents('php://input'));
			
			if (verPropiedad($datos, "codigo") &&
				verPropiedad($datos, "descripcion")) {

				$area = new Area_model($id);

				if ($area->guardar($datos)) {
					$data['exito'] = 1;
					$data['mensaje'] = empty($id) ? "Registro guardado con éxito.":"Registro actualizado.";

					$data['linea'] = $area->_buscar([
						'id' => $area->getPK(), 
						'uno' => true
					]);

				} else {
					$data['mensaje'] = $area->getMensaje();
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

/* End of file Area.php */
/* Location: ./application/controllers/Area.php */