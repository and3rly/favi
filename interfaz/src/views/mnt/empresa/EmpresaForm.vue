<template>
	<form @submit.prevent="guardar(true)">
		<div class="alert alert-info fw-bold py-2 mb-4" role="alert">
			<i class="fas fa-lightbulb me-2"></i>Todos los campos marcados con <span class="text-danger">*</span> son obligatorios.
		</div>

		<div class="row g-2 mb-4">
			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Nombre: <span class="text-danger">*</span>
				</label>
				<input 
					type="text" 
					class="form-control"
					placeholder="Nombre comercial" 
					v-model="form.nombre"
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Razón Social: <span class="text-danger">*</span>
				</label>
				<input 
					type="text" 
					class="form-control"
					placeholder="Razon social de la empresa" 
					v-model="form.razon_social"
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Representante: 
				</label>
				<input 
					type="text" 
					class="form-control"
					placeholder="Representante legal de la empresa" 
					v-model="form.representante"
					required
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					NIT: <span class="text-danger">*</span>
				</label>
				<input 
					type="text" 
					class="form-control"
					placeholder="Número de Identificación Tributaria" 
					v-model="form.nit"
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Dirección:
				</label>
				<input 
					type="text" 
					class="form-control"
					placeholder="Dirección para recibir notificaciones" 
					v-model="form.direccion"
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Teléfono: 
				</label>
				<input 
					type="number" 
					class="form-control"
					placeholder="teléfono principal de la empresa" 
					step="any"
					v-model="form.telefono"
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Correo:
				</label>
					<input
					type="email"
					class="form-control"
					placeholder="Correo principal de la empresa"
					step="any"
					v-model="form.correo"
					>
			</div>

		
			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Logo:
				</label>
				<input
					type="file"
					class="form-control"
					id="defaultFile"
					accept="image/*"
					@change="subirFoto"
				>
			</div>
		</div>		
		<div class="d-flex flex-row mb-3">
			<div class="me-4">
				<div class="form-check form-switch">
					<input 
						class="form-check-input" 
						type="checkbox" 
						role="switch" 
						id="flexSwitchCheckChecked" 
						:true-value="1" 
						:false-value="0"
						v-model="form.activo"
						checked 
					>
					<label class="form-check-label" for="flexSwitchCheckChecked">Activo</label>
				</div>
			</div>

		</div>
	    <div class="col-sm-2 offset-sm-2 mt-2">
	    	
	    </div>
		
		<div class="text-end mt-1 mb-1">
			<button 
				type="button" 
				class="btn btn-secondary me-2"
				@click="$emit('cerrar')"
			>
				<i class="fas fa-times me-1"></i>Cerrar
			</button>

			<button 
				type="submit" 
				class="btn btn-primary"
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
	import Catalogo from '@/mixins/Catalogo.js'

	export default {
		name:"EmpresaForm",
		mixins: [General, Catalogo],
		props: {
			empresa: {
				type: Object,
				required: false
			}
		},
		data: () => ({
		}),
		created() {
			this.controlador = 'mnt/empresa'
			this.autoBuscar = false
			this.setForm()

			if (this.empresa) {
				this.pk = this.empresa.id
				this.setDatosForm(this.empresa);
			}
		},
		methods: {
			setForm() {
				this.form = {
					nombre: '',
					razon_social: '',
					representante: '',
					nit: '',
					direccion: '',
					telefono: '',
					correo: '',
					activo: 1
				}
			},
			subirFoto(file) {
				if (file.target.files[0]) {
					this.form.imagen = file.target.files[0]
				}
			},
		}
	}
</script>

