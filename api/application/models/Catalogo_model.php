<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalogo_model extends General_model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function ver_empresa_usuario_sucursal($args=[])
	{

		if (elemento($args, 'usuario_id')) {
			$this->db->where('u.usuario_id', $args['usuario_id']);
		}

		$tmp = $this->db
					->select("e.*")
					->join("sucursal s","e.id = s.empresa_id")
					->join("usuario_sucursal u", "u.usuario_id = s.usuario_id")
					->get('empresa e');

		return verConsulta($tmp, $args);
	}

	public function ver_usuario_sucursal($args=[])
	{
		if (elemento($args, 'id')) {
			$this->db->where('a.id', $args['id']);
		}

		if (elemento($args, 'usuario_id')) {
			$this->db->where('a.usuario_id', $args['usuario_id']);
		}

		if (elemento($args, 'sucursal_id')) {
			$this->db->where('a.sucursal_id', $args['sucursal_id']);
		}

		if (isset($args['activo'])) {
			$this->db->where('a.activo', $args['activo']);
		} else {
			$this->db->where('a.activo', 1);
		}

		$tmp = $this->db
					->select("a.*, b.nombre as nsucursal, b.empresa_id")
					->join("sucursal b","b.id = a.sucursal_id")
					->get('usuario_sucursal a');

		return verConsulta($tmp, $args);
	}
	
	
	public function ver_vehiculos_pilotos($args=[])
	{	
		if (elemento($args, 'id')) {
			$this->db->where('vp.id', $args['id']);
		}

		if (elemento($args, 'pilotos_id')) {
			$this->db->where('vp.pilotos_id', $args['pilotos_id']);
		}

		if (elemento($args, 'vehiculos_id')) {
			$this->db->where('vp.vehiculos_id', $args['vehiculos_id']);
		}

		if (isset($args['activo'])) {
			$this->db->where('vp.activo', $args['activo']);
		} else {
			$this->db->where('vp.activo', 1);
		}

		$tmp = $this->db
					->select("vp.*, b.*")
					->join("vehiculos b"," b.id=vp.vehiculos_id ")
					->get('vehiculos_pilotos vp');

		return verConsulta($tmp, $args);
	}

	public function ver_proveedor_bodega($args=[])
	{	
		if (elemento($args, 'id')) {
			$this->db->where('a.id', $args['id']);
		}

		if (elemento($args, 'proveedor_id')) {
			$this->db->where('a.proveedor_id', $args['proveedor_id']);
		}

		if (elemento($args, 'bodega_id')) {
			$this->db->where('a.bodega_id', $args['bodega_id']);
		}

		if (isset($args['activo'])) {
			$this->db->where('a.activo', $args['activo']);
		} else {
			$this->db->where('a.activo', 1);
		}

		$tmp = $this->db
					->select("a.*, b.nombre as bodega_nombre")
					->join("bodega b","b.id = a.bodega_id")
					->get('proveedor_bodega a');

		return verConsulta($tmp, $args);
	}

	public function ver_producto_bodega($args=[])
	{	
		if (elemento($args, 'id')) {
			$this->db->where('a.id', $args['id']);
		}

		if (elemento($args, 'producto_id')) {
			$this->db->where('a.producto_id', $args['producto_id']);
		}

		if (elemento($args, 'bodega_id')) {
			$this->db->where('a.bodega_id', $args['bodega_id']);
		}

		if (isset($args['activo'])) {
			$this->db->where('a.activo', $args['activo']);
		} else {
			$this->db->where('a.activo', 1);
		}

		$tmp = $this->db
					->select("a.*, b.nombre as bodega_nombre")
					->join("bodega b","b.id = a.bodega_id")
					->get('producto_bodega a');

		return verConsulta($tmp, $args);
	}


	public function ver_usuario_rol($args=[])
	{	
		if (elemento($args, 'usuario_id')) {
			$this->db->where('a.usuario_id', $args['usuario_id']);
		}

		if (elemento($args, 'rol_id')) {
			$this->db->where('a.rol_id', $args['rol_id']);
		}

		if (elemento($args, 'id')) {
			$this->db->where('a.id', $args['id']);
		}

		if (isset($args['activo'])) {
			$this->db->where('a.activo', $args['activo']);
		} else {
			$this->db->where('a.activo', 1);
		}

		$tmp = $this->db
					->select("a.*, b.nombre as nrol")
					->join("rol b", "b.id = a.rol_id")
					->get('rol_usuario a');

		return verConsulta($tmp, $args);
	}

	public function ver_menu_rol($args=[])
	{
		if (elemento($args, 'id')) {
			$this->db->where('mr.id', $args['id']);
		}

		if (elemento($args, 'menu_modulo_id')) {
			$this->db->where('mr.menu_modulo_id', $args['menu_modulo_id']);
		}

		if (elemento($args, 'rol_id')) {
			$this->db->where('mr.rol_id', $args['rol_id']);
		}

		if (elemento($args, 'activo')) {
			$this->db->where('mr.activo', $args['activo']);
		}

		$tmp = $this->db
					->select("mr.*")
					->get('menu_rol mr');

		return verConsulta($tmp, $args);
	}

	public function ver_modulo_rol($args=[])
	{
		if (elemento($args, 'id')) {
			$this->db->where('mr.id', $args['id']);
		}

		if (elemento($args, 'modulo_id')) {
			$this->db->where('mr.modulo_id', $args['modulo_id']);
		}

		if (elemento($args, 'rol_id')) {
			$this->db->where('mr.rol_id', $args['rol_id']);
		}

		if (elemento($args, 'activo')) {
			$this->db->where('mr.activo', $args['activo']);
		}

		$tmp = $this->db
					->select("mr.*")
					->get('modulo_rol mr');

		return verConsulta($tmp, $args);
	}

	public function ver_rol_menu($args=[])
	{
		if (elemento($args, 'rol_id')) {
			$this->db->where('mr.rol_id', $args['rol_id']);
		}
		
		if (elemento($args, 'menu_modulo_id')) {
			$this->db->where('mm.id', $args['menu_modulo_id']);
		}

		$tmp = $this->db
					->select("mm.*, mr.id as menu_rol_id")
					->join("menu_rol mr", "mm.id = mr.menu_modulo_id")
					->join("rol b", "b.id = mr.rol_id")
					->where('mr.activo', 1)
					->get('menu_modulo mm');
					
		return verConsulta($tmp, $args);
	}

	public function ver_rol_modulo($args=[])
	{
		if (elemento($args, 'rol_id')) {
			$this->db->where('mr.rol_id', $args['rol_id']);
		}
		
		if (elemento($args, 'modulo_id')) {
			$this->db->where('m.id', $args['modulo_id']);
		}

		$tmp = $this->db
					->select("m.*, mr.id as modulo_rol_id")
					->join("modulo_rol mr", "m.id = mr.modulo_id")
					->join("rol b", "b.id = mr.rol_id")
					->where('mr.activo', 1)
					->get('modulo m');
					
		return verConsulta($tmp, $args);
	}

	public function ver_sucursal($args=[])
	{
		$tmp = $this->db
					->where('activo', 1)
					->get('sucursal');

		return verConsulta($tmp, $args);
	}
	
	public function ver_empleado($args=[])
	{
		$tmp = $this->db
					->where('activo', 1)
					->get('empleado');

		return verConsulta($tmp, $args);
	}
	public function ver_usuario($args=[])
	{
		$tmp = $this->db
					->where('activo', 1)
					->get('usuario');

		return verConsulta($tmp, $args);
	}

	public function ver_proveedor($args=[])
	{
		$tmp = $this->db
					->where('activo', 1)
					->get('proveedor');

		return verConsulta($tmp, $args);
	}

	public function ver_rol($args=[])
	{	
		$tmp = $this->db
					->where('activo', 1)
					->get('rol');

		return verConsulta($tmp, $args);
	}

	public function ver_um($args=[])
	{	
		$tmp = $this->db
					->where('activo', 1)
					->get('unidad_medida');

		return verConsulta($tmp, $args);
	}

	public function ver_marca($args=[])
	{	
		$tmp = $this->db
					->where('activo', 1)
					->get('marca_producto');

		return verConsulta($tmp, $args);
	}

	public function ver_clasificacion($args=[])
	{	
		$tmp = $this->db
					->where('activo', 1)
					->get('clasificacion_producto');

		return verConsulta($tmp, $args);
	}

	public function ver_estado($args=[])
	{	

		$tmp = $this->db
					->where('activo', 1)
					->get('estado_producto');

		return verConsulta($tmp, $args);
	}

	public function ver_tipo($args=[])
	{	
		$tmp = $this->db
					->where('activo', 1)
					->get('tipo_producto');

		return verConsulta($tmp, $args);
	}

	public function ver_familia($args=[])
	{	
		$tmp = $this->db
					->where('activo', 1)
					->get('familia_producto');

		return verConsulta($tmp, $args);
	}

	public function ver_presentacion($args=[])
	{	
		$tmp = $this->db
					->where('activo', 1)
					->get('presentacion_producto');

		return verConsulta($tmp, $args);
	}

	public function ver_empresa() {
		$this->load->model('mnt/Empresa_model');

		return $this->Empresa_model->buscar();
	}

	public function ver_menu($args=[]) {
		$tmp = $this->db
					->where('activo', 1)
					->get('menu');

		return verConsulta($tmp, $args);
	}

	public function ver_menu_modulo($args=[]) {
		$tmp = $this->db
					->where('activo', 1)
					->get('menu_modulo');

		return verConsulta($tmp, $args);
	}

	public function ver_menu_modulo_filter($args=[]) {

		if (elemento($args, 'rol_id')) {
			$this->db->where('mr.rol_id', $args['rol_id']);
		}


		$this->db->where('mr.activo', 1);
		
		$tmp = $this->db
					->select('mm.*')
					->join('modulo_rol mr', 'm.id = mr.modulo_id')
					->join('menu_modulo mm', 'm.id = mm.modulo_id')
					->get('modulo m');

		return verConsulta($tmp, $args);
	}

	public function ver_modulo($args=[]) {
		$tmp = $this->db
					->where('titulo', 0)
					->where('activo', 1)
					->get('modulo');

		return verConsulta($tmp, $args);
	}

  	public function ver_motivo_anulacion_pedido($args=[])
	{
		$tmp = $this->db
					->where('activo', 1)
					->get('motivo_anulacion_pedido');

		return verConsulta($tmp, $args);
	}
	public function ver_motivo_devolucion($args=[])
	{
		$tmp = $this->db
					->where('activo', 1)
					->get('motivo_devolucion');

		return verConsulta($tmp, $args);
	}

	public function ver_pedido_tipo($args=[])
	{
		if (elemento($args, 'nombre')) {
			$this->db->where('nombre', $args['nombre']);
		}

		$tmp = $this->db
					->get('pedido_tipo');
		return verConsulta($tmp, $args);
	}

	public function ver_cliente_tipo() {
		$this->load->model('mnt/Cliente_tipo_model');

		return $this->Cliente_tipo_model->buscar();
	}

	public function ver_cliente($args=[]) {
		$tmp = $this->db
		->where('activo', 1)
		->get('cliente');

		return verConsulta($tmp, $args);
	}

	public function ver_cliente_bodega($args=[])
	{	
		if (elemento($args, 'id')) {
			$this->db->where('cb.id', $args['id']);
		}

		if (elemento($args, 'cliente_id')) {
			$this->db->where('cb.cliente_id', $args['cliente_id']);
		}

		if (elemento($args, 'bodega_id')) {
			$this->db->where('cb.bodega_id', $args['bodega_id']);
		}

		if (isset($args['activo'])) {
			$this->db->where('cb.activo', $args['activo']);
		} else {
			$this->db->where('cb.activo', 1);
		}

		$tmp = $this->db
					->select("cb.*, b.nombre as nombre_bodega")
					->join("bodega b","b.id = cb.bodega_id")
					->get('cliente_bodega cb');

		return verConsulta($tmp, $args);
	}

	public function ver_cliente_sucursal($args=[])
	{	
		if (elemento($args, 'id')) {
			$this->db->where('cs.id', $args['id']);
		}

		if (elemento($args, 'cliente_id')) {
			$this->db->where('cs.cliente_id', $args['cliente_id']);
		}

		if (elemento($args, 'sucursal_id')) {
			$this->db->where('cs.sucursal_id', $args['sucursal_id']);
		}

		if (isset($args['activo'])) {
			$this->db->where('cs.activo', $args['activo']);
		} else {
			$this->db->where('cs.activo', 1);
		}

		$tmp = $this->db
					->select("cs.*, b.nombre as nombre_sucursal")
					->join("sucursal b","b.id = cs.sucursal_id")
					->get('cliente_sucursal cs');

		return verConsulta($tmp, $args);
	}

	public function ver_empleado_sucursal($args=[])
	{	
		if (elemento($args, 'id')) {
			$this->db->where('es.id', $args['id']);
		}

		if (elemento($args, 'cliente_id')) {
			$this->db->where('es.cliente_id', $args['cliente_id']);
		}

		if (elemento($args, 'sucursal_id')) {
			$this->db->where('es.sucursal_id', $args['sucursal_id']);
		}

		if (isset($args['activo'])) {
			$this->db->where('es.activo', $args['activo']);
		} else {
			$this->db->where('es.activo', 1);
		}

		$tmp = $this->db
					->select("es.*, b.nombre as nombre_sucursal")
					->join("sucursal b","b.id = es.sucursal_id")
					->get('empleado_sucursal es');

		return verConsulta($tmp, $args);
	}

	public function ver_rotacion($args=[]) 
	{
		$tmp = $this->db
					->where('activo', 1)
					->get('rotacion');

		return verConsulta($tmp, $args);
	}

	public function ver_proveedor_bodega_orden($args=[])
	{

		if (isset($args['bodega_id'])) {
			$this->db->where('b.id', $args['bodega_id']);
		}

		$tmp = $this->db
					->select('pb.*, p.nombre as nombre_proveedor, b.nombre as nombre_bodega')
					->join('proveedor p', 'p.id = pb.proveedor_id')
					->join('bodega b', 'b.id = pb.bodega_id')
					->where('pb.activo', 1)
					->get('proveedor_bodega pb');

		return verConsulta($tmp, $args);
	}

	public function ver_producto_bodega_orden($args=[])
	{
		$tmp = $this->db
					->select('pb.*, p.codigo as codigo_producto, p.nombre as nombre_producto, b.nombre as nombre_bodega')
					->join('producto p', 'p.id = pb.producto_id')
					->join('bodega b', 'b.id = pb.bodega_id')
					->where('pb.activo', 1)
					->get('producto_bodega pb');

		return verConsulta($tmp, $args);
	}

	public function ver_bodega($args=[]) 
	{
		$tmp = $this->db
					->where('activo', 1)
					->get('bodega');

		return verConsulta($tmp, $args);
	}

	public function ver_ruta($args=[]) 
	{
		$tmp = $this->db
					->get('ruta');

		return verConsulta($tmp, $args);
	}

	public function ver_producto($args=[]) 
	{
		if (elemento($args, 'id')) {
			$this->db->where('pr.id', $args['id']);
		}

		if (elemento($args, 'codigo')) {
			$this->db->where('pr.codigo', $args['codigo']);
		}

		if (elemento($args, 'nombre')) {
			$this->db->where('pr.nombre', $args['nombre']);
		}

		if (isset($args['activo'])) {
			$this->db->where('pr.activo', $args['activo']);
		} else {
			$this->db->where('pr.activo', 1);
		}

		$tmp = $this->db
					->get('producto pr');

		return verConsulta($tmp, $args);
	}

	public function ver_orden_compra_tipo($args=[]) 
	{
		$tmp = $this->db
					->where('activo', 1)
					->get('orden_compra_tipo');

		return verConsulta($tmp, $args);
	}

	public function ver_orden_compra_estado($args=[]) 
	{
		$tmp = $this->db
					->where('activo', 1)
					->get('orden_compra_estado');

		return verConsulta($tmp, $args);
	}

	public function ver_orden_compra_det($args=[]) 
	{
		
		if (elemento($args, 'orden_compra_enc_id')) {
			$this->db->where('ocd.orden_compra_enc_id', $args['orden_compra_enc_id']);
		}

		$tmp = $this->db
					->select('ocd.*, p.id as id_producto_j, p.codigo as codigo_producto_j, p.nombre as nombre_producto_j, pp.codigo as codigo_presentacion_j, pp.nombre nombre_presentacion_j, um.nombre as nombre_unidad_medida_j, md.nombre as nombre_motivo_dev')
					->join('producto_bodega pb', 'pb.id = ocd.producto_bodega_id')
					->join('producto p', 'p.id = pb.producto_id')
					->join('presentacion_producto pp', 'pp.id = ocd.presentacion_producto_id')
					->join('unidad_medida um', 'um.id = ocd.unidad_medida_id')
					->join('motivo_devolucion md', 'md.id = ocd.motivo_devolucion_id')
					->where('ocd.activo', 1)
					->get('orden_compra_det ocd');

		return verConsulta($tmp, $args);
	}

	public function ver_estado_rec($args=[]) 
	{
		$tmp = $this->db
		->where("activo", 1)
		->get("estado_recepcion");

		return verConsulta($tmp, $args);
	}

	public function ver_tipo_transaccion($args=[]) 
	{
		$tmp = $this->db
		->where("activo", 1)
		->get("tipo_transaccion");

		return verConsulta($tmp, $args);
	}

	public function ver_vehiculos($args=[]) 
	{
		$tmp = $this->db
		->where("activo", 1)
		->get("vehiculos");

		return verConsulta($tmp, $args);
	}

	public function ver_pilotos($args=[]) 
	{
		$tmp = $this->db
		->where("activo", 1)
		->get("pilotos");

		return verConsulta($tmp, $args);
	}

	public function ver_productos_bodega($args=[]) 
	{	
		if (elemento($args, 'bodega')) {
			$this->db->where('a.bodega_id', $args['bodega']);
		}

		$tmp = $this->db
		->select("
			1 as cantidad,
			a.*, 
			a.id as producto_bodega, 
			b.*,
			b.id as id_producto,
			c.nombre as nombre_bodega,
			d.nombre as nombre_um,
			e.nombre as nombre_estado,
			f.nombre as nombre_marca")
		->join("producto b","b.id = a.producto_id")
		->join("bodega c","c.id = a.bodega_id")
		->join("unidad_medida d","d.id = b.unidad_medida_id")
		->join("estado_producto e","e.id = b.estado_producto_id")
		->join("marca_producto f","f.id = b.marca_producto_id")
		->where("b.activo", 1)
		->get("producto_bodega a");

		return verConsulta($tmp, $args);
	}

	public function ver_productos() {
		$this->load->model('producto/Producto_model');

		return $this->Producto_model->buscar();
	}

	public function ver_ubicacion($args=[]) {
		$this->load->model('bodega/Ubicacion_model');

		return $this->Ubicacion_model->_buscar($args);
	}

	public function ver_tipos_recepcion($args=[])
	{
		$tmp = $this->db
		->where("activo", 1)
		->get("recepcion_tipo");

		return verConsulta($tmp, $args);
	}

	public function ver_estado_despacho($args=[]) 
	{
		$tmp = $this->db
		->where("activo", 1)
		->get("estado_despacho");

		return verConsulta($tmp, $args);
	}

	public function ver_moneda($args=[]) 
	{
		$tmp = $this->db
		->get("moneda");

		return verConsulta($tmp, $args);
	}

	public function ver_pais($args=[]) 
	{

		$tmp = $this->db

		->where("activo", 1)
		->get("pais");

		return verConsulta($tmp, $args);
	}

	public function ver_pais_departamento($args=[]) 
	{
		if (elemento($args, 'pais_id')) {
			$this->db->where('pais_id', $args['pais_id']);
		}

		$tmp = $this->db
		->where("activo", 1)
		->get("pais_departamento");

		return verConsulta($tmp, $args);
	}

	public function ver_pais_municipio($args=[]) 
	{
		if (elemento($args, 'pais_id')) {
			$this->db->where('pais_id', $args['pais_id']);
		}

		if (elemento($args, 'pais_deparamento_id')) {
			$this->db->where('pais_deparamento_id', $args['pais_deparamento_id']);
		}

		$tmp = $this->db
		->where("activo", 1)
		->get("pais_municipio");

		return verConsulta($tmp, $args);
	}
}

/* End of file Catalogo_model.php */
/* Location: ./application/models/Catalogo_model.php */