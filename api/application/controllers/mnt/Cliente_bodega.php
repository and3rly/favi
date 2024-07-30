<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cliente_bodega extends CI_Controller {

	public function __construct()
	{	
		parent::__construct();
		$this->load->model(['mnt/Cliente_bodega_model']);
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function asignar_cliente_bodega($id='')
	{
		$data = ['extio' => 0];

		if ($this->input->method() === 'post') {
			$datos = json_decode(file_get_contents('php://input'));
			
			$existe_bodega = $this->catalogo->ver_cliente_bodega([
				'cliente_id' => $datos->cliente_id, 
				'bodega_id'  => $datos->bodega_id, 
				'activo'     => 0, 
				'uno'        => true
			]);
			
			if ($existe_bodega) {
				$id = $existe_bodega->id;
				$datos->activo = 1;
			}

			if (verPropiedad($datos, 'cliente_id') && 
				verPropiedad($datos, 'bodega_id')) {
				
				$clbodega = new Cliente_bodega_model($id);

				if ($clbodega->guardar($datos)) {
					$data['exito'] = 1;
					$data['mensaje'] = "bodega asignada con éxito";
					$data['reg'] = $this->catalogo->ver_cliente_bodega([
						'id'=> $clbodega->getPK(), 
						'uno' => true
					]);
				} else {
					$data['mensaje'] = $clbodega->getMensaje();
				}
			}
		} 

		$this->output->set_output(json_encode($data));
	}

	public function anular_cliente_bodega($id)
	{
		$data = ['exito' => 0];
		$datos = ['activo' => 0];

		$bodega = new Cliente_bodega_model($id);

		if ($bodega->guardar($datos)) {
			$data['exito'] = 1;
			$data['mensaje'] = "Se ha removido corretamente la bodega.";
		} else {
			$data['mensaje'] = $bodega->getMensaje();
		}

		$this->output->set_output(json_encode($data));
	}

}

/* End of file Rol_usuario.php */
/* Location: ./application/controllers/Rol_usuario.php */