<template>
	<img 
		:src="urlFoto"
		:class="clase"
		:style="estilo" 
	>
</template>

<script>
	export default {
		name:"Imagen",
		props: {
			imagen: {
				type: String,
				required: false
			},
			clase: {
				type: String,
				required: false
			},
			estilo: {
				type: String,
				required: false,
			},
			archivo: {
				type: Array
			}
		},
		data: () => ({
			urlFoto: ''
		}),
		created() {
			this.setFoto()
		},
		methods: {
			setFoto() {
				if (this.imagen) {
					this.urlFoto = 'https://drive.google.com/uc?export=view&id='+this.imagen
				} else {
					this.urlFoto = 'src/assets/images/usuario.png'
				}
			}
		},
		watch: {
			archivo(valor) {
				if (valor) {
					this.urlFoto = URL.createObjectURL(valor);
				}
			}
		}
	}	
</script>