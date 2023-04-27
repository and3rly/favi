const routes = [
  {
    path: '/login',
    name: 'Login',
    component: () => import('@/views/login/Login.vue'),
    meta: {titulo: "Iniciar sesión"}
  },
  {
    path: "/",
    name: "Layout",
    component: () => import("@/Layout/index.vue"),
    children: [
      {
        path: "/inicio",
        name: "Inicio",
        component: () => import("@/views/index.vue"),
        meta: {titulo: "Inicio"}
      },{
        path: "inicio",
        name: "Inicio",
        component: () => import("@/views/index.vue"),
        meta: {titulo: "Inicio"}
      },
    ],
  },
];

export default routes;
