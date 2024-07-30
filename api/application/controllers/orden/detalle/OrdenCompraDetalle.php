<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OrdenCompraDetalle extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->set_content_type('application/json');
		$this->load->model(['orden/detalle/OrdenCompraDetalle_model']);
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar()
	{
		$data = [
			'lista' => $this->OrdenCompraDetalle_model->buscar($_GET)
		];

		$this->output->set_output(json_encode($data)); 
	}

	public function getLast()
	{
		$data = [
			'lista' => $this->OrdenCompraDetalle_model->getLast($_GET)
		];

		$this->output->set_output(json_encode($data));
	}

	public function guardar($id="") 
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = json_decode(file_get_contents('php://input'));

			if (verPropiedad($datos, 'no_linea')) {

				$ordenCompraDetalle = new OrdenCompraDetalle_model($id);

				if ($ordenCompraDetalle->existe($datos)) {
					$data['exito'] = 2;
					$data['mensaje'] = "Ya existe el detalle de la orden que intenta guardar.";
				} else {

					if ($ordenCompraDetalle->guardar($datos)) {
						$data['exito']   = 1;
						$data['mensaje'] = empty($id) ? "Registro guardado con éxito.":"Registro actualizado.";

						if(empty($id)){
							$data['linea']   = $ordenCompraDetalle->getLast(['orden_compra_enc_id' => $datos->orden_compra_enc_id, 'uno' => true]);
						}else{
							$data['linea']   = $ordenCompraDetalle->buscar(['id' => $ordenCompraDetalle->getPK(), 'uno' => true]);
						}
						
					} else {
						$data['mensaje'] = $ordenCompraDetalle->getMensaje();
					}
				}

			} else {
				$data['mensaje'] = "Complete todos los campos marcados con *.";
			}
				
		} else {
			$data['mensaje'] = "Error en el envio de datos";
		}

		$this->output->set_output(json_encode($data));
	}

	public function eliminar_producto($id)
	{
		$data = ['exito' => 0];
		$datos = ['activo' => 0];

		$det = new OrdenCompraDetalle_model($id);

		if ($det->guardar($datos)) {
			$data['exito'] = 1;
			$data['mensaje'] = "Producto removido con éxito.";
		} else {
			$data['mensaje'] = $det->getMensaje();
		}

		$this->output->set_output(json_encode($data));
	}

	public function actualizar_linea($id)
	{
		$data = ['exito' => 0];

		$det = new OrdenCompraDetalle_model($id);
		
		$datos = ['no_linea' => $det->no_linea-1];

		if ($det->guardar($datos)) {
			$data['exito'] = 1;
			$data['mensaje'] = "Número de línea actualizado con éxito.";
		} else {
			$data['mensaje'] = $det->getMensaje();
		}

		$this->output->set_output(json_encode($data));
	}

}

/* End of file OrdenCompra.php */
/* Location: ./application/controllers/OrdenCompra.php */