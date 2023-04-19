<template>
  <div class="loginwrapper">
    <div class="lg-inner-column">
      <div class="left-column relative z-[1]">
        <div
          class="absolute left-0 2xl:bottom-[-160px] bottom-[-130px] h-full w-full z-[-1]"
        >
          <img
            src="@/assets/images/auth/ils1.svg"
            alt=""
            class="h-full w-full object-contain"
          />
        </div>
      </div>
      <div class="right-column relative">
        <div
          class="inner-content h-full flex flex-col bg-white dark:bg-slate-800"
        >
          <div class="auth-box h-full flex flex-col justify-center">
            <div class="mobile-logo text-center mb-6 lg:hidden block">
              <router-link to="/">
              </router-link>
            </div>
            <div class="text-center 2xl:mb-10 mb-4">
              <h4 class="font-medium">Iniciar Sesión</h4>
              <div class="text-slate-500 text-base">
                Sign in to your account to start using Dashcode
              </div>
            </div>
            <cuerpo />
            <div
              class="relative border-b-[#9AA2AF] border-opacity-[16%] border-b pt-6"
            >
              <div
                class="absolute inline-block bg-white dark:bg-slate-800 dark:text-slate-400 left-1/2 top-1/2 transform -translate-x-1/2 px-4 min-w-max text-sm text-slate-500 font-normal"
              >
                Or continue with
              </div>
            </div>
            <div
              class="md:max-w-[345px] mx-auto font-normal text-slate-500 dark:text-slate-400 mt-12 uppercase text-sm"
            >
              Don’t have an account? Sign up
              <router-link
                to="/register"
                class="text-slate-900 dark:text-white font-medium hover:underline"
              >
                Sign up
              </router-link>
            </div>
          </div>
          <div class="auth-footer text-center">
            Copyright 2023, Favi todos los derechos reservados.
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import cuerpo from "../login/cuerpo";
//import Social from "../common/Social";

export default {
  components: {
    cuerpo
  },
};
</script>
<style lang="scss"></style>
