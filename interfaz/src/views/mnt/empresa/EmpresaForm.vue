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
					Pais: <span class="text-danger">*</span>
				</label>
				<div class="col-sm-10">
					<select 
					name="selectPais" 
					id="selectPais" 
					class="form-select"
					v-model="form.pais_id"
					required
					>
					<option value="">Seleccione pais...</option>
					<option v-for="i in cat.pais" :value="i.id">{{i.nombre}}</option>
					</select>
				</div>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Departamento: <span class="text-danger">*</span>
				</label>
				<div class="col-sm-10">
					<select 
					name="selectDepartamento" 
					id="selectDepartamento" 
					class="form-select"
					v-model="form.pais_departamento_id"
					required
					>
					<option value="">Seleccione departamento...</option>
					<option v-for="i in cat.departamento" :value="i.id">{{i.nombre}}</option>
					</select>
				</div>
			</div>

			<div class="col-sm-6">
				<label for="" class="col-sm-2">
					Municipio: <span class="text-danger">*</span>
				</label>
				<div class="col-sm-10">
					<select 
					name="selectMunicipio" 
					id="selectMunicipio" 
					class="form-select"
					v-model="form.pais_municipio_id"
					required
					>
					<option value="">Seleccione municipio...</option>
					<option v-for="i in cat.municipio" :value="i.id">{{i.nombre}}</option>
					</select>
				</div>
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

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Eslogan:
				</label>
					<input
					type="text"
					class="form-control"
					placeholder="Eslogan de la empresa"
					step="any"
					v-model="form.eslogan"
					>
			</div>

			<div class="col-sm-6">
			<label for="" class="col-sm-2">
				Moneda: <span class="text-danger">*</span>
			</label>
			<div class="col-sm-10">
				<select 
					name="selectMoneda" 
					id="selectMoneda" 
					class="form-select"
					v-model="form.moneda_id"
					required
				>
					<option value="">Seleccione moneda...</option>
					<option v-for="i in cat.moneda" :value="i.id">{{i.nombre}}</option>
				</select>
			</div>
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
			 cat: [],
		}),
		created() {
			this.controlador = 'mnt/empresa'
			this.autoBuscar = false
			this.getDatos()
			this.setForm()

			if (this.empresa) {
				this.pk = this.empresa.id
				this.setDatosForm(this.empresa);
			}
		},
		methods: {
			getDatos() {

				this.$http
				.get(`${this.$baseUrl}/mnt/empresa/get_datos`)
				.then(res => {
					this.cat = res.data.cat
				}).catch(e => {
					console.log(e)
				})
			},
			setForm() {
				this.form = {
					nombre: '',
					razon_social: '',
					representante: '',
					nit: '',
					direccion: '',
					telefono: '',
					correo: '',
					moneda_id:1,
					pais_id:1,
					pais_departamento_id:1,
					pais_municipio_id:1,
					eslogan:'',
					activo: 1
				}
			},
			subirFoto(file) {
				if (file.target.files[0]) {
					this.form.logo = file.target.files[0]
				}
			},

		}
	}
</script>

