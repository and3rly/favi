import { createRouter, createWebHistory } from "vue-router";
import { useLoginStore } from "@/stores/app-login";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      name: 'Login',
      component: () => import('@/views/login/Login.vue'),
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
            component: () => import('@/views/bodega/bodega/Bodega.vue'),
            meta: {titulo: 'Bodega'}
          },
        ]
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
