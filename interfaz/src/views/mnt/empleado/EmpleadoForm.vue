<template>
	<form @submit.prevent="guardar(true)">
		<div class="alert alert-info">
        <i class="fas fa-lightbulb me-2"></i>Todos los campos marcados con <span class="text-danger">*</span> son obligatorios.
</div>
    <div class="mb-1 row">
        <label
            for="inputNombre" 
            class="col-sm-3 col-form-label fw-bold"
        >
            Nombre: <span class="text-danger">*</span>
        </label>
        <div class="col-sm-9">
            <input 
                type="text" 
                class="form-control" 
                id="inputNombre"
                v-model="form.nombre"
                required
            />
        </div>
     </div>
	 <div class="mb-1 row">
        <label
            for="inputApellido" 
            class="col-sm-3 col-form-label fw-bold"
        >
            Apellido: <span class="text-danger">*</span>
        </label>
        <div class="col-sm-9">
            <input 
                type="text" 
                class="form-control" 
                id="inputApellido"
                v-model="form.apellido"
                required
            />
        </div>
     </div>
	 <div class="mb-1 row">
        <label
            for="inputCorreo" 
            class="col-sm-3 col-form-label fw-bold"
        >
            Correo:
        </label>
        <div class="col-sm-9">
            <input 
                type="text" 
                class="form-control" 
                id="inputCorreo"
                v-model="form.correo"
              
            />
        </div>
     </div>
	 <div class="mb-1 row">
        <label
            for="inputTelefono" 
            class="col-sm-3 col-form-label fw-bold"
        >
            Teléfono: 
        </label>
        <div class="col-sm-9">
            <input 
                type="text" 
                class="form-control" 
                id="inputTelefono"
                v-model="form.telefono"
               
            />
        </div>
     </div>
	 <div class="mb-1 row">
        <label
            for="inputDireccion" 
            class="col-sm-3 col-form-label fw-bold"
        >
            Dirección: 
        </label>
        <div class="col-sm-9">
            <input 
                type="text" 
                class="form-control" 
                id="inputDireccion"
                v-model="form.direccion"
              
            />
        </div>
     </div>
	 <div class="mb-1 row">
			<label
				for="selectUsuario" 
				class="col-sm-3 col-form-label fw-bold"
			>
				Usuario: <span class="text-danger">*</span>
			</label>
			<div class="col-sm-9">
				<select 
					name="selectUsuario" 
					id="selectUsuario"
					class="form-select" 
					v-model="form.usuario_id"
					required
				>
					
					<option v-for="i in cat.usuario" :value="i.id"> {{ i.nombre }} {{ i.apellido }} </option>
				</select>
			</div>
		</div>
		<div class="d-flex flex-row mb-3">
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
					<label class="form-check-label fw-bold" for="flexSwitchCheckChecked">Activo </label>
				</div>
			</div>

		</div>
		<div class="col-sm-2 offset-sm-2 mt-2">

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
		name: 'EmpleadoForm',
		mixins: [General,Catalogo],
		props: {
			empleado: {
				type: Object,
				required: false
			}
		},	
		data: () => ({
			
		}),
		
		created() {
			this.controlador = 'mnt/Empleado'
			this.getCatalogo(['usuario'])
			this.setForm()
		
			if (this.empleado) {
				this.pk = this.empleado.id			
				this.setDatosForm(this.empleado);
			}	
		},
		methods: {
			setForm() {
			this.form = {
				nombre: '',
				apellido: '',
				correo: '',
				telefono: '',
				direccion: '',
				activo: 1,
				usuario_id: ''
			}
		},
		}
	}
</script>