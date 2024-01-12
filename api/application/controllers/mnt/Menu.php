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
		$modulos = $this->Menu_model->_buscar($_GET);

		if ($modulos) {
			foreach ($modulos as $row) {
				$datos = $this->Menu_modulo_model->_buscar([
					'modulo'  => $row->id,
				]);

				$row->opciones = $datos ? $datos : false;
			}
		}

		$this->output->set_output(json_encode([
		 	'lista' => $modulos ? $modulos : []
		]));
	}
	
	public function anular_menu($id)
	{
		$data = ['exito' => 0];
		$datos = ['activo' => 0];

		$menu = new Menu_model($id);

		if ($menu->guardar($datos)) {
			$data['exito'] = 1;
			$data['mensaje'] = "Menú anulado con éxito.";
		} else {
			$data['mensaje'] = $menu->getMensaje();
		}

		$this->output->set_output(json_encode($data));
	}
	
	public function guardar($id='')
	{
		$data = ['exito' => 0];

		if ($this->input->method() === 'post') {
			
			$datos = (object) $_POST;

			if (verPropiedad($datos, 'titulo') && verPropiedad($datos, 'nombre')) {

				$menu = new Menu_model($id);
				
				if ($menu->guardar($datos)) {
					$data['exito'] = 1;
					$termino = empty($id) ? 'guardado':'actualizado';
					$data['mensaje'] = "Menú {$termino} con éxito";

					$data['linea'] = $menu->buscar(['id' => $menu->getPK(), 'uno' => true]);
				} else {
					$data['mensaje'] = $menu->getMensaje();
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