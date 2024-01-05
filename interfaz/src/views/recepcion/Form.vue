<template>
	<nav class="navbar navbar-expand-lg bg-light">
		<button 
				class="btn btn-secondary me-2"
				@click="$emit('regresar')"
		>
			<i class="fas fa-arrow-left"></i>
		</button>

		<a class="navbar-brand fw-bold m-0" href="#">
			<span> {{ recepcion != null ? 'Recepción ' + recepcion.nombre : 'Nueva recepción'}}</span>
		</a>

		<button 
			class="navbar-toggler" 
			type="button" 
			data-bs-toggle="collapse" 
			data-bs-target="#navbarTogglerDemo03" 
			aria-controls="navbarTogglerDemo03" 
			aria-expanded="false" 
			aria-label="Toggle navigation"
		>
			<span class="navbar-toggler-icon"></span>
		</button>

		<div 
			class="collapse navbar-collapse" 
			id="navbarTogglerDemo03"
		>
			<div class="navbar-nav me-auto">
			</div>

			<div class="mt-1">
				<button class="btn btn-primary">
					<i class="fas fa-save me-2"></i>Guardar
				</button>
			</div>
		</div>
	</nav>

	<div class="row">
		<div class="col-sm-7 mt-3">
			<Card>
				<CardHeader class="fw-bold">
					<i class="fas fa-list"></i> Detalle
				</CardHeader>
				<CardBody style="border-top: solid #0277BD;">
					<template v-if="form.bodega_id">
						<form @submit.prevent="agregarProducto">
							<div class="d-flex mt-3">
								<div class="flex-grow-1 me-1">
									<input 
										type="text" 
										class="form-control"
										placeholder="Buscar producto por código o barra" 
										v-model="producto.codigo"
									>
								</div>
								<div class="flex-shrink-1">
									<button 
										type="submit"
										class="btn btn-lime text-white"
									>
										<i class="fas fa-plus"></i> Agregar
									</button>
								</div>
							</div>
						</form>
						<div class="table-responsive mt-3">
							<table class="table table-sm table-hover">
								<thead>
									<tr>
										<th class="text-center" width="75">No. Línea</th>
										<th class="text-center">Código</th>
										<th>Nombre</th>
										<th class="text-center" width="100">Cantidad Rec.</th>
										<th class="text-center">UM</th>
										<th>Lote</th>
										<th>Presentación</th>
										<th class="text-center">Estado</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="i in form.detalle">
										<td class="text-center">{{ i.no_linea }}</td>
										<td class="text-center">{{ i.codigo_producto }}</td>
										<td>{{ i.nombre_producto }}</td>
										<td class="text-center">
											<input 
												type="number" 
												class="form-control text-center" 
												v-model="i.cantidad_recibida"
											/>
										</td>
										<td class="text-center">{{ i.nombre_unidad_medida }}</td>
										<td>{{ i.lote }}</td>
										<td>{{ i.nombre_presentacion }}</td>
										<td class="text-center">{{ i.nombre_producto_estado }}</td>
										<td>
											<a 
												class="text-primary me-2" 
												href="javascript:;"
												title="Editar"
											>
		    								<span class="fas fa-edit"></span>
		    							</a>
											<a 
												class="text-danger" 
												href="javascript:;"
												title="Eliminar" 
											>
		    								<span class="fas fa-trash"></span>
		    							</a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</template>
					<template v-else>
						<div class="alert alert-info fw-bold">
							<i class="fas fa-info-circle me-1"></i> Por favor, debe seleccionar una bodega
						</div>
					</template>
				</CardBody>
			</Card>
		</div>

		<div class="col-sm-5 mt-3">
			<Card>
				<CardHeader class="fw-bold">
					<i class="fas fa-list"></i> Datos generales
				</CardHeader>
				<CardBody style="border-top: solid #0277BD;">
					<div class="mb-1 row">
						<label
							for="inputObservacion" 
							class="col-sm-3 col-form-label fw-bold"
						>
							Observación: <span class="text-danger">*</span>
						</label>
						<div class="col-sm-9">
							<input 
								type="text" 
								class="form-control" 
								id="inputObservacion"
								v-model="form.observacion"
								required
							/>
						</div>
					</div>

					<div class="mb-1 row">
						<label
							for="selectEstado" 
							class="col-sm-3 col-form-label fw-bold"
						>
							Estado: <span class="text-danger">*</span>
						</label>
						<div class="col-sm-9">
							<select 
								name="selectEstado" 
								id="selectEstado"
								class="form-select" 
								v-model="form.estado_recepcion_id"
								required
							>
								<option :value="null">------------------</option>
								<option v-for="i in cat.estado" :value="i.id"> {{ i.nombre }} </option>
							</select>
						</div>
					</div>

					<div class="mb-1 row">
						<label
							for="selectTransaccion" 
							class="col-sm-3 col-form-label fw-bold"
						>
							Transacción: <span class="text-danger">*</span>
						</label>
						<div class="col-sm-9">
							<select 
								name="selectTransaccion" 
								id="selectTransaccion"
								class="form-select" 
								v-model="form.tipo_transaccion_id"
								required
							>
								<option :value="null">------------------</option>
								<option v-for="i in cat.transaccion" :value="i.id"> {{ i.nombre }} </option>
							</select>
						</div>
					</div>

					<div class="mb-1 row">
						<label
							for="selectBodega" 
							class="col-sm-3 col-form-label fw-bold"
						>
							Bodega: <span class="text-danger">*</span>
						</label>
						<div class="col-sm-9">
							<select 
								name="selectBodega" 
								id="selectBodega"
								class="form-select" 
								v-model="form.bodega_id"
								required
							>
								<option :value="null">------------------</option>
								<option v-for="(i, idx) in cat.bodega" :value="i.id"> {{ i.nombre }} </option>
							</select>
						</div>
					</div>

					<div class="mb-1 row">
						<label
							for="selectVehiculo" 
							class="col-sm-3 col-form-label fw-bold"
						>
							Vehículo: <span class="text-danger">*</span>
						</label>
						<div class="col-sm-9">
							<select 
								name="selectVehiculo" 
								id="selectVehiculo"
								class="form-select" 
								v-model="form.vehiculos_id"
								required
							>
								<option :value="null">------------------</option>
								<option v-for="i in cat.vehiculo" :value="i.id"> {{ i.placa }} - {{ i.marca }} {{ i.model }} </option>
							</select>
						</div>
					</div>

					<div class="mb-1 row">
						<label
							for="selectPiloto" 
							class="col-sm-3 col-form-label fw-bold"
						>
							Piloto: <span class="text-danger">*</span>
						</label>
						<div class="col-sm-9">
							<select 
								name="selectPiloto" 
								id="selectPiloto"
								class="form-select" 
								v-model="form.pilotos_id"
								required
							>
								<option :value="null">------------------</option>
								<option v-for="i in cat.piloto" :value="i.id"> {{ i.nombres }} {{ i.apellidos }} </option>
							</select>
						</div>
					</div>

					<div class="mb-1 row">
						<label
							for="inputNoGuia" 
							class="col-sm-3 col-form-label fw-bold"
						>
							No. Guía:
						</label>
						<div class="col-sm-9">
							<input 
								type="text" 
								class="form-control" 
								id="inputNoGuia"
							/>
						</div>
					</div>

					<div class="mb-1 row">
						<label
							for="inputObservacion" 
							class="col-sm-3 col-form-label fw-bold"
						>
							No. Marchamo:
						</label>
						<div class="col-sm-9">
							<input 
								type="text" 
								class="form-control" 
								id="inputObservacion"
							/>
						</div>
					</div>

					<div class="mb-1 row">
						<label
							for="inputObservacion" 
							class="col-sm-3 col-form-label fw-bold"
						>
							Fecha recepción:
						</label>
						<div class="col-sm-9">
							<input 
								type="date" 
								class="form-control" 
								id="inputObservacion"
							/>
						</div>
					</div>

					<div class="mb-1 row">
						<label
							for="inputObservacion" 
							class="col-sm-3 col-form-label fw-bold"
						>
							Hora inicio:
						</label>
						<div class="col-sm-9">
							<input 
								type="time" 
								class="form-control" 
								id="inputObservacion"
							/>
						</div>
					</div>

					<div class="mb-1 row">
						<label
							for="inputObservacion" 
							class="col-sm-3 col-form-label fw-bold"
						>
							Hora fin:
						</label>
						<div class="col-sm-9">
							<input 
								type="time" 
								class="form-control" 
								id="inputObservacion"
							/>
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
		name: 'FormRecepcion',
		mixins: [Helper],
		props: {
			recepcion: {
				type: Object,
				required: false,
				default: null
			}
		},
		data:() => ({
			inicio: false,
			cat: [],
			producto: {}
		}),
		created() {
			this.controlador = "recepcion/principal"
			this.autoBuscar = false

			this.fbase = {
				vehiculos_id: null,
				bodega_id: null,
				pilotos_id: null,
				tipo_transaccion_id: null,
				estado_recepcion_id: null,
				detalle: []
			}

			this.getDatos()
		},
		methods: {
			getDatos() {
				this.inicio = true

				this.$http
				.get(`${this.$baseUrl}/${this.controlador}/get_datos`)
				.then(res => {
					this.inicio = false
					this.cat = res.data.cat
				}).catch(e => {
					this.inicio = false
					console.log(e)
				})
			},
			agregarProducto() {
				if (this.producto.codigo != null) {
					let tmp = this.productos.filter(e => {
						return e.codigo.toLowerCase() == this.producto.codigo.toLowerCase() || e.barra.toLowerCase() == this.producto.codigo.toLowerCase()
					})[0]

					if (tmp) {
						this.producto = {
							no_linea: 1,
							codigo_producto: tmp.codigo,
							nombre_producto: tmp.nombre,
							cantidad_recibida: 0,
							nombre_presentacion: '',
							nombre_unidad_medida: tmp.nombre_um,
							nombre_producto_estado: tmp.nombre_estado,
							lote: '',
							fecha_vence: '',
							peso: null,
							peso_minimo: null,
							peso_maximo: null,
							costo: 0,
							costo_oc: null,
							producto_bodega_id: tmp.producto_bodega,
							presentacion_producto_id: 1,
							unidad_medida_id: tmp.unidad_medida_id,
							estado_producto_id: tmp.estado_producto_id
						}

						this.form.detalle.push(this.producto)
						this.producto['codigo'] = null

					} else {
						this.$toast.error("No se encontró el producto.")
					}
				}
			}
		},
		computed: {
			productos() {
				if (this.cat.productos) {
						return this.cat.productos.filter(e => {
							return e.bodega_id === this.form.bodega_id
						})
				}
				return []
			}
		}
	}
</script>