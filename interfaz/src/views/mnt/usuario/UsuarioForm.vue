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

		<div class="row mt-3">
			<div class="col-sm-12">
				<div class="alert alert-info p-2 mb-1 fw-bold m-0 rounded">
					<i class="fas fa-plus me-2"></i>Agregar sucursales
				</div>
			</div>
			
			<div class="col-sm-6">
				<ul class="list-group mt-3">
					<li 
						class="list-group-item active fw-bold" 
						aria-current="true"
					>
						Disponibles
					</li>

					<li class="list-group-item d-flex justify-content-between align-items-start">
						<div class="ms-2 me-auto">
							<div class="fw-bold">Sucursal 1</div>
						</div>
						<a 
							href="javascript:;"
							title="Asignar">
							<i class="fas fa-arrow-right" style="color: ;"></i>
						</a>
					</li>

				</ul>
			</div>
			<div class="col-sm-6">
				<ul class="list-group mt-3">
					<li 
						class="list-group-item active fw-bold" 
						aria-current="true"
					>
						Asignadas
					</li>

					<li class="list-group-item d-flex justify-content-between align-items-start">
						<a
							href="javascript:;"
							title="Quitar"
							class="ms-2 me-auto"
						>
							<i class="fas fa-arrow-left" style="color: red;"></i>
						</a>
						<div class="fw-bold">
						 	Sucursal 1
						</div>				
					</li>

				</ul>
			</div>
		</div>

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
	import Imagen from '@/components/general/Imagen.vue'

	export default {
		name: 'UsuarioForm',
		data: () => ({
			form: {},
			urlFoto: null,
			foto: null
		}),
		created() {
			console.log("hoal")
		},
		methods: {
			guardar() {
				console.log("Vamos a guardar :D")
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
			Imagen
		}
	}
</script>