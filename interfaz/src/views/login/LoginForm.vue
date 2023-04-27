<template>
  <form @submit.prevent="login" class="space-y-4">

    <div v-if="mensaje !== null" class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
      <span class="font-medium">{{mensaje}}</span>
    </div>

    <Textinput
      type="text"
      placeholder="Usuario"
      name="usuario"
      v-model="form.usuario"
      classInput="h-[48px]"
    />

    <Textinput
      type="password"
      placeholder="Contraseña"
      name="password"
      v-model="form.clave"
      classInput="h-[48px]"
    />
    <div class="flex justify-end">
      <div
        class="text-sm text-slate-800 dark:text-slate-400 leading-6 font-medium"
        >¿Olvidaste tu contraseña?
      </div>
    </div>

    <button type="submit" class="btn btn-dark block w-full text-center">
      Iniciar
    </button>

  </form>
</template>

<script>
import Textinput from "@/components/Textinput";
import { useLoginStore } from "@/store/login";

export default {
  data() {
    return {
      mensaje: null,
      form: {}
    };
  },
  methods: {
    login() {
      const storeLogin = useLoginStore();

      storeLogin.login(this.form)
      .then(res => {
        if (storeLogin.isLoggedIn) {
          this.$router.push({name: "Inicio"});
          this.$toast.success(res.mensaje , { timeout: 2000 });
        } else {
          this.mensaje = res.mensaje
        }
      })
    }
  },
   components: {
    Textinput,
  }
};
</script>
<style lang="scss"></style>
