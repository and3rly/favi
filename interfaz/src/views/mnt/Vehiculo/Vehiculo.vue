<template>
		<div class="d-flex align-items-center mb-4">
		<h1 class="page-header mb-0">
			<i class="fas fa-car-rear"></i> Vehiculo
		</h1>

		<div class="ms-auto">
			<a href="#" class="btn btn-theme" @click="abrirModal">
				<i class="fa fa-plus-circle fa-fw me-2"></i> Nuevo
			</a>
		</div>
	</div>
		<div class="card">
		<div class="card-body p-4">
			<div class="table-responsive-sm table-responsive-lg">
				<table class="table table-sm table-hover mb-0" style="text-align: center;">
					<thead>
						<tr>
							<th scope="col" class="text-center" width="40">#</th>
							<th scope="col">Tipo de Vehiculo</th>
							<th scope="col" >No.Placa</th>
							<th scope="col" >Marca</th>
							<th scope="col">Modelo</th>
							<th  scope="col"> Peso</th>
							<th scope="col">Volumen</th>
							<th  scope="col">Alto</th>
							<th scope="col">largo</th>
							<th scope="col">Ancho</th>
							<th scope="col">Placa Comercial</th>
							<th scope="col">Contenedor</th>
							<th>Activo</th>
						</tr>
					</thead>
					<tbody>
						<tr v-if="!cargando" v-for="(i, idx) in lista">
							<th scope="row" class="text-center">{{ idx + 1 }}</th>
						<td>{{ i.Tipo }}</td>
						<td>
								<a 
									href="javascript:;" 
									class="text-decoration-none" 
									@click="editar(i, idx)"
								>
									
								{{i.placa}} 
								</a>
							</td>
							<td>{{ i.marca }}</td>
							<td>{{ i.modelo }}</td>
							<td>{{ i.peso }}</td>
							<td>{{ i.volumen }}</td>
							<td>{{ i.alto }}</td>
							<td>{{ i.largo }}</td>
							<td>{{ i.ancho }}</td>
							<td>{{ i.placa_comercial }}</td>
							<td>
								<i v-if="i.es_contenedor == 1" class="fa fa-check text-success"></i>
								<i v-else class="fa fa-times text-danger"></i>
							</td>
							<td>
								<i v-if="i.activo == 1" class="fa fa-check text-success"></i>
								<i v-else class="fa fa-times text-danger"></i>
							</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td v-if="cargando" colspan="100" class="text-center">
								<div class="d-flex justify-content-center mb-3 mt-3">
									<div class="spinner-border" role="status">
										<span class="visually-hidden">Loading...</span>
									</div>

								</div>
								Cargando información...
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>

	

	<div class="modal-body">
					<Form
						v-if="verForm"
						:vehiculo="reg"
						:cat="cat"
						@actualizar="actLista"
						@cerrar="cerrarModal"
					/>
				</div>

</template>

<script>
	import Form from '@/views/Vehiculo/VehiculoForm.vue'
	import General from '@/mixins/General.js'

	export default {
		name: 'CuerpoVehiculo',
		mixins: [General],
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