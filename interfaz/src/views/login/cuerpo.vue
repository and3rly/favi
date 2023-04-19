<template>
  <form @submit.prevent="test" class="space-y-4">
    <Textinput
      label="Email"
      type="email"
      placeholder="Type your email"
      name="emil"
      v-model="email"
      :error="emailError"
      classInput="h-[48px]"
    />
    <Textinput
      label="Password"
      type="password"
      placeholder="8+ characters, 1 capitat letter "
      name="password"
      v-model="password"
      :error="passwordError"
      classInput="h-[48px]"
    />

    <div class="flex justify-end">
      <router-link
        to="/forgot-password"
        class="text-sm text-slate-800 dark:text-slate-400 leading-6 font-medium"
        >Forgot Password?</router-link
      >
    </div>

    <button type="submit" class="btn btn-dark block w-full text-center">
      Sign in
    </button>

  </form>
</template>

<script>
import Textinput from "@/components/Textinput";
import { useField, useForm } from "vee-validate";
import * as yup from "yup";

export default {
  components: {
    Textinput,
  },
  data() {
    return {
      checkbox: false,
    };
  },
  methods: {
    test() {
      this.$http.get("/api/favi/index.php/welcome/test")
      .then((response) => {
        console.log(response);
        this.$toast.success(" Login  successfully", {
            timeout: 2000,
          });

        this.$router.push({name: 'home'});
      })
      .catch((err) => console.log(err));
    }
  }
};
</script>
<style lang="scss"></style>
