<template>
	<form @submit.prevent="guardar(true)">
		<div class="alert alert-info fw-bold py-2 mb-4" role="alert">
			<i class="fas fa-lightbulb me-2"></i>Todos los campos marcados con <span class="text-danger">*</span> son obligatorios.
		</div>

		<div class="row g-2 mb-4">
			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Código: <span class="text-danger">*</span>
				</label>
				<input 
					type="text" 
					class="form-control"
					placeholder="Código del producto" 
					v-model="form.codigo"
					required 
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Barra:
				</label>
				<input 
					type="text" 
					class="form-control"
					placeholder="Código de barra del producto" 
					v-model="form.barra"
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Nombre: <span class="text-danger">*</span>
				</label>
				<input 
					type="text" 
					class="form-control"
					placeholder="Nombre del producto" 
					v-model="form.nombre"
					required
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Descripción:
				</label>
				<input 
					type="text" 
					class="form-control"
					placeholder="Descripción del producto" 
					v-model="form.descripcion"
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Costo:
				</label>
				<input 
					type="number" 
					class="form-control"
					placeholder="Costo del producto" 
					v-model="form.costo"
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Precio: <span class="text-danger">*</span>
				</label>
				<input 
					type="number" 
					class="form-control"
					placeholder="Precio del producto" 
					step="any"
					v-model="form.precio"
					required
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Unidad de medida:
				</label>
				<select 
					name="selectUM" 
					id="selectUM" 
					class="form-select"
					v-model="form.unidad_medida_id"					
				>	
					<option :value="null">Seleccione um...</option>
					<option v-for="(i, idx) in cat.um" :value="i.id">{{ i.nombre }}</option>
				</select>
			</div>

			<!--div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Presentación:
				</label>
				<select 
					name="selectPres" 
					id="selectPres" 
					class="form-select"
					v-model="form.presentacion_producto_id"
					required
				>
					<option :value="null">Seleccione presentación...</option>
					<option v-for="(i, idx) in cat.presentacion" :value="i.id">{{ i.nombre }} - {{ i.factor }}</option>
				</select>
			</div-->

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Estado:
				</label>
				<select 
					name="selectEstado" 
					id="selectEstado" 
					class="form-select"
					v-model="form.estado_producto_id"					
				>
					<option :value="null">Seleccione estado...</option>
					<option v-for="(i, idx) in cat.estado" :value="i.id">{{ i.nombre }}</option>
				</select>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Marca:
				</label>
				<select 
					name="selectMarca" 
					id="selectMarca" 
					class="form-select"
					v-model="form.marca_producto_id"			
				>
					<option :value="null">Seleccione marca...</option>
					<option v-for="(i, idx) in cat.marca" :value="i.id">{{ i.nombre }}</option>
				</select>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Clasificación:
				</label>
				<select 
					name="selectClasificacion" 
					id="selectClasificacion" 
					class="form-select"
					v-model="form.clasificacion_producto_id"
				
				>
					<option :value="null">Seleccione clasificación...</option>
					<option v-for="(i, idx) in cat.clasificacion" :value="i.id">{{ i.nombre }}</option>
				</select>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Tipo:
				</label>
				<select 
					name="selectTipo" 
					id="selectTipo" 
					class="form-select"
					v-model="form.tipo_producto_id"
				>
					<option :value="null">Seleccione tipo...</option>
					<option v-for="(i, idx) in cat.tipo" :value="i.id">{{ i.nombre }}</option>
				</select>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Familia:
				</label>
				<select 
					name="selectFamilia" 
					id="selectFamilia" 
					class="form-select"
					v-model="form.familia_producto_id"
				>
					<option :value="null">Seleccione familia...</option>
					<option v-for="(i, idx) in cat.familia" :value="i.id">{{ i.nombre }}</option>
				</select>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Peso:
				</label>
				<input 
					type="number" 
					class="form-control"
					placeholder="Peso del producto" 
					v-model="form.peso"
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Largo: 
				</label>
				<input 
					type="number" 
					class="form-control"
					placeholder="Largo del producto" 
					v-model="form.largo"
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Altura:
				</label>
				<input 
					type="number" 
					class="form-control"
					placeholder="Altura del producto" 
					v-model="form.altura"
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Anchura:
				</label>
				<input 
					type="number" 
					class="form-control"
					placeholder="Anchurra del producto" 
					v-model="form.anchura"
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Existencia máxima:
				</label>
				<input 
					type="number" 
					class="form-control"
					placeholder="Existencia máxima del producto" 
					v-model="form.existencia_maxima"
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Existencia mínima:
				</label>
				<input 
					type="number" 
					class="form-control"
					placeholder="Existencia mínima del producto" 
					v-model="form.existencia_minima"
				>
			</div>

			<div class="col-sm-6">
				<label for="" class="fw-bold mb-1">
					Imagen:
				</label>
				<input
					type="file"
					class="form-control"
					id="defaultFile"
					accept="image/*"
					@change="subirFoto"
				>
			</div>
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

			<div class="me-2">
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
					<label class="form-check-label" for="chkControlVence">Control vencimiento</label>
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
		name:"ProductoForm",
		mixins: [General, Catalogo],
		props: {
			producto: {
				type: Object,
				required: false
			}
		},
		data: () => ({
		}),
		created() {
			this.controlador = 'producto/producto'
			this.autoBuscar = false
			this.getCatalogo([
				'um', 
				'marca', 
				'clasificacion', 
				'estado', 
				'tipo', 
				'presentacion', 
				'familia'
			])
			this.setForm()

			if (this.producto) {
				this.pk = this.producto.id
				this.setDatosForm(this.producto);
			}
		},
		methods: {
			setForm() {
				this.form = {
					codigo: '',
					barra: '',
					nombre: '',
					descripcion: '',
					precio: '',
					costo: '',
					peso: '',
					largo: '',
					altura: '',
					anchura: '',
					control_vence: '',
					existencia_maxima: '',
					existencia_minima: '',
					activo: 1
				}
			},
			subirFoto(file) {
				if (file.target.files[0]) {
					this.form.imagen = file.target.files[0]
				}
			},
		}
	}
</script>