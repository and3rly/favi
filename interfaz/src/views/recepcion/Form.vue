<template>
	<form @submit.prevent="guardar">
		<div class="mb-1 row">
			<label
				for="selectEstado" 
				class="col-sm-3 col-form-label fw-bold"
			>
				Estado: <span class="text-danger">*</span>
			</label>
			<div class="col-sm-9">
				<select 
					name="selectEstado" 
					id="selectEstado"
					class="form-select" 
					v-model="form.estado_recepcion_id"
					required
				>
					<option :value="null">------------------</option>
					<option v-for="i in cat.estado" :value="i.id"> {{ i.nombre }} </option>
				</select>
			</div>
		</div>

		<div class="mb-1 row">
			<label
				for="selectTransaccion" 
				class="col-sm-3 col-form-label fw-bold"
			>
				Transacción: <span class="text-danger">*</span>
			</label>
			<div class="col-sm-9">
				<select 
					name="selectTransaccion" 
					id="selectTransaccion"
					class="form-select" 
					v-model="form.tipo_transaccion_id"
					required
				>
					<option :value="null">------------------</option>
					<option v-for="i in cat.transaccion" :value="i.id"> {{ i.nombre }} </option>
				</select>
			</div>
		</div>

		<div class="mb-1 row">
			<label
				for="selectBodega" 
				class="col-sm-3 col-form-label fw-bold"
			>
				Bodega: <span class="text-danger">*</span>
			</label>
			<div class="col-sm-9">
				<select 
					name="selectBodega" 
					id="selectBodega"
					class="form-select" 
					v-model="form.bodega_id"
					required
				>
					<option :value="null">------------------</option>
					<option v-for="(i, idx) in cat.bodega" :value="i.id"> {{ i.nombre }} </option>
				</select>
			</div>
		</div>

		<div class="mb-1 row">
			<label
				for="selectVehiculo" 
				class="col-sm-3 col-form-label fw-bold"
			>
				Vehículo:
			</label>
			<div class="col-sm-9">
				<select 
					name="selectVehiculo" 
					id="selectVehiculo"
					class="form-select" 
					v-model="form.vehiculos_id"
				>
					<option :value="null">------------------</option>
					<option v-for="i in cat.vehiculo" :value="i.id"> {{ i.placa }} - {{ i.marca }} {{ i.model }} </option>
				</select>
			</div>
		</div>

		<div class="mb-1 row">
			<label
				for="selectPiloto" 
				class="col-sm-3 col-form-label fw-bold"
			>
				Piloto:
			</label>
			<div class="col-sm-9">
				<select 
					name="selectPiloto" 
					id="selectPiloto"
					class="form-select" 
					v-model="form.pilotos_id"
				>
					<option :value="null">------------------</option>
					<option v-for="i in cat.piloto" :value="i.id"> {{ i.nombres }} {{ i.apellidos }} </option>
				</select>
			</div>
		</div>

		<div class="mb-1 row">
			<label
				for="inputObservacion" 
				class="col-sm-3 col-form-label fw-bold"
			>
				Observación:
			</label>
			<div class="col-sm-9">
				<input 
					type="text" 
					class="form-control" 
					id="inputObservacion"
					v-model="form.observacion"
				/>
			</div>
		</div>

		<div class="mb-1 row">
			<label
				for="inputNoGuia" 
				class="col-sm-3 col-form-label fw-bold"
			>
				No. Guía:
			</label>
			<div class="col-sm-9">
				<input 
					type="text" 
					class="form-control" 
					id="inputNoGuia"
					v-model="form.no_guia"
				/>
			</div>
		</div>

		<div class="mb-1 row">
			<label
				for="inptuMarchamo" 
				class="col-sm-3 col-form-label fw-bold"
			>
				No. Marchamo:
			</label>
			<div class="col-sm-9">
				<input 
					type="text" 
					class="form-control" 
					id="inptuMarchamo"
					v-model="form.no_marchamo"
				/>
			</div>
		</div>

		<div class="mb-1 row">
			<label
				for="inputFechaRec" 
				class="col-sm-3 col-form-label fw-bold"
			>
				Fecha recepción:
			</label>
			<div class="col-sm-9">
				<input 
					type="date" 
					class="form-control" 
					id="inputFechaRec"
					v-model="form.fecha_recepcion"
				/>
			</div>
		</div>

		<div class="mb-1 row">
			<label
				for="inputHoraInicio" 
				class="col-sm-3 col-form-label fw-bold"
			>
				Hora inicio:
			</label>
			<div class="col-sm-9">
				<input 
					type="time" 
					class="form-control" 
					id="inputHoraInicio"
					v-model="form.hora_inicio"
				/>
			</div>
		</div>

		<div class="mb-1 row">
			<label
				for="inputHoraFin" 
				class="col-sm-3 col-form-label fw-bold"
			>
				Hora fin:
			</label>
			<div class="col-sm-9">
				<input 
					type="time" 
					class="form-control" 
					id="inputHoraFin"
					v-model="form.hora_fin"
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
							v-model="form.ingresa_stock"
							checked 
						>
						<label class="form-check-label" for="chkIngresaStock">Ingresa a stock</label>
					</div>
				</div>

				<div class="flex-fill me-4">
					<div class="form-check form-switch">
						<input 
							class="form-check-input" 
							type="checkbox" 
							role="switch" 
							id="chkAnulada" 
							:true-value="1" 
							:false-value="0"
							v-model="form.anulada"
							checked 
						>
						<label class="form-check-label" for="chkAnulada">Anulada</label>
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
						<label class="form-check-label" for="chkActivo">Activa</label>
					</div>
				</div>
			</div>
		</div>

		<div class="text-end mt-4 mb-1">
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
	import Helper from '@/mixins/Helper.js'

	export default {
		name: 'FormRecepcion',
		mixins: [Helper],
		props: {
			recepcion: {
				type: Object,
				required: false,
				default: null
			},
			cat: {
				type: Array,
				required: true
			}
		},
		data: () => ({

		}),
		created() {
			this.controlador = 'recepcion/principal'
			this.autoBuscar = false
			this._emit = true

			if (this.recepcion != null) {
				this.setDatosForm(this.recepcion)
			} else {
				this.fbase = {
					vehiculos_id: null,
					bodega_id: null,
					pilotos_id: null,
					tipo_transaccion_id: 1,
					estado_recepcion_id: 1,
					anulada: 0,
					detalle: []
				}
			}
		},
		methods: {
		}
	}
</script>