<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modulo_rol extends CI_Controller {

	public function __construct()
	{	
		parent::__construct();
		$this->load->model(['mnt/Modulo_rol_model']);
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function asignar_modulo($id='')
	{
		$data = ['exito' => 0];

		if ($this->input->method() === 'post') {
			$datos = json_decode(file_get_contents('php://input'));
			
			$existe_modulo = $this->catalogo->ver_modulo_rol([
				'modulo_id'	=> $datos->modulo_id,
				'rol_id'	=> $datos->rol_id,
				'activo'     => 0,
				'uno'    => true
			]);

			if ($existe_modulo) {
				$id = $existe_modulo->id;
				$datos->activo = 1;
			}

			if (verPropiedad($datos, 'modulo_id') && verPropiedad($datos, 'rol_id')) {
				
				$modulo_rol = new Modulo_rol_model($id);

				if ($modulo_rol->guardar($datos)) {
					$data['exito'] = 1;
					$data['mensaje'] = "Modulo asignado con éxito";
					$data['reg'] = $this->catalogo->ver_rol_modulo([
						'rol_id'     => $datos->rol_id,
						'modulo_id'     => $datos->modulo_id
					]);
				} else {
					$data['mensaje'] = $modulo_rol->getMensaje();
				}
			}
		}

		$this->output->set_output(json_encode($data));
	}

	public function anular_modulo_rol($id)
	{
		$data = ['exito' => 0];
		$datos = ['activo' => 0];

		$modulo_rol = new Modulo_rol_model($id);

		if ($modulo_rol->guardar($datos)) {
			$data['exito'] = 1;
			$data['mensaje'] = "Se ha removido corretamente el modulo.";
		} else {
			$data['mensaje'] = $modulo_rol->getMensaje();
		}

		$this->output->set_output(json_encode($data));
	}

}

/* End of file Modulo_rol.php */
/* Location: ./application/controllers/Modulo_rol.php */