<template>
	<form @submit.prevent="guardar(false)">
		<div class="alert alert-info fw-bold py-2 mb-4" role="alert">
			<i class="fas fa-lightbulb me-2"></i>Todos los campos marcados con <span class="text-danger">*</span> son obligatorios.
		</div>

		<div class="form-group row mb-2">
			<label for="" class="fw-bold col-sm-2">
				Nombre: <span class="text-danger">*</span>
			</label>
			<div class="col-sm-10">
				<input 
					type="text" 
					class="form-control"
					placeholder="Nombre del estado producto" 
					v-model="form.nombre"
					required
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
		    <div class="col-sm-2 mt-2">
		    	<div class="form-check form-switch">
					<input 
						class="form-check-input" 
						type="checkbox" 
						role="switch" 
						id="chkUtilizable" 
						:true-value="1" 
						:false-value="0"
						v-model="form.utilizable"
						checked 
					>
					<label class="form-check-label" for="chkUtilizable">Utilizable</label>
				</div>
		    </div>
		    <div class="col-sm-2 mt-2">
		    	<div class="form-check form-switch">
					<input 
						class="form-check-input" 
						type="checkbox" 
						role="switch" 
						id="chkDanado" 
						:true-value="1" 
						:false-value="0"
						v-model="form.danado"
						checked 
					>
					<label class="form-check-label" for="chkDanado">Dañado</label>
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

	export default {
		name:"EstadoForm",
		mixins: [General],
		props: {
			estado: {
				type: Object,
				required: false
			}
		},
		data: () => ({
		}),
		created() {
			this.controlador = 'producto/estado'
			this.autoBuscar = false
			this.setForm()

			if (this.estado) {
				this.pk = this.estado.id
				this.setDatosForm(this.estado);
			}
		},
		methods: {
			setForm() {
				this.form = {
					nombre: '',
					utilizable: 1,
					danado: 0,
					activo: 1
				}
			}
		}
	}
</script>