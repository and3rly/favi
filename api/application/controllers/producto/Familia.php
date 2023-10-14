<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Familia extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->set_content_type('application/json');
		$this->load->model(['producto/Familia_model']);
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar() 
	{
		$data = [
			'lista' => $this->Familia_model->buscar($_GET)
		];

		$this->output->set_output(json_encode($data)); 
	}

	public function guardar($id="") 
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = json_decode(file_get_contents('php://input'));

			if (verPropiedad($datos, "nombre")) {
				$fam = new Familia_model($id);

				if ($fam->existe_fam($datos)) {
					$data['mensaje'] = "Ya existe la familia que intenta guardar.";
				} else {
					if ($fam->guardar($datos)) {
						$data['exito'] = 1;
						$data['mensaje'] = empty($id) ? "Registro guardado con éxito.":"Registro actualizado.";

						$data['linea'] = $fam->buscar(['id' => $fam->getPK(), 'uno' => true]);
					} else {
						$data['mensaje'] = $fam->getMensaje();
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

/* End of file Familia.php */
/* Location: ./application/controllers/Familia.php */