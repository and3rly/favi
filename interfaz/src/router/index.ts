import { createRouter, createWebHistory } from "vue-router";
import { useLoginStore } from "@/stores/app-login";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      name: 'Login',
      component: () => import('@/views/login/login.vue'),
      meta: {titulo: 'Iniciar Sesión'}
    },
    {
      path:'/',
      component: () => import('@/views/Principal.vue'),
      children: [
          { 
            path: '/inicio',
            name: 'Inicio',
            component: () => import('@/views/Inicio.vue'),
            meta: {titulo: 'Inicio'}
          },
          { 
            path: '/usuario',
            name: 'Usuario',
            component: () => import('@/views/mnt/usuario/Usuario.vue'),
            meta: {titulo: 'Usuario'}
          },
          { 
            path: '/sucursal',
            name: 'Sucursal',
            component: () => import('@/views/mnt/sucursal/Sucursal.vue'),
            meta: {titulo: 'Sucursal'}
          },
          { 
            path: '/unidad_medida',
            name: 'UnidadMedida',
            component: () => import('@/views/producto/um/Um.vue'),
            meta: {titulo: 'Unidad medida'}
          },
          { 
            path: '/tipo_producto',
            name: 'TipoPoducto',
            component: () => import('@/views/producto/tipo/Tipo.vue'),
            meta: {titulo: 'Tipo producto'}
          },
          { 
            path: '/marca',
            name: 'MarcaProducto',
            component: () => import('@/views/producto/marca/Marca.vue'),
            meta: {titulo: 'Marca producto'}
          },
          { 
            path: '/presentacion',
            name: 'PresentacionProducto',
            component: () => import('@/views/producto/presentacion/Presentacion.vue'),
            meta: {titulo: 'Presentación'}
          },
          { 
            path: '/clasificacion',
            name: 'ClasificacionProd',
            component: () => import('@/views/producto/clasificacion/Clasificacion.vue'),
            meta: {titulo: 'Clasificación'}
          },
          { 
            path: '/familia',
            name: 'FamiliaProd',
            component: () => import('@/views/producto/familia/Familia.vue'),
            meta: {titulo: 'Familia'}
          },
          { 
            path: '/estado',
            name: 'EstadoProducto',
            component: () => import('@/views/producto/estado/Estado.vue'),
            meta: {titulo: 'Estado'}
          },
          { 
            path: '/producto',
            name: 'Producto',
            component: () => import('@/views/producto/producto/Producto.vue'),
            meta: {titulo: 'Producto'}
          },
          { 
            path: '/bodega',
            name: 'Bodega',
            component: () => import('@/views/bodega/Cuerpo.vue'),
            meta: {titulo: 'Bodega'}
          },
          { 
            path: '/empresa',
            name: 'Empresa',
            component: () => import('@/views/mnt/empresa/Empresa.vue'),
            meta: {titulo: 'Empresa'}
          },
          { 
            path: '/rol',
            name: 'Rol',
            component: () => import('@/views/mnt/rol/Cuerpo.vue'),
            meta: {titulo: 'Rol'}
          },
          { 
            path: '/proveedor',
            name: 'Proveedor',
            component: () => import('@/views/mnt/proveedor/Proveedor.vue'),
            meta: {titulo: 'Proveedor'}
          },
           
          { 
            path: '/ruta',
            name: 'Ruta',
            component: () => import('@/views/mnt/ruta/Ruta.vue'),
            meta: {titulo: 'Ruta'}
          },
		      { 
            path: '/vehiculos',
            name: 'Vehiculos',
            component: () => import('@/views/mnt/Vehiculos/Vehiculos.vue'),
            meta: {titulo: 'Vehiculos'}
          },
          { 
            path: '/pilotos',
            name: 'Pilotos',
            component: () => import('@/views/mnt/Pilotos/Pilotos.vue'),
            meta: {titulo: 'Pilotos'}
          },   { 
            path: '/tipo_transaccion',
            name: 'tipo_transaccion',
            component: () => import('@/views/mnt/tipo_transaccion/Tipo_transaccion.vue'),
            meta: {titulo: 'tipo_transaccion'}
          },
          { 
            path: '/empleado',
            name: 'Empleado',
            component: () => import('@/views/mnt/empleado/Empleado.vue'),
            meta: {titulo: 'Empleado'}
          },
          { 
            path: '/anulacion_pedido',
            name: 'Anulacion de pedido',
            component: () => import('@/views/mnt/motivo_anulacion_pedido/Motivo_anulacion_pedido.vue'),
            meta: {titulo: 'anulacion pedido'}
          },
          { 
            path: '/motivo_devolucion',
            name: 'Motivo de devolucion',
            component: () => import('@/views/mnt/motivo_devolucion/Motivo_devolucion.vue'),
            meta: {titulo: 'motivo de devolucion'}
          },
          { 
            path: '/pedido_tipo',
            name: 'Tipo de Pedido',
            component: () => import('@/views/mnt/pedido_tipo/Pedido_tipo.vue'),
            meta: {titulo: 'tipo de Pedido'}
          },
          { 
            path: '/cliente_tipo',
            name: 'Tipo de Cliente',
            component: () => import('@/views/mnt/Cliente/cliente_tipo/Cliente_tipo.vue'),
            meta: {titulo: 'tipo de Cliente'}
          },
          { 
            path: '/cliente',
            name: 'Cliente',
            component: () => import('@/views/mnt/Cliente/Cliente.vue'),
            meta: {titulo: 'Cliente'}
          },
          {
            path: '/orden_compra',
            name: 'Orden Compra',
            component: () => import('@/views/orden/OrdenCompra.vue'),
            meta: {titulo: 'Orden Compra'}
          },
          {
            path: '/recepcion',
            name: 'Recepción',
            component: () => import('@/views/recepcion/Cuerpo.vue'),
            meta: {titulo: 'Recepción'}
          },
          {
            path: '/despacho',
            name: 'Despacho',
            component: () => import('@/views/despacho/Cuerpo.vue'),
            meta: {titulo: 'Despacho'}
          },
          {
            path: '/pedido',
            name: 'Pedido',
            component: () => import('@/views/pedido/Cuerpo.vue'),
            meta: {titulo: 'Pedido'}
          },
          {
            path: '/modulo',
            name: 'Módulo',
            component: () => import('@/views/mnt/menu/Cuerpo.vue'),
            meta: {titulo: 'Módulo'}
          },
          {
            path: '/existencia',
            name: 'Existencia',
            component: () => import('@/views/reportes/existencia/Existencia.vue'),
            meta: {titulo: 'Existencia'}
          },
        ]
    },
    { 
      path: '/menubar',
      name: 'Menubar',
      component: () => import('@/components/app/Sidebar.vue'),
      meta: {titulo: 'Menu'}
    },
		{ 
      path: '/:pathMatch(.*)*', 
      component: () => import('@/views/PageError.vue') 
    }
  ],
});

router.beforeEach((to, from, next) => {

  const loginStore = useLoginStore();

  if (to.meta.titulo) {
    document.title = "Favi  - " + to.meta.titulo;
  } else {
    document.title = "Favi";
  }

  if (to.name !== 'Login' && !loginStore.isLoggedIn) {
    next({name:'Login'});
  } else if (to.name == 'Login' && loginStore.isLoggedIn) {
      next({name:'Inicio'});
  } else {
    next();
  }

});

export default router;
