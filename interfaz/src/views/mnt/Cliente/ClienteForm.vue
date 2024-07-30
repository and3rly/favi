<template>
	<form @submit.prevent="guardar(true)">
		<div class="row g-2 mb-4">
			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Código:  
				</label>
				<input type="text" class="form-control" placeholder="Código del cliente" v-model="form.codigo"   >
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Nombre: <span class="text-danger">*</span>
				</label>
				<input 
					type="text" 
					class="form-control" 
					placeholder="Nombre del cliente"
					v-model="form.nombre_comercial"      
					required
				/>
			</div>

			<div class="col-sm-6">
				<label for="inputNit" class="fw-bold mb-1">
					NIT: <span class="text-danger">*</span>
				</label>
				<input 
					id="inputNit"
					type="text" 
					class="form-control"
					placeholder="Numero de identificación tributaria" 
					v-model="form.nit"
					required 
				/>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Tipo de Cliente: <span class="text-danger">*</span>
				</label>
				<select name="selecttipoCliente"
				 id="selecttipoCliente"
				  class="form-select"
				   v-model="form.cliente_tipo_id" required>
				   <option value="">Seleccione tipo de cliente...</option>
					<option v-for="(i, idx) in cat.cliente_tipo" :value="i.id">{{ i.nombre }}</option>
				</select>				
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Teléfono:
				</label>
				<input type="text" class="form-control" placeholder="Teléfono del cliente" v-model="form.telefono">
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Dirección:
				</label>
				<input type="text" class="form-control" placeholder="Dirección del cliente" step="any"
					v-model="form.direccion">
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Correo:
				</label>
				<input type="email" class="form-control" placeholder="Correo del cliente" step="any" v-model="form.email">
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
					<label class="form-check-label" for="flexSwitchCheckChecked">Activo <span class="text-danger">*</span></label>
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
		name: 'ClienteForm',
		mixins: [General,Catalogo],
		props: {
			cliente: {
				type: Object,
				required: false
			}
		},	
		data: () => ({
			
		}),
		
		created() {
			this.controlador = 'mnt/cliente'
			this.autoBuscar = true
			this.getCatalogo(['cliente_tipo'])
			this.setForm()
		
			if (this.cliente) {
				this.pk = this.cliente.id			
				this.setDatosForm(this.cliente);
			}

			
		}
		
		
		,
		methods: {
			setForm() {
			this.form = {
				codigo: '',
				nombre_comercial: '',
				telefono: '',
				nit: '',
				direccion: '',
				email: '',
				activo: 1,
				cliente_tipo_id: ''
			}
		},
		}
	}
</script>