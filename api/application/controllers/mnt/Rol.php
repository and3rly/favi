<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rol extends CI_Controller {

	public function __construct($id='')
	{
		parent::__construct();
		if (!empty($id)) {
			$this->cargar($id);
		}
		$this->load->model(['mnt/Rol_model']);
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}
	
	public function buscar()
	{
		$this->output->set_output(json_encode([
			'lista' => $this->Rol_model->buscar($_GET)
		]));
	}
	
	public function anular_rol($id)
	{
		$data = ['exito' => 0];
		$datos = ['activo' => 0];

		$rol = new Rol_model($id);

		if ($rol->guardar($datos)) {
			$data['exito'] = 1;
			$data['mensaje'] = "Rol anulado con éxito.";
		} else {
			$data['mensaje'] = $rol->getMensaje();
		}

		$this->output->set_output(json_encode($data));
	}
	
	public function guardar($id='')
	{
		$data = ['exito' => 0];

		if ($this->input->method() === 'post') {
			
			$datos = json_decode(file_get_contents('php://input'));

			if (verPropiedad($datos, 'nombre')) {

				$rol = new Rol_model($id);

				if (!$rol->existe_rol(['nombre' => $datos->nombre])) {
					$data['mensaje'] = "Este nombre de rol ya está registrado.";
				} else {
					if ($rol->guardar($datos)) {
						$data['exito'] = 1;
						$termino = empty($id) ? 'guardado':'actualizado';
						$data['mensaje'] = "Rol {$termino} con éxito";

						$data['linea'] = $rol->buscar(['id' => $rol->getPK(), 'uno' => true]);
					} else {
						$data['mensaje'] = $rol->getMensaje();
					}
				}
			}
		} else {
			$data['mensaje'] = "Método de envio incorrecto";
		}

		$this->output->set_output(json_encode($data));
	}
	

	// public function anular_menu_rol($id)
	// {
	// 	$data = ['exito' => 0];
	// 	$datos = ['activo' => 0];

	// 	$rol = new Rol_model($id);

	// 	if ($rol->guardar($datos)) {
	// 		$data['exito'] = 1;
	// 		$data['mensaje'] = "Se ha removido corretamente el menu.";
	// 	} else {
	// 		$data['mensaje'] = $rol->getMensaje();
	// 	}

	// 	$this->output->set_output(json_encode($data));
	// }

}

/* End of file Rol.php */
/* Location: ./application/controllers/Rol.php */