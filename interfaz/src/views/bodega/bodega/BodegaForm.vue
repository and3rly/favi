<template>
	<form @submit.prevent="guardar(false)">
		<div class="alert alert-info fw-bold py-2 mb-4" role="alert">
			<i class="fas fa-lightbulb me-2"></i>Todos los campos marcados con <span class="text-danger">*</span> son obligatorios.
		</div>

		<div class="row g-2 mb-4">
			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
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
					<option 
						v-for="(i, idx) in cat.empresa" 
						:key="idx" 
						:value="i.id"
					>
						{{i.nombre}}
					</option>
				</select>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Código: <span class="text-danger">*</span>
				</label>
				<input 
					type="text" 
					class="form-control"
					placeholder="Código de bodega" 
					v-model="form.codigo"
					required
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Nombre: <span class="text-danger">*</span>
				</label>
				<input 
					type="text" 
					class="form-control"
					placeholder="Nombre de bodega" 
					v-model="form.nombre"
					required
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Dirección: 
				</label>
				<input 
					type="text" 
					class="form-control"
					placeholder="Dirección de bodega" 
					v-model="form.direccion"
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Teléfono: 
				</label>
				<input 
					type="text" 
					class="form-control"
					placeholder="Teléfono de bodega" 
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
					placeholder="Correo electrónico de bodega" 
					v-model="form.correo"
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Encargado: 
				</label>
				<input 
					type="text" 
					class="form-control"
					placeholder="Encargado de bodega" 
					v-model="form.encargado"
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Largo: 
				</label>
				<input 
					type="number" 
					class="form-control"
					step="any"
					placeholder="Largo de bodega" 
					v-model="form.largo"
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Ancho: 
				</label>
				<input 
					type="number" 
					class="form-control"
					step="any"
					placeholder="Ancho de bodega" 
					v-model="form.ancho"
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Alto: 
				</label>
				<input 
					type="number" 
					class="form-control"
					step="any"
					placeholder="Alto de bodega" 
					v-model="form.alto"
				>
			</div>

			<div class="col-sm-6 mt-3">
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
		name:"BodegaForm",
		mixins: [General, Catalogo],
		props: {
			bodega: {
				type: Object,
				required: false
			}
		},
		data: () => ({
		}),
		created() {
			this.controlador = 'bodega/bodega'
			this.autoBuscar = false
			this.getCatalogo(['empresa'])
			this.setForm()

			if (this.bodega) {
				this.pk = this.bodega.id
				this.setDatosForm(this.bodega);
			}
		},
		methods: {
			setForm() {
				this.form = {
					codigo: '',
					nombre: '',
					direccion: '',
					telefono: '',
					correo: '',
					encargado: '',
					largo: 0,
					ancho: 0,
					alto: 0,
					empresa_id: '',
					activo: 1
				}
			}
		}
	}
</script>