<template>
	<form @submit.prevent="guardar(true)">
			
			<div class="mb-1 row">
			<label
				for="selectEstado" 
				class="col-sm-3 col-form-label fw-bold"
			>
				Tipo de vehiculo:
			</label>
			<div class="col-sm-9">
				<select 
					name="selectEstado" 
					id="selectEstado"
					class="form-select" 
					v-model="form.tipo"
					required
				>
				
					<option :value="Automovil">Automóvil</option>
					<option :value="Camion">Camión</option>
					<option :value="Autobus">Autobús</option>
					<option :value="Motocicleta">Motocicleta</option>
					<option :value="Contenedor">Remolque</option>
					<option :value="Trailer">tráiler</option>
				</select>
			</div>
		</div>
			
		<div class="mb-1 row">
			<label
				for="inputObservacion" 
				class="col-sm-3 col-form-label fw-bold"
			>
				Placa:
			</label>
			<div class="col-sm-9">
				<input 
					type="text" 
					class="form-control" 
					id="inputObservacion"
					v-model="form.placa"
					required
				/>
			</div>
		</div>
		<div class="mb-1 row">
			<label
				for="inputObservacion" 
				class="col-sm-3 col-form-label fw-bold"
			>
				Marca: 
			</label>
			<div class="col-sm-9">
				<input 
					type="text" 
					class="form-control" 
					id="inputObservacion"
					v-model="form.marca"
					required
				/>
			</div>
		</div>

	

		<div class="mb-1 row">
			<label
				for="inputObservacion" 
				class="col-sm-3 col-form-label fw-bold"
			>
				Modelo|Año:
			</label>
			<div class="col-sm-9">
				<input 
					type="text" 
					class="form-control" 
					id="inputObservacion"
					v-model="form.modelo"
					required
				/>
			</div>
		</div>
			
		<div class="mb-1 row">
			<label
				for="inputObservacion" 
				class="col-sm-3 col-form-label fw-bold"
			>
				Peso:
			</label>
			<div class="col-sm-9">
				<input 
					type="text" 
					class="form-control" 
					id="inputObservacion"
					v-model="form.peso"
					required
				/>
			</div>
		</div>
		<div class="mb-1 row">
			<label
				for="inputObservacion" 
				class="col-sm-3 col-form-label fw-bold"
			>
				Volumen:
			</label>
			<div class="col-sm-9">
				<input 
					type="text" 
					class="form-control" 
					id="inputObservacion"
					v-model="form.volumen"
					required
				/>
			</div>
		</div>
		<div class="mb-1 row">
			<label
				for="inputObservacion" 
				class="col-sm-3 col-form-label fw-bold"
			>
				Alto:
			</label>
			<div class="col-sm-9">
				<input 
					type="text" 
					class="form-control" 
					id="inputObservacion"
					v-model="form.alto"
					required
				/>
			</div>
		</div>
		<div class="mb-1 row">
			<label
				for="inputObservacion" 
				class="col-sm-3 col-form-label fw-bold"
			>
				largo:
			</label>
			<div class="col-sm-9">
				<input 
					type="text" 
					class="form-control" 
					id="inputObservacion"
					v-model="form.largo"
					required
				/>
			</div>
		</div>	<div class="mb-1 row">
			<label
				for="inputObservacion" 
				class="col-sm-3 col-form-label fw-bold"
			>
				Ancho:
			</label>
			<div class="col-sm-9">
				<input 
					type="text" 
					class="form-control" 
					id="inputObservacion"
					v-model="form.ancho"
					required
				/>
			</div>
		</div>	<div class="mb-1 row">
			<label
				for="inputObservacion" 
				class="col-sm-3 col-form-label fw-bold"
			>
				Placa Comercial:
			</label>
			<div class="col-sm-9">
				<input 
					type="text" 
					class="form-control" 
					id="inputObservacion"
					v-model="form.placa_comercial"
					required
				/>
			</div>
		</div>
		<div class="col-sm-9 offset-sm-3 mt-2">
			<div class="d-flex p-1">
				<div class="flex-fill me-2">
					<div class="form-check form-switch">
						<input 
							class="form-check-input" 
							type="checkbox" 
							role="switch" 
							id="chkIngresaStock" 
							:true-value="1" 
							:false-value="0"
							v-model="form.es_contenedor"
							checked 
						>
						<label class="form-check-label" for="chkIngresaStock">Es contenedor</label>
					</div>
				</div>

				<div class="flex-fill me-2">
					<div class="form-check form-switch">
						<input 
							class="form-check-input" 
							type="checkbox" 
							role="switch" 
							id="chkActivo" 
							:true-value="1" 
							:false-value="0"
							v-model="form.activo"
							checked 
						>
						<label class="form-check-label" for="chkActivo">Activo</label>
					</div>
				</div>
			</div>
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
		name: 'VehiculoForm',
		mixins: [General,Catalogo],
		props: {
			vehiculo: {
				type: Object,
				required: false
			}
		},	
		data: () => ({
			
		}),
		
		created() {
			this.controlador = 'mnt/Vehiculo'
			this.setForm()
		
			if (this.vehiculo) {
				this.pk = this.vehiculo.id			
				this.setDatosForm(this.vehiculo);
			}	
		},
		methods: {
			setForm() {
			this.form = {
				tipo: '',
				placa: '',
				marca: '',
				modelo: '',
				peso: '',
				volumen: '',
				alto: '',
				largo: '',
				ancho: '',
				placa_comercial: '',
				es_contenedor: 0,
				activo: 1
			}
		},
		}
	}
</script>