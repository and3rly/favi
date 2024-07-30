<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tipo_transaccion extends CI_Controller {
			
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mnt/Tipo_transaccion_model');
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}
	
	public function buscar(){

		$data = [
			'lista'=> $this->Tipo_transaccion_model->buscar($_GET)
		];

		$this->output->set_output(json_encode($data));
	}

	public function guardar($id='')
	{
		$data =["exito" => 0];

		if ($this->input->method() =="post") {
			$datos = (object) $_POST;

			if (verPropiedad($datos,"nombre")) {

				$transaccion = new Tipo_transaccion_model($id);

				if ($transaccion->existe($datos)) {
					$data['mensaje'] ="Los datos ya se encuentran almacenados.";
				} else {
					if ($transaccion->guardar($datos)) {
						$data['exito']   = 1;
						$data['mensaje'] = empty($id) ? "transaccion guardada con éxito.":"transaccion actualizada con éxito.";
						$data['linea']   = $transaccion->buscar([
							'id'=>$transaccion->getPK(),
							'uno'=> true
						]);
					} else {
						$data['mensaje'] = $transaccion->getMensaje();
					}
				}
			} else {
				$data['mensaje'] = "Complete todos los campos marcados con *.";
			}
		} else {
			$data['mensaje']="Error en el envio de datos";
		}
		
		$this->output->set_output(json_encode($data));
	}
}	