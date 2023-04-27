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
            <div class="text-center 2xl:mb-10 mb-4">
              <h4 class="font-medium">Iniciar Sesión</h4>
              <div class="text-slate-500 text-base">
                POS - Facturación de Ventas e Inventario
              </div>
            </div>
            <LoginForm/>
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
import LoginForm from "../login/LoginForm";

export default {
  name:"Login",
  components: {
    LoginForm
  }
};
</script>
<style lang="scss"></style>
