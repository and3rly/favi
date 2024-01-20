<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empleado extends CI_Controller{
			
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mnt/Empleado_model');
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}
	
	public function buscar(){

		$data = [
			'lista'=> $this->Empleado_model->buscar($_GET)
		];

		$this->output->set_output(json_encode($data));
	}

	public function guardar($id='')
	{
		$data =["exito" => 0];
		
		if ($this->input->method() =="post") {
			$datos = (object) $_POST;

			if (verPropiedad($datos,"nombre") && 
				verPropiedad($datos,"apellido")) {

				$empleado = new Empleado_model($id);

				if ($empleado->existe($datos)) {
					$data['mensaje'] = "Los datos ya se encuentran almacenados.";
				} else {
					if ($empleado->guardar($datos)) {
						$data['exito']   = 1;
						$data['mensaje'] = empty($id) ?"Empleado guardado con éxito.":"Empleado actualizado con éxito.";
						$data['linea']   = $empleado->buscar([
							'id'=>$empleado->getPK(),
							'uno'=> true
						]);

					} else {
						$data['mensaje'] = $empleado->getMensaje();
					}
				}
			} else {
				$data['mensaje'] = "Complete todos los campos marcados con *.";
			}
		} else {
			$data['mensaje'] = "Error en el envio de datos";
		}

		$this->output->set_output(json_encode($data));
	}

	public function anular_empleado($id)
	{
		$data = ['exito' => 0];
		$datos = ['activo' => 0];

		$empleado = new Empleado_model($id);

		if ($empleado->guardar($datos)) {
			$data['exito'] = 1;
			$data['mensaje'] = "Empleado anulado con éxito.";
		} else {
			$data['mensaje'] = $empleado->getMensaje();
		}

		$this->output->set_output(json_encode($data));
	}
}	