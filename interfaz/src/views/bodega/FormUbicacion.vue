<template>
	<form @submit.prevent="guardar">
		<div class="row g-2 mb-4">
			<div class="col-sm-4">
				<label for="selectRotacion" class="fw-bold mb-1">
					Rotación: <span class="text-danger">*</span>
				</label>
				<select 
					name="selectRotacion" 
					id="selectRotacion" 
					class="form-select"
					v-model="form.rotacion_id"
					required
				>	
					<option :value="null">Seleccione rotación...</option>
					<option 
						v-for="(i, idx) in cat.rotacion" 
						:value="i.id"
					>
						{{ i.codigo }} - {{ i.nombre }}
					</option>
				</select>
			</div>

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
				<label for="selectSector" class="fw-bold mb-1">
					Sector: <span class="text-danger">*</span>
				</label>
				<select 
					name="selectSector" 
					id="selectSector" 
					class="form-select"
					v-model="form.bodega_sector_id"
					required
				>	
					<option :value="null">Seleccione sector...</option>
					<option 
						v-for="(i, idx) in cat.sectores" 
						:value="i.id"
					>
						{{ i.codigo }} - {{ i.descripcion }}
					</option>
				</select>
			</div>

			<div class="col-sm-4">
				<label for="selectTramo" class="fw-bold mb-1">
					Tramo: <span class="text-danger">*</span>
				</label>
				<select 
					name="selectTramo" 
					id="selectTramo" 
					class="form-select"
					v-model="form.bodega_tramo_id"
					required
				>	
					<option :value="null">Seleccione tramo...</option>
					<option 
						v-for="(i, idx) in cat.tramos" 
						:value="i.id"
					>
						{{ i.codigo }} - {{ i.descripcion }}
					</option>
				</select>
			</div>

			<div class="col-sm-4">
				<label for="inputCodigo" class="fw-bold mb-1">
					Código: <span class="text-danger">*</span>
				</label>
				<input
					id="inputCodigo" 
					type="text" 
					class="form-control"
					v-model="form.codigo"
				>
			</div>

			<div class="col-sm-4">
				<label for="inputDesc" class="fw-bold mb-1">
					Descripción: <span class="text-danger">*</span>
				</label>
				<input
					id="inputDesc" 
					type="text" 
					class="form-control"
					v-model="form.descripcion"
				>
			</div>

			<div class="col-sm-4">
				<label for="inputNivel" class="fw-bold mb-1">
					Nivel:
				</label>
				<input
					id="inputNivel" 
					type="number" 
					class="form-control"
					v-model="form.nivel"
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

			<div class="col-sm-8">
				<label for="parametros" class="fw-bold mb-1">
					Parámetros:
				</label>
				<div class="d-flex flex-row mt-2">
					<div class="flex-fill me-2" v-if="pk != ''">
						<div class="form-check form-switch">
							<input 
								class="form-check-input" 
								type="checkbox" 
								role="switch" 
								id="chkActivo" 
								:true-value="1" 
								:false-value="0"
								v-model="form.activa"
								checked 
							>
							<label class="form-check-label" for="chkActivo">Activo</label>
						</div>
					</div>

					<div class="flex-fill me-4">
						<div class="form-check form-switch">
							<input 
								class="form-check-input" 
								type="checkbox" 
								role="switch" 
								id="chkDanada" 
								:true-value="1" 
								:false-value="0"
								v-model="form.danado"
								checked 
							>
							<label class="form-check-label" for="chkDanada">Dañada</label>
						</div>
					</div>

					<div class="flex-fill me-2">
						<div class="form-check form-switch">
							<input 
								class="form-check-input" 
								type="checkbox" 
								role="switch" 
								id="chkBloqueada" 
								:true-value="1" 
								:false-value="0"
								v-model="form.bloqueada"
								checked 
							>
							<label class="form-check-label" for="chkBloqueada">Bloqueada</label>
						</div>
					</div>

					<div class="flex-fill me-2">
						<div class="form-check form-switch">
							<input 
								class="form-check-input" 
								type="checkbox" 
								role="switch" 
								id="chkVirtual" 
								:true-value="1" 
								:false-value="0"
								v-model="form.virtual"
								checked 
							>
							<label class="form-check-label" for="chkVirtual">Virtual</label>
						</div>
					</div>

					<div class="flex-fill me-2">
						<div class="form-check form-switch">
							<input 
								class="form-check-input" 
								type="checkbox" 
								role="switch" 
								id="chkpicking" 
								:true-value="1" 
								:false-value="0"
								v-model="form.ubicacion_picking"
								checked 
							>
							<label class="form-check-label" for="chkpicking">Ubicación de Picking</label>
						</div>
					</div>

					<div class="flex-fill me-2">
						<div class="form-check form-switch">
							<input 
								class="form-check-input" 
								type="checkbox" 
								role="switch" 
								id="chkrecepcion" 
								:true-value="1" 
								:false-value="0"
								v-model="form.ubicacion_recepcion"
								checked 
							>
							<label class="form-check-label" for="chkrecepcion">Ubicación de Recepción</label>
						</div>
					</div>

					<div class="flex-fill me-2">
						<div class="form-check form-switch">
							<input 
								class="form-check-input" 
								type="checkbox" 
								role="switch" 
								id="chkdespacho" 
								:true-value="1" 
								:false-value="0"
								v-model="form.ubicacion_despacho"
								checked 
							>
							<label class="form-check-label" for="chkdespacho">Ubicación de Despacho</label>
						</div>
					</div>

					<div class="flex-fill me-2">
						<div class="form-check form-switch">
							<input 
								class="form-check-input" 
								type="checkbox" 
								role="switch" 
								id="chkmerma" 
								:true-value="1" 
								:false-value="0"
								v-model="form.ubicacion_merma"
								checked 
							>
							<label class="form-check-label" for="chkmerma">Ubicación de Merma</label>
						</div>
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
				<th>Sector</th>
				<th>Tramo</th>
				<th class="text-center">Nivel</th>
				<th class="text-center">Largo</th>
				<th class="text-center">Ancho</th>
				<th class="text-center">Alto</th>
				<th class="text-center">Dañado</th>
				<th class="text-center">Bloqueada</th>
				<th class="text-center">Virtual</th>
				<th class="text-center">Activo</th>
				<th class="text-center">Picking</th>
				<th class="text-center">Recepcion</th>
				<th class="text-center">Despacho</th>
				<th class="text-center">Merma</th>
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
					<td>{{ i.codigo_sector }} - {{ i.nombre_sector }}</td>
					<td>{{ i.codigo_tramo }} - {{ i.nombre_tramo }}</td>
					<td class="text-center">{{ i.nivel }}</td>
					<td class="text-center">{{ i.largo }}</td>
					<td class="text-center">{{ i.ancho }}</td>
					<td class="text-center">{{ i.alto }}</td>
					<td class="text-center">
						<i v-if="i.danado == true" class="fas fa-check text-success"></i>
						<i v-else class="fas fa-times text-danger"></i>
					</td>
					<td class="text-center">
						<i v-if="i.bloqueada == true" class="fas fa-check text-success"></i>
						<i v-else class="fas fa-times text-danger"></i>
					</td>
					<td class="text-center">
						<i v-if="i.virtual == true" class="fas fa-check text-success"></i>
						<i v-else class="fas fa-times text-danger"></i>
					</td>
					<td class="text-center">
						<i v-if="i.activa == true" class="fas fa-check text-success"></i>
						<i v-else class="fas fa-times text-danger"></i>
					</td>
					<td class="text-center">
						<i v-if="i.ubicacion_picking == true" class="fas fa-check text-success"></i>
						<i v-else class="fas fa-times text-danger"></i>
					</td>
					<td class="text-center">
						<i v-if="i.ubicacion_recepcion == true" class="fas fa-check text-success"></i>
						<i v-else class="fas fa-times text-danger"></i>
					</td>
					<td class="text-center">
						<i v-if="i.ubicacion_despacho == true" class="fas fa-check text-success"></i>
						<i v-else class="fas fa-times text-danger"></i>
					</td>
					<td class="text-center">
						<i v-if="i.ubicacion_merma == true" class="fas fa-check text-success"></i>
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
		name:"FormUbicBodega",
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
		created() {
			this.controlador = 'bodega/ubicacion'
			this.fbuscar.bodega_id = this.bodega.id
			
			this.fbase = {
				rotacion_id: null,
				bodega_id: this.bodega.id,
				bodega_area_id: null,
				bodega_sector_id: null,
				bodega_tramo_id: null,
				danada: 0,
				bloqueada: 0,
				virtual: 0,
				ubicacion_picking: 0,
				ubicacion_recepcion:0,
				ubicacion_despacho:0,
				ubicacion_merma: 0,
				activa: 1
			}
		}
	}
</script>