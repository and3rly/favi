<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_rol extends CI_Controller {

	public function __construct()
	{	
		parent::__construct();
		$this->load->model(['mnt/Menu_rol_model']);
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function asignar_menu($id='')
	{
		$data = ['exito' => 0];

		if ($this->input->method() === 'post') {
			$datos = json_decode(file_get_contents('php://input'));
			
			$existe_menu = $this->catalogo->ver_menu_rol([
				'menu_modulo_id'	=> $datos->menu_modulo_id,
				'rol_id'	=> $datos->rol_id,
				'activo'     => 0,
				'uno'    => true
			]);

			if ($existe_menu) {
				$id = $existe_menu->id;
				$datos->activo = 1;
			}

			if (verPropiedad($datos, 'menu_modulo_id') && verPropiedad($datos, 'rol_id')) {
				
				$menu_rol = new Menu_rol_model($id);

				if ($menu_rol->guardar($datos)) {
					$data['exito'] = 1;
					$data['mensaje'] = "Menu asignado con éxito";
					$data['reg'] = $this->catalogo->ver_rol_menu([
						'rol_id'     => $datos->rol_id,
						'menu_modulo_id'     => $datos->menu_modulo_id
					]);
				} else {
					$data['mensaje'] = $menu_rol->getMensaje();
				}
			}
		}

		$this->output->set_output(json_encode($data));
	}

	public function anular_menu_rol($id)
	{
		$data = ['exito' => 0];
		$datos = ['activo' => 0];

		$menu_rol = new Menu_rol_model($id);

		if ($menu_rol->guardar($datos)) {
			$data['exito'] = 1;
			$data['mensaje'] = "Se ha removido corretamente el menu.";
		} else {
			$data['mensaje'] = $menu_rol->getMensaje();
		}

		$this->output->set_output(json_encode($data));
	}

}

/* End of file Rol_usuario.php */
/* Location: ./application/controllers/Rol_usuario.php */