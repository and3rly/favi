<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Presentacion extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->set_content_type('application/json');
		$this->load->model(['producto/Presentacion_model']);
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar() 
	{
		$data = [
			'lista' => $this->Presentacion_model->buscar($_GET)
		];

		$this->output->set_output(json_encode($data)); 
	}

	public function guardar($id="") {
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = json_decode(file_get_contents('php://input'));

			if (verPropiedad($datos, "codigo") && 
				verPropiedad($datos, "nombre") && 
				verPropiedad($datos, "factor")) {

				$pres = new Presentacion_model($id);

				if ($pres->existe($datos)) {
					$data['mensaje'] = "Ya existe la presentación que intenta guardar.";
				} else {
					if ($pres->guardar($datos)) {
						$data['exito'] = 1;
						$data['mensaje'] = empty($id) ? "Registro guardado con éxito":"Registro actualizado";

						$data['linea'] = $pres->buscar(['id' => $pres->getPK(), 'uno' => true]);
					} else {
						$data['mensaje'] = $pres->getMensaje();
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

/* End of file Presentacion.php */
/* Location: ./application/controllers/Presentacion.php */