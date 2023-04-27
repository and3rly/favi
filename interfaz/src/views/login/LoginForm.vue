<template>
  <form @submit.prevent="test" class="space-y-4">
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
      checkbox: false,
      form: {}
    };
  },
  methods: {
    test() {
      const storeLogin = useLoginStore();

      storeLogin.login(this.form)
      .then(res => {
        if (storeLogin.isLoggedIn) {
          this.$store.login = storeLogin
          this.$router.push({name: "Inicio"});
          this.$toast.success(storeLogin.mensaje , { timeout: 2000 });
        } else {
          alert(storeLogin.mensaje)
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
