<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehiculos_pilotos extends CI_Controller {

	public function __construct()
	{	
		parent::__construct();
		$this->load->model(['mnt/Vehiculos_pilotos_model']);
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}


	


	public function asignar_vehiculos_pilotos($id='')
	{
		$data = ['extio' => 0];

		if ($this->input->method() === 'post') {
			$datos = json_decode(file_get_contents('php://input'));
			
			$existe_vehiculo = $this->catalogo->ver_vehiculos_pilotos([
				
				'vehiculos_id' => $datos->vehiculos_id, 
				'pilotos_id' => $datos->pilotos_id, 
				'activo'     => 0, 
				'uno'        => true
			]);
			
			if ($existe_vehiculo) {
				$id = $existe_vehiculo->id;
				$datos->activo = 1;
			}

			if (verPropiedad($datos, 'vehiculos_id') && 
				verPropiedad($datos, 'pilotos_id')) {
				
				$plVehiculo = new Vehiculos_pilotos_model($id);

				if ($plVehiculo->guardar($datos)) {
					$data['exito'] = 1;
					$data['mensaje'] = empty($id) ?"Registro guardado con éxito.":"Registro actualizado.";
					$data['reg'] = $this->catalogo->ver_vehiculos_pilotos([
						'id'=> $plVehiculo->getPK(), 
						'uno' => true
					]);
				} else {
					$data['mensaje'] = $plVehiculo->getMensaje();
				}
			}
		} 

		$this->output->set_output(json_encode($data));
	}

	public function anular_vehiculos_pilotos($id)
	{
		$data = ['exito' => 0];
		$datos = ['activo' => 0];

		$vehiculos = new Vehiculos_pilotos_model($id);

		if ($vehiculos->guardar($datos)) {
			$data['exito'] = 1;
			$data['mensaje'] = empty($id) ?"Registro guardado con éxito.":"Registro actualizado.";
				
		} else {
			$data['mensaje'] = $vehiculos->getMensaje();
		}

		$this->output->set_output(json_encode($data));
	}

}