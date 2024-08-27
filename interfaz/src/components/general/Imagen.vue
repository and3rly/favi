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
					this.urlFoto = 'https://lh3.googleusercontent.com/d/'+this.imagen
				} else {
					this.urlFoto = "/assets/img/image.png"
				}

				console.log(this.urlFoto)
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