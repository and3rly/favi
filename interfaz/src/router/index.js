import { createRouter, createWebHistory } from "vue-router";
import { useLoginStore } from "@/store/login";
import routes from "./route";

const router = createRouter({
  history: createWebHistory(import.meta.BASE_URL),
  base: import.meta.BASE_URL,
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition;
    } else {
      return { top: 0 };
    }
  },
});

router.beforeEach((to, from, next) => {
  
  const storeLogin = useLoginStore();

  if (to.meta.titulo) {
    document.title = "Favi  - " + to.meta.titulo;
  } else {
    document.title = "Favi";
  }

  if (to.name !== 'Login' && !storeLogin.isLoggedIn) {
    next({name:'Login'});
  } else if (to.name == 'Login' && storeLogin.isLoggedIn) {
      next({name:'Inicio'});
  }else {
    next();
  }
});

router.afterEach(() => {
  // Remove initial loading
  const appLoading = document.getElementById("loading-bg");
  if (appLoading) {
    appLoading.style.display = "none";
  }
});

export default router;
