<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proveedor_bodega extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['mnt/Proveedor_bodega_model']);
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function asignar_bodega($id='')
	{
		$data = ['extio' => 0];

		if ($this->input->method() === 'post') {
			$datos = json_decode(file_get_contents('php://input'));
			
			$existe_bod = $this->catalogo->ver_proveedor_bodega([
				'proveedor_id'  => $datos->proveedor_id, 
				'bodega_id' => $datos->bodega_id,
				'empresa_id' => $datos->empresa_id, 
				'activo'      => 0, 
				'uno'         => true
			]);

			if ($existe_bod) {
				$id = $existe_bod->id;
				$datos->activo = 1;
			}

			if (verPropiedad($datos, 'proveedor_id') && 
				verPropiedad($datos, 'bodega_id')) {
				
				$bodega = new Proveedor_bodega_model($id);

				if ($bodega->guardar($datos)) {
					$data['exito'] = 1;
					$data['mensaje'] = "Bodega asignada con éxito";
					$data['reg'] = $this->catalogo->ver_proveedor_bodega([
						'id'=> $bodega->getPK(), 
						'uno' => true
					]);
				} else {
					$data['mensaje'] = $bodega->getMensaje();
				}
			}
		} 

		$this->output->set_output(json_encode($data));
	}

	
    public function anular_bodega($id)
	{
		$data = ['exito' => 0];
		$datos = ['activo' => 0];

		$bodega = new Proveedor_bodega_model($id);

		if ($bodega->guardar($datos)) {
			$data['exito'] = 1;
			$data['mensaje'] = "Se ha removido corretamente la bodega.";
		} else {
			$data['mensaje'] = $bodega->getMensaje();
		}

		$this->output->set_output(json_encode($data));
	}

}

/* End of file Usuario_sucursal.php */
/* Location: ./application/controllers/Usuario_sucursal.php */