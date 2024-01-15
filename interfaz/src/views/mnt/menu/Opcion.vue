<template>
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
					Datos
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
					Opciones ({{lista.length}})
				</CardHeader>
				<CardBody class="p-0">
					<div class="list-group list-group-flush">
						<div 
							class="list-group-item list-group-item-action"
							v-for="(i, idx) in lista"
						>
							<div class="d-flex">
								<div class="flex-grow-1">
									<i :class="i.icono"></i> {{ i.nombre }}
								</div>
								<div class="">
									<a 
										type="button" 
										href="javascript:;"
										title="Editar opción"
										@click="setDatosForm(i)"
									>
										<i class="fas fa-edit text-primary me-2"></i>
									</a>
								</div>
								<div class="">
									<a 
										type="btn btn-sm" 
										href="javascript:;"
										title="Eliminar opción"
										@click="anular_opcion(i, idx)"
									>
										<i class="fas fa-trash text-danger"></i>
									</a>
								</div>
							</div>
						</div>
					</div>
				</CardBody>
			</Card>
		</div>	
	</div>
</template>

<script>
	import Helper from '@/mixins/Helper.js'
 
	export default {
		mixins: [Helper],
		props: {
			modulo: {
				type: Object,
				required: false
			}
		},
		data: () => ({
			lista: [],
			bform: {}
		}),
		created() {
			this.controlador = 'mnt/menu'
			this.nombreAccion = 'guardar_opcion'
			this.autoBuscar = false

			if (this.modulo != null) {
				this.bform.modulo = this.modulo.id
				this.get_opciones()
			}

			this.fbase.modulo_id = this.modulo.id

		},
		methods: {
			get_opciones() {
				this.inicio = true

				this.$http
				.get(`${this.$baseUrl}/${this.controlador}/get_opciones`, {params: this.bform})
				.then(res => {
					this.inicio = false
					if (res.data.lista) {
						this.lista = res.data.lista
					}
				}).catch(e => {
					this.inicio = false
					console.log(e)
				})
			},
			anular_opcion(obj, idx) {
				if (confirm("¿Está seguro?")) {
					let id = obj.id

					this.$http
					.post(`${this.$baseUrl}/${this.controlador}/anular_opcion/${id}`)
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
		}
	}
</script>