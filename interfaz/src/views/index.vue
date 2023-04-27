<template>
  <div>Lorem ipsum dolor sit amet consectetur adipisicing elit. In necessitatibus quas nesciunt molestiae quae nostrum suscipit quaerat, numquam maiores assumenda consectetur hic animi blanditiis, adipisci ipsum debitis quod placeat ad?</div>
  
  {{$store}}
</template>
<script>

export default {
  data() {
    return {
      usuario: {}
    };
  },
  created() {
    this.usuario = JSON.parse(localStorage.getItem('usuario'))
  },
};

</script>
<style lang=""></style>
