<template>
	<form @submit.prevent="guardar">
		<div class="alert alert-info fw-bold py-2 mb-4" role="alert">
			<i class="fas fa-lightbulb me-2"></i>Todos los campos marcados con <span class="text-danger">*</span> son obligatorios.
		</div>

		<div class="row">
			<div class="col-sm-3 text-center">
				<div class="mb-2">
					<Imagen
						:imagen="sdfg"
						:archivo="foto"
						:clase="'rounded mx-auto d-block'"
						:estilo="'width: 60%;'"
					/>							
				</div>

				<div class="d-grid gap-1">
					<label
						class="btn btn-sm btn-theme mt-2"
						for="defaultFile"
					>
						<i class="fa fa-image"></i> Actualizar foto
					</label>

					<input
						type="file"
						class="form-control"
						id="defaultFile"
						style="display:none;"
						accept="image/*"
						@change="subirFoto"
					>

					<button
						class="btn btn-sm btn-secondary btn-block"
					>
						<i class="fa fa-trash"></i> Borrar foto
					</button>
				</div>
			</div>

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

				<label for="apellido" class="col-form-label fw-bold">
					Apellido: <span class="text-danger">*</span>
				</label>
				<div class="col-sm-12">
					<input 
						type="text"
						class="form-control" 
						id="apellido"
						placeholder="Apellido usuario"
						v-model="form.apellido"
					>
				</div>

				<label for="usuario" class="col-form-label fw-bold">
					Usuario: <span class="text-danger">*</span>
				</label>
				<div class="col-sm-12">
					<input 
						type="text" 
						class="form-control" 
						id="usuario"
						placeholder="Se generará automáticamente"									
						disabled
					>
				</div>

				<label for="telefono" class="col-form-label fw-bold">
					Teléfono:
				</label>
				<div class="col-sm-12">
					<input 
						type="number" 
						class="form-control" 
						id="telefono" 
						placeholder="Teléfono usuario"
						v-model="form.telefono"
					>
				</div>

				<label for="correo" class="col-form-label fw-bold">
					Correo:
				</label>
				<div class="col-sm-12">
					<input 
						type="email" 
						class="form-control" 
						id="correo" 
						placeholder="Correo electrónico usuario"
						v-model="form.correo"
					>
				</div>
			</div>
		</div>

		<UsuarioSucursal v-if="pk > 0"/>

		<div class="text-end mt-4">
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
			>
				<i class="fas fa-save me-1"></i>Guardar
			</button>
		</div>
	</form>
</template>

<script>
	import UsuarioSucursal from '@/views/mnt/usuario/UsuarioSucursal.vue'
	import General from '@/mixins/General.js'
	import Imagen from '@/components/general/Imagen.vue'

	export default {
		name: 'UsuarioForm',
		mixins: [General],
		data: () => ({
			form: {},
			btnGuardar: false,
			urlFoto: null,
			foto: null
		}),
		created() {
			this.controlador = 'usuario'
		},
		methods: {
			guardar() {
				this.btnGuardar = true

				let datos = new FormData()

				for (let i in this.form) {
						datos.append(i, this.form[i]);
				}

				if (this.foto) {
					datos.append('foto', this.foto)
				}

				this.$http
				.post(`${this.$baseUrl}/${this.controlador}/guardar`, datos)
				.then(res => {
					this.btnGuardar = false

					if (res.data.exito) {
						this.pk = 1
					}

				}).catch(e => {
					this.btnGuardar = false
					console.log(e)
				})
			},
			subirFoto(file) {
				if (file.target.files[0]) {
					this.foto = file.target.files[0]

					this.urlFoto = URL.createObjectURL(this.foto);
				}
			},
			limpiarFoto() {
				console.log('entro aca')
				this.foto = null
			}
		},
		components: {
			Imagen,
			UsuarioSucursal
		}
	}
</script>