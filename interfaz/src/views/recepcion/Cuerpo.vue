<template>
	<template v-if="actual == 1">
		<div class="d-flex py-2">
			<div class="flex-fill me-1">
				<h1 class="page-header mb-1">
					<i class="fas fa-list-alt me-1"></i>Recepción
				</h1>
			</div>
			<div class="flex-fill text-end">
				<button 
					class="btn btn-theme"
					@click="verRecepcion(null)"
				>
					<i class="fas fa-circle-plus me-2"></i>Nuevo
				</button>	
			</div>
		</div>

		<Card class="mt-1">
			<CardHeader class="p-2 bg-white">			
				<div class="d-flex">
					<div class="flex-fill me-1">
						<input type="text" class="form-control" placeholder="Buscar por criterio...">
					</div>
					<div class="flex-fill me-1">
						<input type="date" class="form-control">
					</div>
					<div class="flex-fill me-1">
						<select 
							name="selectBodega" 
							id="selectBodega"
							class="form-select" 
						>
							<option :value="null">Seleccione una bodega...</option>
						</select>
					</div>
					<button
						class="btn btn-primary"
					>
						<i class="fas fa-search"></i>
					</button>
				</div>
			</CardHeader>
			<CardBody class="p-0">
				<div v-if="inicio === true" class="text-center">
					<div class="spinner-border" role="status">
						<span class="sr-only">Loading...</span>
					</div>
					<p>Cargando registros...</p>
				</div>

				<div v-else class="table-responsive mt-3">
					<table class="table table-sm table-hover table-striped">
						<thead>
							<tr>
								<th class="text-center" width="50">#</th>
								<th>Observación</th>
								<th>Marchamo</th>
								<th>Guía</th>
								<th class="text-center">Fecha recepción</th>
								<th class="text-center">Hora inicio</th>
								<th class="text-center">Hora fin</th>
								<th>Bodega</th>
								<th>Transacción</th>
								<th>Estado</th>
								<th class="text-center">Ingresa Stock</th>
								<th class="text-center">Anulada</th>
								<th class="text-center">Activo</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr 
								v-for="(i, idx) in lista" 
								:key="idx"
								style="cursor: pointer;"
							>	
								<th class="text-center"> {{ idx + 1 }} </th>
								<td> {{ i.observacion}} </td>
								<td> {{ i.no_marchamo }} </td>
								<td> {{ i.no_guia }} </td>
								<td class="text-center"> {{ formatoFecha(i.fecha_recepcion,1) }} </td>
								<td class="text-center"> {{ i.hora_inicio }} </td>
								<td class="text-center"> {{ i.hora_fin }} </td>
								<td> {{ i.nombre_bodega }} </td>
								<td> {{ i.nombre_transaccion }} </td>
								<td> 
									<span 
										:class="'badge bg-'+i.nombre_color+' bg-opacity-20 text-'+i.nombre_color+' fs-11px d-inline-flex align-items-center'"
									>
										<i 
											:class="'fa fa-check-circle text-'+i.nombre_color+' fs-10px fa-fw me-1'"
										></i>{{ i.nombre_estado }}
									</span>
								</td>
								<td class="text-center">
									<i class="fas fa-check-circle text-success" v-if="i.ingresa_stock == 1"></i>
									<i class="fas fa-times-circle text-danger" v-else></i>
								</td>
								<td class="text-center">
									<i class="fas fa-check-circle text-success" v-if="i.anulada == 1"></i>
									<i class="fas fa-times-circle text-danger" v-else></i>
								</td>
								<td class="text-center">
									<i class="fas fa-check-circle text-success" v-if="i.activo == 1"></i>
									<i class="fas fa-times-circle text-danger" v-else></i>
								</td>
								<td class="text-center">
									<button
										class="btn btn-sm btn-secondary me-1"
										@click="verRecepcion(i)"
										title="Editar"
									>
										<i class="fas fa-edit"></i>
									</button>
									<button
										class="btn btn-sm btn-warning"
										@click="verDetalle(i)"
										title="Ver detalle"
									>
										<i class="fas fa-list-alt"></i>
									</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</CardBody>
		</Card>
	</template>

	<FormDetalle
		v-if="actual == 2"
		:cat="cat"
		:recepcion="reg"
		@regresar="actual = 1"
	/>

	<div 
		class="modal fade" 
		id="mdlRecepcionEnc"
		data-bs-backdrop="static" 
		data-bs-keyboard="false" 
		tabindex="-1" 
		aria-labelledby="staticBackdropLabel" 
		aria-hidden="true">

		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h1 
						class="modal-title fs-5" 
						id="staticBackdropLabel"
					> 
						<i class="fas fa-list-alt fa-sm me-1"></i> Recepción <span v-if="reg != null"> - {{ reg.observacion }}</span>
					</h1>
					<button 
						type="button" 
						class="btn-close" 
						aria-label="Close"
						@click="cerrarModal"
					>
					</button>
				</div>
				<div class="modal-body">
					<Form
						v-if="verForm"
						:recepcion="reg"
						:cat="cat"
						@actualizar="actLista"
						@cerrar="cerrarModal"
					/>
				</div>
			</div>
		</div>
	</div>

</template>

<script>
	import Form from '@/views/recepcion/Form.vue'
	import FormDetalle from '@/views/recepcion/FormDetalle.vue'
	import Utileria from '@/mixins/Utileria.js'

	export default {
		name: 'CuerpoRec',
		mixins: [Utileria],
		data:() =>({
			lista: [],
			cat: [],
			reg: {},
			actual: 1,
			inicio: false,
			verForm: false
		}),
		mounted() {
			this.modal = new this.$modal(document.getElementById('mdlRecepcionEnc'));
		},
		created() {
			this.buscar()
			this.getDatos()
		},
		methods: {
			getDatos() {
				this.inicio = true

				this.$http
				.get(`${this.$baseUrl}/recepcion/principal/get_datos`)
				.then(res => {
					this.inicio = false
					this.cat = res.data.cat
				}).catch(e => {
					this.inicio = false
					console.log(e)
				})
			},
			buscar() {
				this.inicio = true

				this.$http
				.get(`${this.$baseUrl}/recepcion/principal/buscar`, {params: this.bform})
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
			verRecepcion(obj) {
				this.reg = obj
				this.verForm = true
				this.modal.show()
			},
			verDetalle(obj) {
				this.reg = obj
				this.actual = 2
			},
			cerrarModal() {
				this.reg = null
				this.verForm = false
				this.modal.hide()
			},
			actLista(obj) {
				if (this.reg === null) {
					this.lista.push(obj)
				} else {
					let idx = this.lista.indexOf(this.reg)

					for (let i in obj) {
						this.lista[idx][i] = obj[i]
					}
				}
			}
		},
		components: {
			Form,
			FormDetalle
		}
	}
</script>