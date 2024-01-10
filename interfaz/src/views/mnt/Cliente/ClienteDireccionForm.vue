<template>
	<form @submit.prevent="guardar">
		<div class="row g-2 mb-4">
			<div class="alert alert-info fw-bold py-1 mb-1" role="alert">
			<i class="fas fa-lightbulb me-2"></i>Rellenar todos los campos marcados con  <span class="text-danger">*</span>
		</div>
            <div class="col-sm-12">
				<label for="inputCdireccion" class="fw-bold mb-1">
					Dirección: 
				</label>
				<input
					id="inputCdireccion" 
					type="text" 
					class="form-control"
					placeholder="Colocar dirección completa" 
					v-model="form.direccion"
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
					placeholder="Avenida de residencia Ej: 2da" 
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
					placeholder="Calle de residencia Ej: 3ra" 
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
					placeholder="Número de casa si tuviera EJ: Nc.2" 
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
					placeholder="Zona de ubicacion Ej: z2" 
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
                    placeholder="Número de local dentro de un comercial" 
				
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
					placeholder="Ej: 300 mnts luego de la garita de entrada" 
					v-model="form.referencia"
				>
			</div>  

  
			<div class="col-sm-3">
				<label for="inputCcordenadax" class="fw-bold mb-1">
					Cordenada_X: 
				</label>
				<input
					id="inputCcordenadax" 
					type="text" 
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
					type="text" 
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
					<label class="form-check-label" for="flexSwitchCheckChecked">Activo  <span class="text-danger">*</span></label>
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

	<div class="table-responsive-sm table-responsive-lg">
		<table class="table table-sm table-hover" style="text-align: center;">
			<thead class="bg-light">
				<th class="text-center">#</th>
				<th>Zona</th>
				<th>Avenida</th>
				<th >Calle</th>
				<th >No.Casa</th>
                <th >Local</th>
                <th >Dirección</th>
				<th >Activo</th>
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
					<td>{{ i.zona }}</td>
					<td>{{ i.avenida }}</td>
					<td class="text-center">{{ i.calle }}</td>
					<td class="text-center">{{ i.no_casa }}</td>
                    <td class="text-center">{{ i.local }}</td>
                    <td class="text-center">{{ i.direccion }}</td>
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

