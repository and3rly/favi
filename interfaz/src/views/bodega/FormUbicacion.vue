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
					<div class="flex-fill me-2">
						<div class="form-check form-switch">
							<input 
								class="form-check-input" 
								type="checkbox" 
								role="switch" 
								id="chkControlVence" 
								:true-value="1" 
								:false-value="0"
								v-model="form.control_vence"
								checked 
							>
							<label class="form-check-label" for="chkControlVence">Activo</label>
						</div>
					</div>

					<div class="flex-fill me-4">
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
							<label class="form-check-label" for="flexSwitchCheckChecked">Dañada</label>
						</div>
					</div>

					<div class="flex-fill me-2">
						<div class="form-check form-switch">
							<input 
								class="form-check-input" 
								type="checkbox" 
								role="switch" 
								id="chkControlVence" 
								:true-value="1" 
								:false-value="0"
								v-model="form.control_vence"
								checked 
							>
							<label class="form-check-label" for="chkControlVence">Bloqueada</label>
						</div>
					</div>

					<div class="flex-fill me-2">
						<div class="form-check form-switch">
							<input 
								class="form-check-input" 
								type="checkbox" 
								role="switch" 
								id="chkControlVence" 
								:true-value="1" 
								:false-value="0"
								v-model="form.control_vence"
								checked 
							>
							<label class="form-check-label" for="chkControlVence">Virtual</label>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</template>

<script>
	import Helper from '@/mixins/Helper.js'

	export default {
		name:"FormUbicBodega",
		mixins: [Helper],
		props: {
			cat: {
				type: Array,
				required: false
			}
		},
		created() {
			this.autoBuscar = false
			this.controlador = 'bodega/ubicacion'

			this.fbase.rotacion_id = null
			this.fbase.bodega_area_id = null
			this.fbase.bodega_sector_id = null
			this.fbase.bodega_tramo_id = null
		}
	}
</script>