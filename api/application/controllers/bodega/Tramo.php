<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tramo extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['bodega/Tramo_model']);
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar()
	{
		$data = [
			'lista' => $this->Tramo_model->_buscar($_GET)
		];

		$this->output->set_output(json_encode($data)); 
	}

	public function guardar($id="") 
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = json_decode(file_get_contents('php://input'));
			
			if (verPropiedad($datos, "codigo") &&
				verPropiedad($datos, "descripcion") &&
				verPropiedad($datos, "bodega_area_id") &&
				verPropiedad($datos, "bodega_sector_id")) {

				$tramo = new Tramo_model($id);

				if ($tramo->guardar($datos)) {
					$data['exito'] = 1;
					$data['mensaje'] = empty($id) ? "Registro guardado con éxito.":"Registro actualizado.";

					$data['linea'] = $tramo->_buscar([
						'id' => $tramo->getPK(), 
						'uno' => true
					]);

				} else {
					$data['mensaje'] = $tramo->getMensaje();
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

/* End of file Sector.php */
/* Location: ./application/controllers/Sector.php */