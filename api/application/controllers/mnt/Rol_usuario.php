<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rol_usuario extends CI_Controller {

	public function __construct()
	{	
		parent::__construct();
		$this->load->model(['mnt/Rol_usuario_model']);
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function asignar_rol($id='')
	{
		$data = ['extio' => 0];

		if ($this->input->method() === 'post') {
			$datos = json_decode(file_get_contents('php://input'));
			
			$existe_rol = $this->catalogo->ver_usuario_rol([
				'usuario_id' => $datos->usuario_id, 
				'rol_id'     => $datos->rol_id, 
				'activo'     => 0, 
				'uno'        => true
			]);
			
			if ($existe_rol) {
				$id = $existe_rol->id;
				$datos->activo = 1;
			}

			if (verPropiedad($datos, 'usuario_id') && 
				verPropiedad($datos, 'rol_id')) {
				
				$rol = new Rol_usuario_model($id);

				if ($rol->guardar($datos)) {
					$data['exito'] = 1;
					$data['mensaje'] = "Rol asignado con éxito";
					$data['reg'] = $this->catalogo->ver_usuario_rol(['id'=> $rol->getPK(), 'uno' => true]);
				} else {
					$data['mensaje'] = $rol->getMensaje();
				}
			}
		} 

		$this->output->set_output(json_encode($data));
	}

	public function anular_rol_usuario($id)
	{
		$data = ['exito' => 0];
		$datos = ['activo' => 0];

		$rol = new Rol_usuario_model($id);

		if ($rol->guardar($datos)) {
			$data['exito'] = 1;
			$data['mensaje'] = "Se ha removido corretamente el rol.";
		} else {
			$data['mensaje'] = $rol->getMensaje();
		}

		$this->output->set_output(json_encode($data));
	}

}

/* End of file Rol_usuario.php */
/* Location: ./application/controllers/Rol_usuario.php */