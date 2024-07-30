<template>
	<form @submit.prevent="guardar">
		<div class="row g-2 mb-4">
			<div class="col-sm-4">
				<label for="inputCnombre" class="fw-bold mb-1">
					Nombre: <span class="text-danger">*</span>
				</label>
				<input
					id="inputCnombre" 
					type="text" 
					class="form-control"
					v-model="form.nombre"
					required
				>
			</div>

			<div class="col-sm-4">
				<label for="inputCtelefono" class="fw-bold mb-1">
					Teléfono: <span class="text-danger">*</span>
				</label>
				<input
					id="inputCtelefono" 
					type="text" 
					class="form-control"
					v-model="form.telefono"
					required
				>
			</div>

			<div class="col-sm-4">
				<label for="inputCcorreo" class="fw-bold mb-1">
					Correo: 
				</label>
				<input
					id="inputCcorreo" 
					type="email" 
					class="form-control"
					v-model="form.email"
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

	<div class="table-responsive-sm mt-2">
		<table class="table table-sm table-hover table-bordered">
			<thead class="bg-light">
				<tr>
					<th class="text-center">#</th>
					<th>Nombre de contacto</th>
					<th>Teléfono</th>
					<th>Correo</th>
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
					<td class="text-center">{{ idx + 1 }}</td>
					<td>{{ i.nombre }}</td>
					<td>{{ i.telefono }}</td>
					<td>{{ i.email }}</td>
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
		name:"ContactoForm",
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
			this.controlador = "mnt/cliente_contacto"
			
			if (this.cliente != null) {			
				this.fbase.cliente_id = this.cliente.id
				this.fbase.activo = 1

				this.fbuscar.cliente_id = this.cliente.id
			}
		}
	}
</script>

