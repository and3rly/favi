<template>
	<form @submit.prevent="guardar(true)">
		<div class="alert alert-info fw-bold py-2 mb-4" role="alert">
			<i class="fas fa-lightbulb me-2"></i>Todos los campos marcados con <span class="text-danger">*</span> son obligatorios.
		</div>

		<div class="row g-2 mb-4">
			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					No. Línea: <span class="text-danger">*</span>
				</label>
				<input 
					type="number" 
					class="form-control"
					placeholder="Número de línea" 
					v-model="form.no_linea"
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Producto: <span class="text-danger">*</span>
				</label>
				<select 
					name="selectPBD" 
					id="selectPBD" 
					class="form-select"
					v-model="form.producto_bodega_id"
					@change="onChangeProduct($event)"
					required
				>	
					<option value="">Seleccione Producto...</option>
					<option v-for="(i, idx) in cat.producto_bodega_orden" :value="i.id">{{ i.codigo_producto }} - {{ i.nombre_producto }} | {{ i.nombre_bodega }} </option>
				</select>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Presentación Producto: <span class="text-danger">*</span>
				</label>
				<select 
					name="selectPPD" 
					id="selectPPD" 
					class="form-select"
					v-model="form.presentacion_producto_id"
					@change="onChangePresentation($event)"
				>	
					<option value="">Seleccione Presentación...</option>
					<option v-for="(i, idx) in cat.presentacion" :value="i.id">{{ i.codigo }} | {{ i.nombre }}</option>
				</select>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Unidad de Medida: <span class="text-danger">*</span>
				</label>
				<select 
					name="selectUMD" 
					id="selectUMD" 
					class="form-select"
					v-model="form.unidad_medida_id"
					@change="onChangeUM($event)"
					required
				>	
					<option value="">Seleccione Unidad de Medida...</option>
					<option v-for="(i, idx) in cat.um" :value="i.id">{{ i.nombre }}</option>
				</select>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Código Producto: <span class="text-danger">*</span>
				</label>
				<input 
					type="text" 
					class="form-control"
					placeholder="Código del producto" 
					v-model="form.codigo_producto"
					disabled
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Nombre Producto: <span class="text-danger">*</span>
				</label>
				<input 
					type="text" 
					class="form-control"
					placeholder="Nombre del Producto" 
					v-model="form.nombre_producto"
					required
					disabled
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Nombre Presentación: <span class="text-danger">*</span>
				</label>
				<input 
					type="text" 
					class="form-control"
					placeholder="Nombre de la Presentación del Producto" 
					v-model="form.nombre_presentacion"
					required
					disabled
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Nombre Unidad de Medida: <span class="text-danger">*</span>
				</label>
				<input 
					type="text" 
					class="form-control"
					placeholder="Nombre de la Unidad de Medida" 
					v-model="form.nombre_unidad_medida"
					required
					disabled
				>
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
				>	
					<option value="">Seleccione Motivo...</option>
					<option v-for="(i, idx) in cat.motivo_devolucion" :value="i.id">{{ i.nombre }}</option>
				</select>
			</div>

			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm">
						<label for="" class="fw-bold mb-1">
							Peso: <span class="text-danger">*</span>
						</label>
						<input 
							type="text" 
							class="form-control"
							placeholder="Peso del Producto" 
							v-model="form.peso"
							required
						>
					</div>
					<div class="col-sm">
						<label for="" class="fw-bold mb-1">
							Peso Recibido: <span class="text-danger">*</span>
						</label>
						<input 
							type="text" 
							class="form-control"
							placeholder="Peso recibido del Producto" 
							v-model="form.peso_recibido"
							required
						>
					</div>
				</div>
			</div>

			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm">
						<label for="" class="fw-bold mb-1">
							Cantidad: <span class="text-danger">*</span>
						</label>
						<input 
							type="text" 
							class="form-control"
							placeholder="Cantidad del Producto" 
							v-model="form.cantidad"
							required
						>
					</div>
					<div class="col-sm">
						<label for="" class="fw-bold mb-1">
							Cantidad Recibida: <span class="text-danger">*</span>
						</label>
						<input 
							type="text" 
							class="form-control"
							placeholder="Cantidad Recibida del Producto" 
							v-model="form.cantidad_recibida"
							disabled
						>
					</div>
				</div>
			</div>

			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-6">
						<label for="" class="fw-bold mb-1">
							Costo: <span class="text-danger">*</span>
						</label>
						<input 
							type="text" 
							class="form-control"
							placeholder="Costo del Producto" 
							v-model="form.costo"
							required
						>
					</div>
					<div class="col-sm-6">
						<label for="" class="fw-bold mb-1">
							Total: <span class="text-danger">*</span>
						</label>
						<input 
							type="text" 
							class="form-control"
							placeholder="Total del Producto" 
							v-model="form.total_linea"
							required
						>
					</div>
				</div>
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
		name:"OrdenCompraAgregarDetalle",
		mixins: [General, Catalogo],
		props: {
			ordenCompra: {
				type: Object,
				required: false
			},
			ordenCompraDet: {
				type: Object,
				required: false
			}
		},
		data: () => ({
		}),
		created() {
			this.controlador = 'orden/detalle/OrdenCompraDetalle'
			this.autoBuscar = false
			this.getCatalogo([
                "producto_bodega_orden",
                "presentacion",
                "um",
                "motivo_devolucion"
            ])
			this.setForm()

			if (this.ordenCompraDet) {
				this.pk = this.ordenCompraDet.id
				this.setDatosForm(this.ordenCompraDet);
			}
		},
		methods: {
			setForm() {
				this.form = {
					orden_compra_enc_id: this.ordenCompra.id,
					no_linea: '',
					codigo_producto: '',
					nombre_producto: '',
					nombre_presentacion: '',
					nombre_unidad_medida: '',
					cantidad: '',
					cantidad_recibida: '',
					costo: '',
					total_linea: '',
					peso: '',
					peso_recibido: '',
					producto_bodega_id: '',
					presentacion_producto_id: null,
					unidad_medida_id: '',
					motivo_devolucion_id: null,
					activo: 1
				}
			},
			onChangeProduct(event){
				const newVal = event.target.value;

				let item = this.cat.producto_bodega_orden.filter(e => e.id === newVal);
				
				this.form.codigo_producto = item[0].codigo_producto;
				this.form.nombre_producto = item[0].nombre_producto;
			},
			onChangePresentation(event){
				const newVal = event.target.value;

				let item = this.cat.presentacion.filter(e => e.id === newVal);
				
				this.form.nombre_presentacion = item[0].nombre;
			},
			onChangeUM(event){
				const newVal = event.target.value;

				let item = this.cat.um.filter(e => e.id === newVal);
				
				this.form.nombre_unidad_medida = item[0].nombre;
			}
		}
	}
</script>