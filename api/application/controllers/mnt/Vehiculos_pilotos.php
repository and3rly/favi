<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehiculos_pilotos extends CI_Controller {

	public function __construct()
	{	
		parent::__construct();
		$this->load->model(['mnt/Vehiculos_Pilotos_model']);
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function asignar_Vehiculos_Pilotos($id='')
	{
		$data = ['extio' => 0];

		if ($this->input->method() === 'post') {
			$datos = json_decode(file_get_contents('php://input'));
			
			$existe_vehiculo = $this->catalogo->ver_vehiculos_pilotos([
				'vehiculos_id' => $datos->vehiculos_id, 
				'pilotos_id'  => $datos->pilotos_id, 
				'activo'     => 0, 
				'uno'        => true
			]);
			
			if ($existe_vehiculo) {
				$id = $existe_vehiculo->id;
				$datos->activo = 1;
			}

			if (verPropiedad($datos, 'vehiculos_id') && 
				verPropiedad($datos, 'pilotos_id')) {
				
				$clsucursal = new Vehiculos_Pilotos_model($id);

				if ($clsucursal->guardar($datos)) {
					$data['exito'] = 1;
					$data['mensaje'] = empty($id) ?"Registro guardado con éxito.":"Registro actualizado.";
					$data['reg'] = $this->catalogo->ver_vehiculos_pilotos([
						'id'=> $clsucursal->getPK(), 
						'uno' => true
					]);
				} else {
					$data['mensaje'] = $clsucursal->getMensaje();
				}
			}
		} 

		$this->output->set_output(json_encode($data));
	}

	public function anular_vehiculos_pilotos($id)
	{
		$data = ['exito' => 0];
		$datos = ['activo' => 0];

		$sucursal = new Vehiculos_Pilotos_model($id);

		if ($sucursal->guardar($datos)) {
			$data['exito'] = 1;
			$data['mensaje'] = empty($id) ?"Registro guardado con éxito.":"Registro actualizado.";
				
		} else {
			$data['mensaje'] = $sucursal->getMensaje();
		}

		$this->output->set_output(json_encode($data));
	}

}