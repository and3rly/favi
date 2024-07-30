<template>
    
<form @submit.prevent="guardar(true)">
    <div class="alert alert-info">
        <i class="fas fa-lightbulb me-2"></i>Todos los campos marcados con <span class="text-danger">*</span> son obligatorios.
</div>
    <div class="mb-1 row">
        <label
            for="inputNombres" 
            class="col-sm-3 col-form-label fw-bold"
        >
            Nombres: <span class="text-danger">*</span>
        </label>
        <div class="col-sm-9">
            <input 
                type="text" 
                class="form-control" 
                id="inputNombres"
                v-model="form.nombres"
                required
            />
        </div>
    </div>
    <div class="mb-1 row">
        <label
            for="inputMarca" 
            class="col-sm-3 col-form-label fw-bold"
        >
            Apellidos: <span class="text-danger">*</span>
        </label>
        <div class="col-sm-9">
            <input 
                type="text" 
                class="form-control" 
                id="inputMarca"
                v-model="form.apellidos"
                required
            />
        </div>
    </div>



    <div class="mb-1 row">
        <label
            for="inputModelo" 
            class="col-sm-3 col-form-label fw-bold"
        >
            Telefono:
        </label>
        <div class="col-sm-9">
            <input 
                type="text" 
                class="form-control" 
                id="inputModelo"
                v-model="form.telefono"
               
            />
        </div>
    </div>
        
    <div class="mb-1 row">
        <label
            for="inputObservacion" 
            class="col-sm-3 col-form-label fw-bold"
        >
            Correo:
        </label>
        <div class="col-sm-9">
            <input 
                type="email" 
                class="form-control" 
                id="inputObservacion"
                v-model="form.email"
            />
        </div>
    </div>
    <div class="mb-1 row">
        <label
            for="inputObservacion" 
            class="col-sm-3 col-form-label fw-bold"
        >
            Numero de Licencia:<span class="text-danger">*</span>
        </label>
        <div class="col-sm-9">
            <input 
                type="number" 
                class="form-control" 
                id="inputObservacion"
                v-model="form.no_licencia"
                required
            />
        </div>
    </div>
    <div class="mb-1 row">
        <label
            for="inputObservacion" 
            class="col-sm-3 col-form-label fw-bold"
        >
            Numero de DPI:<span class="text-danger">*</span>
        </label>
        <div class="col-sm-9">
            <input 
                type="number" 
                class="form-control" 
                id="inputObservacion"
                v-model="form.no_dpi"
                required
            />
        </div>
    </div>
 
    <div class="mb-1 row">
			<label
				for="inputFechaRec" 
				class="col-sm-3 col-form-label fw-bold"
			>
				Fecha de expiracion de licencia:
			</label>
			<div class="col-sm-9">
				<input 
					type="date" 
					class="form-control" 
					id="inputFechaRec"
					v-model="form.fecha_expira_licencia"
				/>
			</div>
		</div>
    	<div class="mb-1 row">
        <label
            for="inputObservacion" 
            class="col-sm-3 col-form-label fw-bold"
        >
            Direccion:
        </label>
        <div class="col-sm-9">
            <input 
                type="text" 
                class="form-control" 
                id="inputObservacion"
                v-model="form.direccion"
              
            />
        </div>
    </div>	
    <div class="mb-1 row">
        <label
            for="inputObservacion" 
            class="col-sm-3 col-form-label fw-bold"
        >
            Fecha de nacimiento:
        </label>
        <div class="col-sm-9">
            <input 
                type="date" 
                class="form-control" 
                id="inputObservacion"
                v-model="form.fecha_nacimiento"

            />
        </div>
    </div>
    <div class="mb-1 row">
			<label
				for="selectLicencia" 
				class="col-sm-3 col-form-label fw-bold"
			>
				Tipo de licencia: <span class="text-danger">*</span>
			</label>
			<div class="col-sm-9">
				<select 
					name="selectVehiculo" 
					id="selectVehiculo"
					class="form-select" 
					v-model="form.tipo_licencia"
					
				>
				
					<option value="A">A</option>
					<option value="B">B</option>
					<option value="C">C</option>
					<option value="M">M</option>
				</select>
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
                        v-model="form.activo"
                        checked 
                    >
                    <label class="form-check-label" for="chkIngresaStock">Activo <span class="text-danger">*</span></label>
                </div>
            </div>

         
        </div>
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
    name: 'PilotosForm',
    mixins: [General,Catalogo],
    props: {
        pilotos: {
            type: Object,
            required: false
        }
    },	
    data: () => ({
        
    }),
    
    created() {
        this.controlador = 'mnt/pilotos'
        this.setForm()
    
        if (this.pilotos) {
            this.pk = this.pilotos.id			
            this.setDatosForm(this.pilotos);
        }	
    },
    methods: {
        setForm() {
        this.form = {
            nombres: '',
            apellidos: '',
            telefono: '',
            correo: '',
            no_licencia: '',
            no_dpi: '',
            fecha_expira_licencia: '',
            direccion: '',
            fecha_nacimiento: '',
            tipo_licencia: '',
            activo: 1
        }
    },
    }
}
</script>