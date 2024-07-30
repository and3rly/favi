<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cliente extends CI_Controller{
			
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mnt/Cliente_model');
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}
	
	public function buscar(){

		$data = [
			'lista'=> $this->Cliente_model->buscar($_GET)
		];

		$this->output->set_output(json_encode($data));
	}

	public function guardar($id='')
	{
		$data =["exito" => 0];
		
		if ($this->input->method() =="post") {
			$datos = (object) $_POST;

			if (verPropiedad($datos,"nombre_comercial") && 
				verPropiedad($datos,"cliente_tipo_id")) {

				$cliente = new Cliente_model($id);

				if ($cliente->existe($datos)) {
					$data['mensaje'] = "Los datos ya se encuentran almacenados.";
				} else {
					if ($cliente->guardar($datos)) {
						$data['exito']   = 1;
						$data['mensaje'] = empty($id) ?"Cliente guardado con éxito.":"Cliente actualizado con éxito.";
						$data['linea']   = $cliente->buscar(['id'=>$cliente->getPK(),'uno'=> true]);

					} else {
						$data['mensaje'] = $cliente->getMensaje();
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

	public function anular_cliente($id)
	{
		$data = ['exito' => 0];
		$datos = ['activo' => 0];

		$cliente = new Cliente_model($id);

		if ($cliente->guardar($datos)) {
			$data['exito'] = 1;
			$data['mensaje'] = "cliente anulado con éxito.";
		} else {
			$data['mensaje'] = $cliente->getMensaje();
		}

		$this->output->set_output(json_encode($data));
	}
}	