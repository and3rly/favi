import { createRouter, createWebHistory } from "vue-router";

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
            component: () => import('@/views/Home.vue'),
            meta: {titulo: 'Inicio'}
          },
          { 
            path: '/inicio',
            name: 'Inicio',
            component: () => import('@/views/Home.vue'),
            meta: {titulo: 'Inicio'}
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

  if (to.meta.titulo) {
    document.title = "Favi  - " + to.meta.titulo;
  } else {
    document.title = "Favi";
  }
    next();
});

export default router;
