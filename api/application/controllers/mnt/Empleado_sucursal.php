<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empleado_sucursal extends CI_Controller {

	public function __construct()
	{	
		parent::__construct();
		$this->load->model(['mnt/Empleado_sucursal_model']);
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function asignar_empleado_sucursal($id='')
	{
		$data = ['extio' => 0];

		if ($this->input->method() === 'post') {
			$datos = json_decode(file_get_contents('php://input'));
			
			$existe_sucursal = $this->catalogo->ver_empleado_sucursal([
				'empleado_id' => $datos->empleado_id, 
				'sucursal_id'  => $datos->sucursal_id, 
				'activo'     => 0, 
				'uno'        => true
			]);
			
			if ($existe_sucursal) {
				$id = $existe_sucursal->id;
				$datos->activo = 1;
			}

			if (verPropiedad($datos, 'empleado_id') && 
				verPropiedad($datos, 'sucursal_id')) {
				
				$clsucursal = new Empleado_sucursal_model($id);

				if ($clsucursal->guardar($datos)) {
					$data['exito'] = 1;
					$data['mensaje'] = empty($id) ?"Registro guardado con éxito.":"Registro actualizado.";
					$data['reg'] = $this->catalogo->ver_empleado_sucursal([
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

	public function anular_empleado_sucursal($id)
	{
		$data = ['exito' => 0];
		$datos = ['activo' => 0];

		$sucursal = new Empleado_sucursal_model($id);

		if ($sucursal->guardar($datos)) {
			$data['exito'] = 1;
			$data['mensaje'] = empty($id) ?"Registro guardado con éxito.":"Registro actualizado.";
				
		} else {
			$data['mensaje'] = $sucursal->getMensaje();
		}

		$this->output->set_output(json_encode($data));
	}

}