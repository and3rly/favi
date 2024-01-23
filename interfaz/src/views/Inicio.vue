<template>
	<div class="container text-center mt-5">
		<h3> ¡Bienvenido {{usuario.nombre }} {{ usuario.apellido }}!</h3>
		<img 
			src="@/assets/images/inicio.png" 
			class="img-fluid mt-5" 
			style="width: 250px;"
		>
	</div>
</template>

<script>
	import { useLoginStore } from "@/stores/app-login";

	export default {
		data: () => ({
			usuario: null
		}),
	  created() {
	  	this.usuario = useLoginStore().usuario
	  }
	}
</script>