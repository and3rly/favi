<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cliente_direccion extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['mnt/Cliente_direccion_model']);
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar()
	{
		$data = [
			'lista' => $this->Cliente_direccion_model->_buscar($_GET)
		];

		$this->output->set_output(json_encode($data)); 
		
	}

	public function guardar($id="") 
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = json_decode(file_get_contents('php://input'));
			
			if (verPropiedad($datos, "direccion") &&
				verPropiedad($datos, "cliente_id")) {

				$direccion = new Cliente_direccion_model($id);

				if ($direccion->guardar($datos)) {
					$data['exito'] = 1;
					$data['mensaje'] = empty($id) ? "Registro guardado con éxito.":"Registro actualizado.";

					$data['linea'] = $direccion->_buscar([
						'id' => $direccion->getPK(), 
						'uno' => true
					]);

				} else {
					$data['mensaje'] = $direccion->getMensaje();
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