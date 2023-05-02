<template>
  <div>Lorem ipsum dolor sit amet consectetur adipisicing elit. In necessitatibus quas nesciunt molestiae quae nostrum suscipit quaerat, numquam maiores assumenda consectetur hic animi blanditiis, adipisci ipsum debitis quod placeat ad?</div>

  {{$pinia.state}}
</template>
<script>
import { useLoginStore } from "@/store/login";
  
export default {
  data() {
    return {
    };
  }, 
  created() {
    const storeLogin = useLoginStore();
    storeLogin.validaToken()
    
    if (!storeLogin.isLoggedIn) {
      this.$router.push({ name: 'Login' });
    }
  }
};


</script>
<style lang=""></style>
