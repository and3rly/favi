<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario_sucursal extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['mnt/Usuario_sucursal_model']);
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function asignar_sucursal($id='')
	{
		$data = ['extio' => 0];

		if ($this->input->method() === 'post') {
			$datos = json_decode(file_get_contents('php://input'));
			
			$existe_suc = $this->catalogo->ver_usuario_sucursal([
				'usuario_id'  => $datos->usuario_id, 
				'sucursal_id' => $datos->sucursal_id, 
				'activo'      => 0, 
				'uno'         => true
			]);

			if ($existe_suc) {
				$id = $existe_suc->id;
				$datos->activo = 1;
			}

			if (verPropiedad($datos, 'usuario_id') && 
				verPropiedad($datos, 'sucursal_id')) {
				
				$sucursal = new Usuario_sucursal_model($id);

				if ($sucursal->guardar($datos)) {
					$data['exito'] = 1;
					$data['mensaje'] = "Sucursal asignada con éxito";
					$data['reg'] = $this->catalogo->ver_usuario_sucursal([
						'id'=> $sucursal->getPK(), 
						'uno' => true
					]);
				} else {
					$data['mensaje'] = $sucursal->getMensaje();
				}
			}
		} 

		$this->output->set_output(json_encode($data));
	}

	public function anular_sucursal($id)
	{
		$data = ['exito' => 0];
		$datos = ['activo' => 0];

		$sucursal = new Usuario_sucursal_model($id);

		if ($sucursal->guardar($datos)) {
			$data['exito'] = 1;
			$data['mensaje'] = "Se ha removido corretamente la sucursal.";
		} else {
			$data['mensaje'] = $sucursal->getMensaje();
		}

		$this->output->set_output(json_encode($data));
	}

}

/* End of file Usuario_sucursal.php */
/* Location: ./application/controllers/Usuario_sucursal.php */