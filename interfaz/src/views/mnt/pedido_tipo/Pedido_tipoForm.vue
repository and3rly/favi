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
					placeholder="Nombre del tipo de pedido" 
					v-model="form.nombre"
				>
			</div>
            <div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Descripcion: 
				</label>
				<input 
					type="text" 
					class="form-control"
					placeholder="Descripcion del tipo de Pedido" 
					v-model="form.descripcion"
				>
			</div>
            <div class="me-4">
				<div class="form-check form-switch">
					<input 
						class="form-check-input" 
						type="checkbox" 
						role="switch" 
						id="flexSwitchCheckChecked" 
						:true-value="1" 
						:false-value="0"
						v-model="form.reservar_stock"
						checked="false" 
					>
					<label class="form-check-label" for="flexSwitchCheckChecked">reservado</label>
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
		name:"Pedido_tipoForm",
		mixins: [General, Catalogo],
		props: {
			Pedido_tipo: {
				type: Object,
				required: false
			}
		},
		data: () => ({
		}),
		created() {
			this.controlador = 'mnt/pedido_tipo'
			this.autoBuscar = false
			this.setForm()

			if (this.Pedido_tipo) {
				this.pk = this.Pedido_tipo.id
				this.setDatosForm(this.Pedido_tipo);
			}
		},
		methods: {
			setForm() {
				this.form = {
					nombre: '',
                    descripcion:'',
					reservar_stock: 0
				}
			},
		}
	}
</script>

