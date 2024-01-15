<template>
	<div class="d-flex align-items-center mb-4">
		<h1 class="page-header mb-0">
			<i class="fas fa-list fa-sm me-2"></i>Menú
		</h1>
	</div>

	<template v-if="inicio">
		<div class="text-center">
			<div class="d-flex justify-content-center">
			  <div class="spinner-border" role="status">
			    <span class="visually-hidden">Loading...</span>
			  </div>
			</div>
			Cargando...
		</div>
	</template>
	<div class="row" v-else>
		<div class="col-sm-7">
			<Card>
				<CardHeader class="fw-bold">
					<i class="fas fa-list me-1"></i> Datos
				</CardHeader>
				<CardBody>
					<form @submit.prevent="guardar">
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
								for="inputUrl" 
								class="col-sm-3 col-form-label fw-bold"
							>
								Url: <span class="text-danger">*</span>
							</label>
							<div class="col-sm-9">
								<input 
									type="text" 
									class="form-control" 
									id="inputUrl"
									v-model="form.url"
								/>
							</div>
						</div>

						<div class="mb-1 row">
							<label
								for="inputIcono" 
								class="col-sm-3 col-form-label fw-bold"
							>
								Icono: <span class="text-danger">*</span>
							</label>
							<div class="col-sm-9">
								<input 
									type="text" 
									class="form-control" 
									id="inputIcono"
									v-model="form.icono"
								/>
								<div id="iconoHelp" class="form-text">
									Puede encontrar más iconos <a href="https://fontawesome.com/icons?d=gallery&amp;m=free" target="blank">aquí</a>
								</div>
							</div>
						</div>

						<div class="col-sm-9 offset-sm-3 mt-2" v-if="pk != ''">
							<div class="d-flex p-1">
								<div class="flex-fill me-2">
									<div class="form-check form-switch">
										<input 
											class="form-check-input" 
											type="checkbox" 
											role="switch" 
											id="chkActivo" 
											:true-value="1" 
											:false-value="0"
											v-model="form.activo"
											checked 
										>
										<label class="form-check-label" for="chkActivo">Activo</label>
									</div>
								</div>

								<div class="flex-fill me-2">
									<div class="form-check form-switch">
										<input 
											class="form-check-input" 
											type="checkbox" 
											role="switch" 
											id="chkIngresaStock" 
											:true-value="1" 
											:false-value="0"
											v-model="form.titulo"
											checked 
										>
										<label class="form-check-label" for="chkIngresaStock">Es título</label>
									</div>
								</div>
							</div>
						</div>

						<div class="text-end mt-4 mb-1">
							<button 
								v-if="pk != ''"
								type="button" 
								class="btn btn-secondary me-2"
								@click="limpiar"
							>
								Cancelar/Limpiar
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
				</CardBody>
			</Card>
		</div>

		<div class="col-sm-5">
			<Card>
				<CardHeader class="fw-bold">
					<i class="fas fa-list me-1"></i> Modulos ({{lista.length}})
				</CardHeader>
				<CardBody class="p-0">
					<div class="list-group list-group-flush rounded-0 ">
						<div 
							class="list-group-item list-group-item-action"
							v-for="(i, idx) in lista"
						>
							<div class="d-flex">
								<div class="flex-grow-1">
									<i :class="i.icono"></i> {{ i.nombre }}
								</div>
								<template v-if="i.titulo == 0">
									<div class="">
										<a 
											type="button" 
											href="javascript:;"
											title="Editar módulo"
											@click="editar(i)"
										>
											<i class="fas fa-edit text-primary me-2"></i>
										</a>
									</div>
									<div class="">
										<a 
											type="button" 
											href="javascript:;"
											title="Agregar opciones"
											@click="agregarOpcion(i)"
										>
											<i class="fas fa-plus-circle text-primary me-2"></i>
										</a>
									</div>
									<div class="">
										<a 
											type="btn btn-sm" 
											href="javascript:;"
											title="Eliminar módulo"
											@click="anular_modulo(i, idx)"
										>
											<i class="fas fa-trash text-danger"></i>
										</a>
									</div>
								</template>
							</div>
						</div>
					</div>
				</CardBody>
			</Card>
		</div>
	</div>

	<div 
		class="modal fade" 
		id="mdlOpciones"
		data-bs-backdrop="static" 
		data-bs-keyboard="false" 
		tabindex="-1" 
		aria-labelledby="staticBackdropLabel" 
		aria-hidden="true">

		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h1 
						class="modal-title fs-5" 
						id="staticBackdropLabel"
					> 
						<i class="fas fa-cog fa-sm me-1"></i> Módulo <span v-if="modulo != null"> - {{ modulo.nombre }}</span>
					</h1>
					<button 
						type="button" 
						class="btn-close" 
						aria-label="Close"
						@click="cerrarModulo"
					>
					</button>
				</div>
				<div class="modal-body">
					<Opcion
						v-if="modulo != null"
						:modulo="modulo"
					/>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import Opcion from '@/views/mnt/menu/Opcion.vue'
	import Helper from '@/mixins/Helper.js'

	export default {
		mixins: [Helper],
		data: () => ({
			modulo: null,
			bform: {},
			opciones: []
		}),
		mounted() {
			this.modal = new this.$modal(document.getElementById('mdlOpciones'));
		},
		created() {
			this.controlador = "mnt/menu"
		},
		methods: {
			cerrarModulo() {
				this.modulo = null
				this.modal.hide()
			},
			editar(obj) {
				this.setDatosForm(obj)
			},
			agregarOpcion(obj) {
				this.modulo = obj
				this.modal.show()
			},
			anular_modulo(obj, idx) {
				if (confirm("¿Está seguro?")) {
					let id = obj.id

					this.$http
					.post(`${this.$baseUrl}/${this.controlador}/anular_modulo/${id}`)
					.then(res => {
						this.btnGuardar = false

						if (res.data.exito) {	
							this.lista.splice(idx, 1)
						}

					}).catch(e => {
						this.btnGuardar = false
						console.log(e)
					})
				}
			},
		},
		components: {
			Opcion
		}
	}
</script>