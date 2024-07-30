<template>
	<form @submit.prevent="guardar">
		<div class="row g-2 mb-4">
			<div class="col-sm-4">
				<label for="selectArea" class="fw-bold mb-1">
					Área: <span class="text-danger">*</span>
				</label>
				<select 
					name="selectArea" 
					id="selectArea" 
					class="form-select"
					v-model="form.bodega_area_id"
					required
				>	
					<option :value="null">Seleccione área...</option>
					<option 
						v-for="(i, idx) in cat.areas" 
						:value="i.id"
					>
						{{ i.codigo }} - {{ i.descripcion }}
					</option>
				</select>
			</div>

			<div class="col-sm-4">
				<label for="inputSCodigo" class="fw-bold mb-1">
					Código: <span class="text-danger">*</span>
				</label>
				<input
					id="inputSCodigo" 
					type="text" 
					class="form-control"
					v-model="form.codigo"
				>
			</div>

			<div class="col-sm-4">
				<label for="inputSDesc" class="fw-bold mb-1">
					Descripción: <span class="text-danger">*</span>
				</label>
				<input
					id="inputSDesc" 
					type="text" 
					class="form-control"
					v-model="form.descripcion"
				>
			</div>

			<div class="col-sm-4">
				<label for="inputSLargo" class="fw-bold mb-1">
					Largo (mts):
				</label>
				<input
					id="inputSLargo" 
					type="number" 
					class="form-control"
					v-model="form.largo"
				>
			</div>

			<div class="col-sm-4">
				<label for="inputSAncho" class="fw-bold mb-1">
					Ancho (mts):
				</label>
				<input
					id="inputSAncho" 
					type="number" 
					class="form-control"
					v-model="form.ancho"
				>
			</div>

			<div class="col-sm-4">
				<label for="inputSAlto" class="fw-bold mb-1">
					Alto (mts):
				</label>
				<input
					id="inputSAlto" 
					type="number" 
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

		<div class="text-end mt-3 mb-1">
			<button 
				v-if="pk != ''"
				type="button" 
				class="btn btn-secondary me-1"
				:disabled="btnGuardar"
				@click="limpiar"
			>	
				Cancelar / Nuevo
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

	<div class="table-responsive mt-4 rounded shadow-sm">
		<table class="table table-sm table-hover">
			<thead class="bg-light">
				<th class="text-center">#</th>
				<th>Código</th>
				<th>Descripción</th>
				<th>Área</th>
				<th class="text-center">Largo</th>
				<th class="text-center">Ancho</th>
				<th class="text-center">Alto</th>
				<th class="text-center">Activo</th>
			</thead>
			<tbody>
				<tr v-if="inicio === true">
					<td colspan="100" class="text-center">
			      <div class="spinner-border mt-3" role="status">
			        <span class="sr-only">Loading...</span>
			      </div>
			      <p>Cargando registros...</p>
					</td>
				</tr>
				<tr
					v-else
					v-for="(i, idx) in lista" 
					style="cursor: pointer;" 
					@click="setDatosForm(i)"
				>
					<td class="text-center">{{ idx + 1 }}</td>
					<td>{{ i.codigo }}</td>
					<td>{{ i.descripcion }}</td>
					<td>{{ i.codigo_area }} - {{ i.nombre_area }}</td>
					<td class="text-center">{{ i.largo }}</td>
					<td class="text-center">{{ i.ancho }}</td>
					<td class="text-center">{{ i.alto }}</td>
					<td class="text-center">
						<i v-if="i.activo == true" class="fas fa-check text-success"></i>
						<i v-else class="fas fa-times text-danger"></i>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script>
	import Helper from '@/mixins/Helper.js'

	export default {
		name: "FormSectoBodega",
		mixins: [Helper],
		props: {
			bodega: {
				type: Object,
				required: false
			},
			cat: {
				type: Array,
				required: false
			}
		},
		data:() => ({

		}),
		created() {
			this.controlador = 'bodega/sector'
			this._emit = true
			this._updLista = true

			this.fbuscar.bodega_id = this.bodega.id
			this.fbase.bodega_id = this.bodega.id
			this.fbase.bodega_area_id = null
			this.fbase.activo = 1
		},
		methods: {
		}
	} 
</script>