<template>
	<div class="card">
		<div class="card-body p-4">
			<div class="table-responsive-sm table-responsive-lg">
				<table class="table table-sm table-hover mb-0" style="text-align: center;">
					<thead>
						<tr>
							<th scope="col" class="text-center" width="40">#</th>
							<th scope="col" width="100">Código</th>
							<th scope="col" width="150">Nombre</th>
							<th scope="col" width="150">Teléfono</th>
							<th scope="col">NIT</th>
							<th  scope="col">Dirección</th>
							<th scope="col">Correo</th>
							<th  scope="col">Contacto</th>
							<th scope="col">Muestra Precio</th>
							<th scope="col">Empresa</th>
							<th>Activo</th>
							<th scope="col" class="text-center" width="70">Acción</th>
						</tr>
					</thead>
					<tbody>
						<tr v-if="!cargando" v-for="(i, idx) in lista">
							<th scope="row" class="text-center">{{ idx + 1 }}</th>
							<td>
								<a 
									href="javascript:;" 
									class="text-decoration-none" 
									@click="editar(i, idx)"
								>
									
								{{i.codigo}} 
								</a>
							</td>
							<td>{{ i.nombre }}</td>
							<td>{{ i.telefono }}</td>
							<td>{{ i.nit }}</td>
							<td>{{ i.direccion }}</td>
							<td>{{ i.email }}</td>
							<td>{{ i.contacto }}</td>
							<td>
								<i v-if="i.muestra_precio == 1" class="fa fa-check text-success"></i>
								<i v-else class="fa fa-times text-danger"></i>
							</td>
							<td>{{ i.Empresa}}</td>
							<td>
								<i v-if="i.activo == 1" class="fa fa-check text-success"></i>
								<i v-else class="fa fa-times text-danger"></i>
							</td>
							<td>
								<div class="dropdown position-static">
									<a 
										href="javascript:;"
										data-bs-toggle="dropdown"
										aria-expanded="false" 
									>
										<i class="fas fa-ellipsis-v"></i>
									</a>
								  <div class="dropdown-menu dropdown-menu-end">
									<a
								    	href="javascript:;" 
								    	class="dropdown-item"
										@click="verBodega(i)"
								    >
								    	<i class=" fas fa-store me-1"></i>Agregar Bodega
								    </a>
								</div>
								</div>
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


	<div 
		class="modal fade" id="mdlProveedorBodega"
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
						Bodegas <i class="fas fa-store fa-sm me-2 ms-1"></i>
					</h1>
					<button 
						type="button" 
						class="btn-close" 
						aria-label="Close" 
						@click="cmBodega"
					>
					</button>
				</div>
				<div class="modal-body">
					<ProveedorBodega
						v-if="proveedor != null"
						:proveedor="proveedor"
					/>
				</div>
			</div>
		</div>



		
	</div>





</template>

<script>
	import General from '@/mixins/General.js'
	import ProveedorBodega from '@/views/mnt/Proveedor/ProveedorBodega.vue'

	export default {
		name: 'ProveedorLista',
		mixins: [General],
		props: {
			reg: {
				type: Object,
				required: false
			},
			tmpLinea: {
				type: Object,
				required: false
			},
		},
		data: () => ({
			idx: null,
			modal: null,
			proveedor: null
		}),
		mounted() {
			this.modal = new this.$modal(document.getElementById('mdlProveedorBodega'));
		
		},
		created(){
			this.controlador = 'mnt/Proveedor'
			this.autoBuscar = true
		},
		methods: {
			editar(obj, idx) {
				this.$emit('abrirModal', obj, idx)
			},
			anular_proveedor(obj, idx) {
				if (confirm("¿Está seguro?")) {
					this.pk = obj.id

					this.$http
					.post(`${this.$baseUrl}/mnt/proveedor/anular_proveedor/${this.pk}`)
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
			verBodega(obj) {
				this.proveedor  = obj
				this.modal.show()
			},
			
			cmBodega() {
				this.proveedor = null
				this.modal.hide()
			}
		},
		components: {
			ProveedorBodega
		},
		watch: {
			'tmpLinea'(o) {
				if (o) {
					this.setRegLista(o)
				}
			}
		}
	}
</script>

<style>
	td {
		vertical-align:middle !important;
	}
</style>