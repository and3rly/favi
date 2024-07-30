<template>
	<form @submit.prevent="guardar">
		<div class="row g-2 mb-3">
			<div class="col-sm-3">
				<label for="selectEmpresa" class="fw-bold mb-1">
					Empresa: <span class="text-danger">*</span>
				</label>
				<select 
					name="selectEmpresa" 
					id="selectEmpresa" 
					class="form-select"
					v-model="form.empresa_id"
					required
				>	
					<option value="">Seleccione empresa...</option>
					<option v-for="(i, idx) in cat.empresas" :value="i.id">{{ i.nombre }}</option>
				</select>
			</div>

			<div class="col-sm-3">
				<label for="inputCodigo" class="fw-bold mb-1">
					Código:
				</label>
				<input
					id="inputCodigo" 
					type="text" 
					class="form-control"
					v-model="form.codigo"
				>
			</div>
			<div class="col-sm-6">
				<label for="inputNombre" class="fw-bold mb-1">
					Nombre: <span class="text-danger">*</span>
				</label>
				<input
					id="inputNombre"
					type="text" 
					class="form-control"
					v-model="form.nombre"
					required
				>
			</div>
			<div class="col-sm-3">
				<label for="inputDir" class="fw-bold mb-1">
					Dirección: <span class="text-danger">*</span>
				</label>
				<input 
					id="inputDir"
					type="text" 
					class="form-control"
					v-model="form.direccion"
					required
				>
			</div>

			<div class="col-sm-3">
				<label for="inputTelefono" class="fw-bold mb-1">
					Teléfono: <span class="text-danger">*</span>
				</label>
				<input 
					id="inputTelefono"
					type="text" 
					class="form-control"
					v-model="form.telefono"
					required
				>
			</div>

			<div class="col-sm-6">
				<label for="inputEncargado" class="fw-bold mb-1">
					Encargado: <span class="text-danger">*</span>
				</label>
				<input 
					id="inputEncargado"
					type="text" 
					class="form-control"
					v-model="form.encargado"
					required
				>
			</div>

			<div class="col-sm-3">
				<label for="inputCorreo" class="fw-bold mb-1">
					Correo: 
				</label>
				<input 
					id="inputCorreo"
					type="text" 
					class="form-control"
					v-model="form.correo"
				>
			</div>

			<div class="col-sm-3">
				<label for="inputLargo" class="fw-bold mb-1">
					Largo: 
				</label>
				<input 
					id="inputLargo"
					type="text" 
					class="form-control"
					v-model="form.largo"
				>
			</div>

			<div class="col-sm-3">
				<label for="inputAncho" class="fw-bold mb-1">
					Ancho: 
				</label>
				<input 
					id="inputAncho"
					type="text" 
					class="form-control"
					v-model="form.ancho"
				>
			</div>

			<div class="col-sm-3">
				<label for="inputAlto" class="fw-bold mb-1">
					Alto: 
				</label>
				<input 
					id="inputAlto"
					type="text" 
					class="form-control"
					v-model="form.alto"
				>
			</div>

			<div class="d-flex flex-row mb-3" v-if="pk != ''">
				<div class="me-4">
					<div class="form-check form-switch">
						<input 
						class="form-check-input"
						 type="checkbox" role="switch"
						  id="flexSwitchCheckChecked"
							:true-value="1" 
							:false-value="0" 
							v-model="form.activo"
							 checked>
						<label class="form-check-label fw-bold" for="flexSwitchCheckChecked">Activo</label>
					</div>
				</div>
			</div>
		</div>
		<div class="text-end mt-1 mb-1">
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
	import Helper from '@/mixins/Helper.js'

	export default {
		name: "FormBodega",
		mixins: [Helper],
		props: {
			cat: {
				type: Array,
				required: false
			},
			bodega: {
				type: Object,
				required: false,
				default: null
			}
		},
		data:() => ({

		}),
		created() {
			this.autoBuscar = false
			this._emit = true
			this.controlador = 'bodega/bodega'
			this.setForm()
			
			if (this.bodega != null) {
				this.pk = this.bodega.id
				this.setDatosForm(this.bodega)
			}
		},
		methods: {
			setForm() {
				this.form = {
					empresa_id: '',
					codigo: '',
					nombre: '',
					direccion: '',
					telefono: '',
					encargado: '',
					correo: '',
					largo: 0,
					ancho: 0,
					alto: 0,
					activo: 1
				}
			}
		},
		watch: {
			bodega(valor) {
      	this.setDatosForm(valor)
   		},
		}
	}
</script>