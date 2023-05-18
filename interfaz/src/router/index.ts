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
      path: '',
      name: 'Start',
      redirect: '/inicio'
    },
    {
      path:'/',
      component: () => import('@/views/Index.vue'),
      children: [
          { 
            path: '/',
            name: 'Inicio',
            component: () => import('@/views/Inicio.vue'),
            meta: {titulo: 'Inicio'}
          },
          { 
            path: '/inicio',
            name: 'Inicio',
            component: () => import('@/views/Inicio.vue'),
            meta: {titulo: 'Inicio'}
          },
          { 
            path: '/usuario',
            name: 'Usuario',
            component: () => import('@/views/mnt/Usuario.vue'),
            meta: {titulo: 'Usuario'}
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
