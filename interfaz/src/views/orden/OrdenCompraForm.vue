<template>
	<form @submit.prevent="guardar(true)">
		<div class="alert alert-info fw-bold py-2 mb-4" role="alert">
			<i class="fas fa-lightbulb me-2"></i>Todos los campos marcados con <span class="text-danger">*</span> son obligatorios.
		</div>

		<div class="row g-2 mb-4">
			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					No. Documento: <span class="text-danger">*</span>
				</label>
				<input 
					type="text" 
					class="form-control"
					placeholder="Número del documento" 
					v-model="form.no_documento"
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Procedencia: <span class="text-danger">*</span>
				</label>
				<input 
					type="text" 
					class="form-control"
					placeholder="Procedencia del producto" 
					v-model="form.procedencia"
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Referencia <span class="text-danger">*</span>
				</label>
				<input 
					type="text" 
					class="form-control"
					placeholder="Referencia" 
					v-model="form.referencia"
					required
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Proveedor Bodega: <span class="text-danger">*</span>
				</label>
				<select 
					name="selectPB" 
					id="selectPB" 
					class="form-select"
					v-model="form.proveedor_bodega_id"
					required
				>	
					<option value="">Seleccione Proveedor...</option>
					<option v-for="(i, idx) in cat.proveedor_bodega_orden" :value="i.id">{{ i.nombre_proveedor }} | {{ i.nombre_bodega }} </option>
				</select>
			</div>

            <div class="col-sm-6">
                <label for="" class="fw-bold mb-1">
                    Bodega: <span class="text-danger">*</span>
                </label>
                <select 
                    name="selectB" 
                    id="selectB" 
                    class="form-select"
                    v-model="form.bodega_id"
                    required
                >	
                    <option value="">Seleccione Bodega...</option>
                    <option v-for="(i, idx) in cat.bodega" :value="i.id">{{ i.nombre }}</option>
                </select>
            </div>

            <div class="col-sm-6">
                <label for="" class="fw-bold mb-1">
                    Tipo: <span class="text-danger">*</span>
                </label>
                <select 
                    name="selectTipo" 
                    id="selectTipo" 
                    class="form-select"
                    v-model="form.orden_compra_tipo_id"
                    required
                >	
                    <option value="">Seleccione Tipo...</option>
                    <option v-for="(i, idx) in cat.orden_compra_tipo" :value="i.id">{{ i.nombre }}</option>
                </select>
            </div>

            <div class="col-sm-6">
                <label for="" class="fw-bold mb-1">
                    Estado: <span class="text-danger">*</span>
                </label>
                <select 
                    name="selectEstado" 
                    id="selectEstado" 
                    class="form-select"
                    v-model="form.orden_compra_estado_id"
                    required
                >	
                    <option value="">Seleccione Estado...</option>
                    <option v-for="(i, idx) in cat.orden_compra_estado" :value="i.id">{{ i.nombre }}</option>
                </select>
            </div>

            <div class="col-sm-6">
                <label for="" class="fw-bold mb-1">
                    Motivo Devolución: <span class="text-danger">*</span>
                </label>
                <select 
                    name="selectMD" 
                    id="selectMD" 
                    class="form-select"
                    v-model="form.motivo_devolucion_id"
                    required
                >	
                    <option value="">Seleccione Motivo...</option>
                    <option v-for="(i, idx) in cat.motivo_devolucion" :value="i.id">{{ i.nombre }}</option>
                </select>
            </div>

            <div class="col-md-12">
                <label for="" class="fw-bold mb-1">
                    Observación: <span class="text-danger">*</span>
                </label>
                <input 
                    type="textarea" 
                    class="form-control"
                    placeholder="Observación" 
                    v-model="form.observacion"
                >
            </div>
		</div>
	    <div class="col-sm-2 offset-sm-2 mt-2">
	    	
	    </div>
		
		<div class="text-end mt-1 mb-1">
			<button 
				type="button" 
				class="btn btn-secondary me-2"
				@click="$emit('cerrar')"
			>
				<i class="fas fa-times me-1"></i>Cerrar
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
</template>

<script>
	import General from '@/mixins/General.js'
	import Catalogo from '@/mixins/Catalogo.js'

	export default {
		name:"OrdenCompraForm",
		mixins: [General, Catalogo],
		props: {
			ordenCompra: {
				type: Object,
				required: false
			}
		},
		data: () => ({
		}),
		created() {
			this.controlador = 'orden/ordenCompra'
			this.autoBuscar = false
			this.getCatalogo([
                "proveedor_bodega_orden",
                "bodega",
                "orden_compra_tipo",
                "orden_compra_estado",
                "motivo_devolucion"
            ])
			this.setForm()

			if (this.ordenCompra) {
				this.pk = this.ordenCompra.id
				this.setDatosForm(this.ordenCompra);
			}
		},
		methods: {
			setForm() {
				this.form = {
					no_documento: '',
					procedencia: '',
					referencia: '',
					observacion: '',
					proveedor_bodega_id: '',
					orden_compra_estado_id: '',
					orden_compra_tipo_id: '',
					motivo_devolucion_id: '',
					bodega_id: '',
					activo: 1
				}
			}
		}
	}
</script>