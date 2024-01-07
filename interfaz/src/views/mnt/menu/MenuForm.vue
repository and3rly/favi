<template>
	<form @submit.prevent="guardar">
		<div class="alert alert-info fw-bold py-2 mb-4" role="alert">
			<i class="fas fa-lightbulb me-2"></i>Todos los campos marcados con <span class="text-danger">*</span> son obligatorios.
		</div>

		<div class="row">
			<div class="col-sm-6">
				<label for="titulo" class="col-form-label mb-0 fw-bold">
					Título: <span class="text-danger">*</span>
				</label>
				<div class="col-sm-12">
					<input 
						type="text" 
						class="form-control" 
						id="titulo" 
						placeholder="Título menú"
						v-model="form.titulo"
					>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="nombre" class="col-form-label mb-0 fw-bold">
					Nombre: <span class="text-danger">*</span>
				</label>
				<div class="col-sm-12">
					<input 
						type="text" 
						class="form-control" 
						id="nombre" 
						placeholder="Nombre menú"
						v-model="form.nombre"
					>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<label for="nombre" class="col-form-label mb-0 fw-bold">
					Padre: <span class="text-danger">*</span>
				</label>
				<select 
					name="selectPadre" 
					id="selectPadre" 
					class="form-select"
					v-model="form.padre"
					@change="onChangePadre($event)"
					required
				>	
					<option value="0">Sin Padre</option>
					<option v-for="(i, idx) in cat.menu" :value="i.id">{{ i.titulo }} | Nivel: {{ i.nivel }} </option>
				</select>
			</div>
			<div class="col-sm-6">
				<label for="nombre" class="col-form-label mb-0 fw-bold">
					Nivel: <span class="text-danger">*</span>
				</label>
				<div class="col-sm-12">
					<input 
						type="text" 
						class="form-control" 
						id="nivel" 
						placeholder="Nivel menú"
						v-model="form.nivel"
                        disabled
					>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<label for="titulo" class="col-form-label mb-0 fw-bold">
					Ruta:
				</label>
				<div class="col-sm-12">
					<input 
						type="text" 
						class="form-control" 
						id="ruta" 
						placeholder="Ruta menú"
						v-model="form.ruta"
					>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="titulo" class="col-form-label mb-0 fw-bold">
					Ícono: <span class="text-danger">*</span>
				</label>
				<select 
					name="selectIcono" 
					id="selectIcono" 
					class="form-select"
					v-model="form.icono"
					required
				>	
					<option value="">Seleccione Ícono...</option>
					<!-- <option v-for="(i, idx) in cat.icono" :value="i.id">{{ i.titulo }} | Nivel: {{ i.nivel }} </option> -->
					<option value="fa fa-list">fa fa-list</option>
                    <option value="fa fa-cubes-stacked">fa fa-cubes-stacked</option>
				</select>
			</div>
		</div>
        <br>
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
                        v-model="form.solicita_clave"
                        checked 
                    >
                    <label class="form-check-label" for="flexSwitchCheckChecked">Solicita Clave</label>
                </div>
            </div>
        </div>

		<div class="text-end mt-5">
			<button 
				type="button" 
				class="btn btn-secondary me-2"
				@click="$emit('cerrar')"
			>
				<i class="fas fa-times me-1"></i>Cerrar
			</button>

			<button 
				type="submit" 
				class="btn btn-success"
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
		name: 'MenuForm',
		mixins: [General, Catalogo],
		props: {
			menu: {
				type: Object,
				required: false
			}
		},	
		data: () => ({
			btnGuardar: false,
		}),
		created() {
			
			this.setForm()

			if (this.menu) {
				this.pk = this.menu.id			
				this.setDatosForm(this.menu);
			}

			this.controlador = 'mnt/menu'
            this.getCatalogo(['menu'])
		},
		methods: {
			guardar() {
				this.btnGuardar = true

				let datos = new FormData()

				for (let i in this.form) {
					datos.append(i, this.form[i]);
				}

				this.$http
				.post(`${this.$baseUrl}/${this.controlador}/guardar/${this.pk}`, datos)
				.then(res => {
					this.btnGuardar = false

					if (res.data.exito) {
						this.archivo = null

						if (res.data.linea) {
							this.$emit('actualizar', res.data.linea, this.pk)
							this.$emit('cerrar')
						}
						
					}
				}).catch(e => {
					this.btnGuardar = false
					console.log(e)
				})
			},
			setForm() {
				this.pk = ''
				this.form = {
					titulo: '',
					nombre: '',
					nivel: 0,
					padre: 0,
					solicita_clave: 0,
					icono: '',
					ruta: '',
					activo: 1
				}
				this.archivo = null
			},
			onChangePadre(event){
				const newVal = event.target.value;

                if(newVal!=0){
                    let item = this.cat.menu.filter(e => e.id === newVal);
                    
                    this.form.nivel = parseInt(item[0].nivel)+1;
                }else {
                    this.form.nivel = 0;
                }

			}
		}
	}
</script>