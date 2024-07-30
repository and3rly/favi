<template>
	<form @submit.prevent="guardar">
		<div class="alert alert-info fw-bold py-2 mb-4" role="alert">
			<i class="fas fa-lightbulb me-2"></i>Todos los campos marcados con <span class="text-danger">*</span> son obligatorios.
		</div>

		<div class="row">
			<div class="col-sm-9">
				<label for="nombre" class="col-form-label mb-0 fw-bold">
					Nombre: <span class="text-danger">*</span>
				</label>
				<div class="col-sm-12">
					<input 
						type="text" 
						class="form-control" 
						id="nombre" 
						placeholder="Nombre usuario"
						v-model="form.nombre"
					>
				</div>
			</div>
		</div>

		<div class="text-end mt-5">
			<button 
				type="button" 
				class="btn btn-secondary me-2"
				@click="$emit('cerrar')"
			>
				<i class="fas fa-times me-1"></i>Cerrar
			</button>

			<button 
				type="submit" 
				class="btn btn-success"
				:disabled="btnGuardar"
			>	
					<span 
						v-if="btnGuardar"
						class="spinner-border spinner-border-sm me-1" 
						role="status" 
						aria-hidden="true"
					></span>
					<i v-else class="fas fa-save me-1"></i>

					<span v-if="btnGuardar">Guardando...</span>
					<span v-else>Guardar</span>
			</button>
		</div>

	</form>
</template>

<script>
	import General from '@/mixins/General.js'
	import Imagen from '@/components/general/Imagen.vue'

	export default {
		name: 'RolForm',
		mixins: [General],
		props: {
			rol: {
				type: Object,
				required: false
			}
		},	
		data: () => ({
			btnGuardar: false,
		}),
		created() {
			
			this.setForm()

			if (this.rol) {
				this.pk = this.rol.id			
				this.setDatosForm(this.rol);
			}

			this.controlador = 'mnt/rol'
		},
		methods: {
			guardar() {
				this.btnGuardar = true

				let datos = new FormData()

				for (let i in this.form) {
					datos.append(i, this.form[i]);
				}

				this.$http
				.post(`${this.$baseUrl}/${this.controlador}/guardar/${this.pk}`, datos)
				.then(res => {
					this.btnGuardar = false

					if (res.data.exito) {
						this.archivo = null

						if (res.data.linea) {
							this.$emit('actualizar', res.data.linea, this.pk)
							this.$emit('cerrar')
						}
						
					}
				}).catch(e => {
					this.btnGuardar = false
					console.log(e)
				})
			},
			setForm() {
				this.pk = ''
				this.form = {
					nombre: '',
					activo: 1
				}
				this.archivo = null
			}
		},
		components: {
			Imagen
		}
	}
</script>