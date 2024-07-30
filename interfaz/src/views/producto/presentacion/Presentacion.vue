<template>
	<form @submit.prevent="guardar">
		<div class="form-group row mb-2">
			<label for="" class="fw-bold col-sm-2">
				Código: <span class="text-danger">*</span>
			</label>
			<div class="col-sm-10">
				<input 
					type="text" 
					class="form-control"
					v-model="form.codigo"
					required
				>
			</div>
		</div>

		<div class="form-group row mb-2">
			<label for="" class="fw-bold col-sm-2">
				Nombre: <span class="text-danger">*</span>
			</label>
			<div class="col-sm-10">
				<input 
					type="text" 
					class="form-control"
					v-model="form.nombre"
					required
				>
			</div>
		</div>

		<div class="form-group row mb-2">
			<label for="" class="fw-bold col-sm-2">
				Factor: <span class="text-danger">*</span>
			</label>
			<div class="col-sm-10">
				<input 
					type="number" 
					class="form-control"
					v-model="form.factor"
					required
				>
			</div>
		</div>

		<div class="row" v-if="pk != ''">
	    <div class="col-sm-2 offset-sm-2">
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
		
		<div class="text-end mt-3 mb-1">
			<button 
				type="button" 
				class="btn btn-secondary me-2"
				@click="limpiar"
			>
				Cancelar / Limpiar
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

	<div class="table-responsive-sm table-responsive-lg mt-3">
		<table class="table table-sm table-hover table-bordered mb-0">
			<thead class="bg-light">
				<tr>
					<th scope="col" class="text-center" width="40">#</th>
					<th scope="col" class="text-center" width="150">Código</th>
					<th scope="col">Nombre</th>
					<th scope="col" class="text-center">Factor</th>
					<th class="text-center">Activo</th>
				</tr>
			</thead>
			<tbody>
				<tr 
					v-for="(i, idx) in lista" 
					style="cursor: pointer;" 
					@click="setDatosForm(i)"
				>
					<th scope="row" class="text-center">{{idx + 1}}</th>
					<td class="text-center">{{ i.codigo }}</td>
					<td>
						{{i.nombre}}
					</td>
					<td class="text-center">{{ i.factor }}</td>
					<td class="text-center">
						<i v-if="i.activo == 1" class="fa fa-check text-success"></i>
            <i v-else class="fa fa-times text-danger" ></i>
					</td>		
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td v-if="cargando" colspan="100" class="text-center">
						<div class="d-flex justify-content-center mb-3 mt-3">
							<div class="spinner-border" role="status">
								<span class="visually-hidden">Loading...</span>
							</div>

						</div>
						Cargando información...
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</template>

<script>
	import Helper from '@/mixins/Helper.js'

	export default {
		name: 'Presentacion',
		mixins: [Helper],
		props: {
			producto: {
				type: Object,
				required: true
			}
		},
		data: () => ({
		}),
		created() {
			this.controlador = 'producto/presentacion'
			this.fbuscar.producto = this.producto.id

			this.fbase = {
				producto_id: this.producto.id,
				activo: 1
			}
		}
	}
</script>