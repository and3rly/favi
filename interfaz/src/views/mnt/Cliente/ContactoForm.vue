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
					placeholder="nombre del contacto del cliente" 
					v-model="form.nombre"
				>
			</div>

			<div class="col-sm-4">
				<label for="inputCtelefono" class="fw-bold mb-1">
					Telefono: <span class="text-danger">*</span>
				</label>
				<input
					id="inputCtelefono" 
					type="number" 
					class="form-control"
					placeholder="telefono del contacto del cliente" 
					v-model="form.telefono"
				>
			</div>

			<div class="col-sm-4">
				<label for="inputCcorreo" class="fw-bold mb-1">
					Correo:  <span class="text-danger">*</span>
				</label>
				<input
					id="inputCcorreo" 
					type="email" 
					class="form-control"
					placeholder="correo del contacto del cliente" 
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
					<label class="form-check-label" for="flexSwitchCheckChecked">Activo</label>
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
				<th>Nombre</th>
				<th>Telefono</th>
				<th>Correo</th>
				<th>Activo</th>
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
					<td>{{ i.nombre }}</td>
					<td>{{ i.telefono }}</td>
					<td class="text-center">{{ i.email }}</td>
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

