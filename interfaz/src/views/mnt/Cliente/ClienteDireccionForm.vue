<template>
	<form @submit.prevent="guardar">
		<div class="row g-2 mb-4">
      <div class="col-sm-12">
				<label for="inputCdireccion" class="fw-bold mb-1">
					Dirección:  <span class="text-danger">*</span>
				</label>
				<input
					id="inputCdireccion" 
					type="text" 
					class="form-control"
					v-model="form.direccion"
					required
				>
			</div>
            
            <div class="col-sm-3">
				<label for="inputCAvenida" class="fw-bold mb-1">
					Avenida: 
				</label>
				<input
					id="inputCAvenida" 
					type="text" 
					class="form-control"
					v-model="form.avenida"
				>
			</div>

			<div class="col-sm-3">
				<label for="inputCcalle" class="fw-bold mb-1">
					Calle: 
				</label>
				<input
					id="inputCcalle" 
					type="text" 
					class="form-control"
					v-model="form.calle"
				>
			</div>

			<div class="col-sm-3">
				<label for="inputCcasa" class="fw-bold mb-1">
					No.Casa: 
				</label>
				<input
					id="inputCcasa" 
					type="text" 
					class="form-control"
					v-model="form.no_casa"
				>
			</div>

            
			<div class="col-sm-3">
				<label for="inputCzona" class="fw-bold mb-1">
					Zona: 
				</label>
				<input
					id="inputCzona" 
					type="text" 
					class="form-control"
					v-model="form.zona"
				>
			</div>    

            <div class="col-sm-3">
				<label for="inputCLocal" class="fw-bold mb-1">
					Local: 
				</label>
				<input
					id="inputCLocal" 
					type="text" 
					class="form-control"
					v-model="form.local"
				>
			</div> 


            
			<div class="col-sm-3">
				<label for="inputCRef" class="fw-bold mb-1">
					Referencia: 
				</label>
				<input
					id="inputCRef" 
					type="text" 
					class="form-control"
					v-model="form.referencia"
				>
			</div>  

  
			<div class="col-sm-3">
				<label for="inputCcordenadax" class="fw-bold mb-1">
					Cordenada_X: 
				</label>
				<input
					id="inputCcordenadax" 
					type="number" 
					class="form-control"
					v-model="form.coordenada_x"
				>
			</div>  
            <div class="col-sm-3">
				<label for="inputCcordenaday" class="fw-bold mb-1">
					Cordenada_Y: 
				</label>
				<input
					id="inputCcordenaday" 
					type="number" 
					class="form-control"
					v-model="form.coordenada_y"
				>
			</div> 
			<div class="d-flex flex-row mb-3">
			<div class="me-4">
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

	<div class="table-responsive-sm mt-3">
		<table class="table table-sm table-hover table-bordered">
			<thead class="bg-light">
				<tr>
					<th class="text-center">#</th>
					<th >Dirección</th>
					<th class="text-center">Zona</th>
					<th class="text-center">Avenida</th>
					<th class="text-center">Calle</th>
					<th class="text-center">No.Casa</th>
	        <th class="text-center">Local</th>
					<th class="text-center">Estado</th>
				</tr>
			</thead>
			<tbody>
				<tr>
          <td colspan="100%" class="text-center p-3" v-if="lista.length == 0 && !inicio">
            No se encontraron registros
          </td>
        </tr>

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
					<th class="text-center">{{ idx + 1 }}</th>
					<td>{{ i.direccion }}</td>
					<td class="text-center">{{ i.zona }}</td>
					<td class="text-center">{{ i.avenida }}</td>
					<td class="text-center">{{ i.calle }}</td>
					<td class="text-center">{{ i.no_casa }}</td>
          <td class="text-center">{{ i.local }}</td>
					<td class="text-center">
						<span 
							v-if="i.activo == 1"
							class="badge bg-success text-success-800 bg-opacity-25 px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center"
						>
							<i class="fa fa-check-circle text-success fs-10px fa-fw me-5px"></i> Activo
						</span>

						<span 
							v-else
							class="badge bg-danger text-danger-800 bg-opacity-25 px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center"
						>
							<i class="fa fa-times-circle text-danger fs-10px fa-fw me-5px"></i> Inactivo
						</span>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script>
	import Helper from '@/mixins/Helper.js'

	export default {
		name:"ClienteDireccionForm",
		mixins: [Helper],
		props: {
			cliente: {
				type: Object,
				required: false,
				default: null
			}
		},
		data: () => ({

		}),
		created() {
			this.controlador = "mnt/cliente_direccion"
			
			if (this.cliente != null) {			
				this.fbase.cliente_id = this.cliente.id
				this.fbase.activo = 1

				this.fbuscar.cliente_id = this.cliente.id
			}
		}
	}
</script>

