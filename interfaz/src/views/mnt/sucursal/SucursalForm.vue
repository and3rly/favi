<template>
	<form @submit.prevent="guardar(false)">
		<div class="alert alert-info fw-bold py-2 mb-4" role="alert">
			<i class="fas fa-lightbulb me-2"></i>Todos los campos marcados con <span class="text-danger">*</span> son obligatorios.
		</div>

		<div class="form-group row">
			<label for="" class="fw-bold col-sm-2">
				Nombre: <span class="text-danger">*</span>
			</label>
			<div class="col-sm-10">
				<input 
					type="text" 
					class="form-control"
					placeholder="Nombre de la sucursal" 
					v-model="form.nombre"
					required
				>
			</div>
		</div>

		<div class="form-group row mt-1">
			<label for="" class="fw-bold col-sm-2">
				Razón Social:
			</label>
			<div class="col-sm-10">
				<input 
					type="text" 
					class="form-control" 
					placeholder="Razón social de la sucursal"
					v-model="form.razon_social"
				>
			</div>
		</div>

		<div class="form-group row mt-2 fw-bold">
			<label for="" class="col-sm-2">
				Empresa: <span class="text-danger">*</span>
			</label>
			<div class="col-sm-10">
				<select 
					name="selectEmpresa" 
					id="selectEmpresa" 
					class="form-select"
					v-model="form.empresa_id"
					required
				>
					<option value="">Seleccione empresa...</option>
					<option v-for="i in cat.empresa" :value="i.id">{{i.nombre}}</option>
				</select>
			</div>
		</div>

		<div class="form-group row mt-1">
			<label for="" class="fw-bold col-sm-2">
				Encargado:
			</label>
			<div class="col-sm-10">
				<input 
					type="text" 
					class="form-control"
					placeholder="Nombre engarcado de la sucursal" 
					v-model="form.encargado"
				>
			</div>
		</div>

		<div class="form-group row mt-1">
			<label for="" class="fw-bold col-sm-2">
				Dirección:
			</label>
			<div class="col-sm-10">
				<input
					type="text" 
					class="form-control"
					placeholder="Dirección de la sucursal"
					v-model="form.direccion"
				>
			</div>
		</div>

		<div class="form-group row mt-1">
			<label for="" class="fw-bold col-sm-2">
				Teléfono:
			</label>
			<div class="col-sm-10">
				<input 
					type="text" 
					class="form-control"
					placeholder="Teléfono de la sucursal" 
					v-model="form.telefono"
				>
			</div>
		</div>

		<div class="form-group row mt-2">
			<label for="" class="fw-bold col-sm-2">
				Correo:
			</label>
			<div class="col-sm-10">
				<input 
					type="text" 
					class="form-control"
					placeholder="Correo de la sucursal" 
					v-model="form.correo"
				>
			</div>
		</div>

		<div class="row">
		    <div class="col-sm-2 offset-sm-2 mt-2">
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
		name:"SucursalForm",
		mixins: [Catalogo, General],
		props: {
			sucursal: {
				type: Object,
				required: false
			}
		},
		data: () => ({
		}),
		created() {
			this.controlador = 'mnt/sucursal'
			this.autoBuscar = false
			this.getCatalogo(['empresa'])
			this.setForm()

			if (this.sucursal) {
				this.pk = this.sucursal.id
				this.setDatosForm(this.sucursal);
			}
		},
		methods: {
			setForm() {
				this.form = {
					nombre: '',
					razon_social: '',
					telefono: '', 
					direccion: '',
					encargado: '',
					correo: '',
					empresa_id: '',
					activo: 1
				}
			}
		},
		watch: {
			'cat.empresa'(lista) {
				if (lista.length == 1) {
					this.form.empresa_id = lista[0].id
				}	
			}
		}
	}
</script>