<template>
	<form @submit.prevent="guardar(true)">
		<div class="row g-2 mb-4">
			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Código:
				</label>
				<input type="text" class="form-control" placeholder="Código del proveedor" v-model="form.codigo">
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Nombre: <span class="text-danger">*</span>
				</label>
				<input 
					type="text"
					class="form-control" 
					placeholder="Nombre del proveedor" 
					v-model="form.nombre"
					required
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Empresa:  <span class="text-danger">*</span>
				</label>
				<select 
					name="selectEmpresa"
				 	id="selectEmpresa"
				  class="form-select"
				  v-model="form.empresa_id" 
				  required
				>
					<option value="">Seleccione empresa...</option>
					<option v-for="(i, idx) in cat.empresa" :value="i.id">{{ i.nombre }}</option>
				</select>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Teléfono:
				</label>
				<input type="number" class="form-control" placeholder="Teléfono del proveedor" v-model="form.telefono">
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					NIT:
				</label>
				<input type="text" class="form-control" placeholder="Numero de nit del proveedor" v-model="form.nit">
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Dirección:
				</label>
				<input type="text" class="form-control" placeholder="Dirección del proveedor" step="any"
					v-model="form.direccion">
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Correo:
				</label>
				<input type="email" class="form-control" placeholder="Correo del proveedor" step="any" v-model="form.email">
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Contacto:
				</label>
				<input type="text" class="form-control" placeholder="Nombre del contacto del representante del proveedor"
					step="any" v-model="form.contacto">
			</div>
		</div>

		<div class="d-flex flex-row mb-3">
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
		<div class="col-sm-2 offset-sm-2 mt-2">

		</div>

		<div class="text-end mt-1 mb-1">
			<button type="button" class="btn btn-secondary me-2" @click="$emit('cerrar')">
				<i class="fas fa-times me-1"></i>Cerrar
			</button>

			<button 
			type="submit" 
			class="btn btn-primary"
			 :disabled="btnGuardar">
				<span
				 v-if="btnGuardar"
				  class="spinner-border spinner-border-sm me-1" 
				  role="status"
					aria-hidden="true"></span>
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
		name: 'ProveedorForm',
		mixins: [General,Catalogo],
		props: {
			proveedor: {
				type: Object,
				required: false
			}
		},	
		data: () => ({
			
		}),
		
		created() {
			this.controlador = 'mnt/proveedor'
			this.getCatalogo(['empresa'])
			this.setForm()
		
			if (this.proveedor) {
				this.pk = this.proveedor.id			
				this.setDatosForm(this.proveedor);
			}	
		},
		methods: {
			setForm() {
			this.form = {
				codigo: '',
				nombre: '',
				telefono: '',
				nit: '',
				direccion: '',
				email: '',
				contacto: '',
				muestra_precio: 1,
				activo: 1,
				empresa_id: ''
			}
		},
		}
	}
</script>