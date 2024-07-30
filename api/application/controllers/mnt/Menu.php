<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {

	public function __construct($id='')
	{
		parent::__construct();
		if (!empty($id)) {
			$this->cargar($id);
		}
		$this->load->model([
			'mnt/Menu_model',
			'mnt/Menu_modulo_model'
		]);
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}
	
	public function buscar()
	{
		$data =  [
			'lista' => $this->Menu_model->_buscar($_GET)
		];

		$this->output->set_output(json_encode($data));
	}

	public function get_modulos()
	{
		$user = $this->session->userdata('usuario');
		$modulos = $this->Menu_model->_buscar(['rol_id'=>$user['id']]);

		if ($modulos) {
			foreach ($modulos as $row) {
				$datos = $this->Menu_modulo_model->_buscar([
					'modulo'  => $row->id,
					'rol_id'=>$user['id']
				]);

				$row->opciones = $datos ? $datos : false;
			}
		}

		$this->output->set_output(json_encode([
		 	'lista' => $modulos ? $modulos : []
		]));
	}

	public function get_opciones()
	{
		$opciones = $this->Menu_modulo_model->_buscar($_GET);

		$this->output->set_output(json_encode([
		 	'lista' => $opciones ? $opciones : []
		]));
	}
	
	public function anular_modulo($id)
	{
		$data = ['exito' => 0];
		$datos = ['activo' => 0];

		$menu = new Menu_model($id);

		if ($menu->guardar($datos)) {
			$data['exito'] = 1;
			$data['mensaje'] = "Módulo anulado con éxito.";
		} else {
			$data['mensaje'] = $menu->getMensaje();
		}

		$this->output->set_output(json_encode($data));
	}

	public function anular_opcion($id)
	{
		$data = ['exito' => 0];
		$datos = ['activo' => 0];

		$menu = new Menu_modulo_model($id);

		if ($menu->guardar($datos)) {
			$data['exito'] = 1;
			$data['mensaje'] = "Opción anulada con éxito.";
		} else {
			$data['mensaje'] = $menu->getMensaje();
		}

		$this->output->set_output(json_encode($data));
	}
	
	public function guardar($id='')
	{
		$data = ['exito' => 0];

		if ($this->input->method() === 'post') {
			
			$datos = json_decode(file_get_contents('php://input'));

			if (verPropiedad($datos, 'nombre') && 
				verPropiedad($datos, 'url') && 
				verPropiedad($datos, 'icono')) {

				$menu = new Menu_model($id);
				
				if ($menu->guardar($datos)) {
					$data['exito'] = 1;
					$termino = empty($id) ? 'guardado':'actualizado';
					$data['mensaje'] = "Módulo {$termino} con éxito";

					$data['linea'] = $menu->_buscar(['id' => $menu->getPK(), 'uno' => true]);
				} else {
					$data['mensaje'] = $menu->getMensaje();
				}
					
			}
		} else {
			$data['mensaje'] = "Método de envio incorrecto";
		}

		$this->output->set_output(json_encode($data));
	}

	public function guardar_opcion($id='')
	{
		$data = ['exito' => 0];

		if ($this->input->method() === 'post') {
			
			$datos = json_decode(file_get_contents('php://input'));

			if (verPropiedad($datos, 'nombre') && 
				verPropiedad($datos, 'url') && 
				verPropiedad($datos, 'icono')) {

				$mm = new Menu_modulo_model($id);
				
				if ($mm->guardar($datos)) {
					$data['exito'] = 1;
					$termino = empty($id) ? 'guardada':'actualizada';
					$data['mensaje'] = "Opción {$termino} con éxito";

					$data['linea'] = $mm->_buscar(['id' => $mm->getPK(), 'uno' => true]);
				} else {
					$data['mensaje'] = $mm->getMensaje();
				}
					
			}
		} else {
			$data['mensaje'] = "Método de envio incorrecto";
		}

		$this->output->set_output(json_encode($data));
	}

}

/* End of file Menu.php */
/* Location: ./application/controllers/Menu.php */