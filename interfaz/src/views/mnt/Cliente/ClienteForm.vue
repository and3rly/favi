<template>
	<form @submit.prevent="guardar(true)">
		<div class="alert alert-info fw-bold py-2 mb-4" role="alert">
			<i class="fas fa-lightbulb me-2"></i>Rellenar todos los campos
		</div>

		<div class="row g-2 mb-4">
			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Código:
				</label>
				<input type="text" class="form-control" placeholder="Código del Cliente" v-model="form.codigo">
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Nombre:
				</label>
				<input type="text" class="form-control" placeholder="Nombre del Cliente" v-model="form.nombre_comercial">
			</div>


			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Teléfono:
				</label>
				<input type="number" class="form-control" placeholder="Teléfono del Cliente" v-model="form.telefono">
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					NIT:
				</label>
				<input type="text" class="form-control" placeholder="numero de identificación tributaria" v-model="form.nit">
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Dirección:
				</label>
				<input type="text" class="form-control" placeholder="Dirección del Cliente" step="any"
					v-model="form.direccion">
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Correo:
				</label>
				<input type="email" class="form-control" placeholder="Correo del Cliente" step="any" v-model="form.email">
			</div>



			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Tipo de Cliente:
				</label>
				<select name="selecttipoCliente"
				 id="selecttipoCliente"
				  class="form-select"
				   v-model="form.cliente_tipo_id" required>
					<option value="">Seleccione tipo de cliente...</option>
					<option v-for="(i, idx) in cat.cliente_tipo" :value="i.id">{{ i.nombre }}</option>
				</select>
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
					<label class="form-check-label" for="flexSwitchCheckChecked">Activo</label>
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
			this.controlador = 'mnt/Cliente'
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