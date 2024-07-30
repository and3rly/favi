<template>
	<Card>
		<CardBody class="p-0">
			<div class="input-group mt-3 mb-3 px-3">
				<div class="input-group">
					<input 
						type="text" 
						class="form-control ps-35px"
						placeholder="Buscar..." 
						v-model="termino"
						style="border-radius: 4px;" 
					/>
					<div class="input-group-text position-absolute top-0 bottom-0 bg-none border-0" style="z-index: 1020;">
						<i class="fa fa-search opacity-5"></i>
					</div>
				</div>
			</div>

			<div class="table-responsive-sm table-responsive-lg">
				<table class="table table-sm table-hover table-striped mb-0">
					<thead>
						<tr>
							<th scope="col" class="text-center" width="40">#</th>
							<th scope="col" width="100">Código</th>
							<th scope="col" width="150">Nombre</th>
							<th scope="col" width="150">Teléfono</th>
							<th scope="col">NIT</th>
							<th scope="col">Dirección</th>
							<th scope="col">Correo</th>
							<th scope="col">Tipo de Cliente</th> 
							<th scope="col" class="text-center">Estado</th>
							<th scope="col" class="text-center" width="70">Acción</th>
						</tr>
					</thead>
					<tbody>
						<tr 
							v-if="!cargando" 
							v-for="(i, idx) in filtrada"
							style="cursor: pointer;" 
						>
							<th scope="row" class="text-center">{{ idx + 1 }}</th>
							<td>{{i.codigo}}</td>
							<td>
								<a href="javascript:;" class="text-decoration-none" @click="editar(i, idx)">
									{{ i.nombre_comercial}}
								</a>
							</td>
							<td>{{ i.telefono }}</td>
							<td>{{ i.nit }}</td>
							<td>{{ i.direccion }}</td>
							<td>{{ i.email }}</td>
							<td>{{ i.ncliente}}</td>
							<td class="text-center">
								<span 
									v-if="i.activo == 1"
									class="badge bg-success text-success-800 bg-opacity-25 px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center"
								>
									<i class="fa fa-check-circle text-success fs-10px fa-fw me-5px"></i> Activo
								</span>

								<span 
									v-else
									class="badge bg-danger text-danger-800 bg-opacity-25 px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center"
								>
									<i class="fa fa-times-circle text-danger fs-10px fa-fw me-5px"></i> Inactivo
								</span>
							</td>
							<td class="text-center">
								<div class="dropdown position-static">
									<a 
										href="javascript:;"
										data-bs-toggle="dropdown"
										aria-expanded="false" 
									>
										<i class="fas fa-ellipsis-h"></i>
									</a>
								  <div class="dropdown-menu dropdown-menu-end">
								    <a
								    	href="javascript:;" 
								    	class="dropdown-item"
											@click="verContacto(i)"
								    >
								    	<i class=" fas fa-user-plus me-1"></i>Agregar contacto
								    </a>
										<a
								    	href="javascript:;" 
								    	class="dropdown-item"
											@click="verDireccion(i)"
								    >
										<i class="fas fa-route me-1"></i>Agregar dirección
								    </a>
									<a
								    	href="javascript:;" 
								    	class="dropdown-item"
										@click="verBodega(i)"
								    >
								    	<i class=" fas fa-store me-1"></i>Agregar Bodega
								    </a>
										<a
								    	href="javascript:;" 
								    	class="dropdown-item"
											@click="verSucursal(i)"
								    >
								    	<i class=" fas fa-store me-1"></i>Agregar Sucursal
								    </a>
										<a
									    href="javascript:;" 
									    class="dropdown-item"
											@click="editar(i, idx)"
									    >
									    	<i class=" fas fa-edit me-1"></i> Editar
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
		</CardBody>
	</Card>

	<div 
		class="modal fade" id="mdlClienteContacto"
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
					<i class="fas fa-address-book me-1"></i>Cliente contacto<span v-if="cliente != null"> - {{ cliente.nombre_comercial }} </span>
					</h1>
					<button 
						type="button" 
						class="btn-close" 
						aria-label="Close" 
						@click="cmContacto"
					>
					</button>
				</div>
				<div class="modal-body">
					<ContactoForm
						v-if="cliente != null"
						:cliente="cliente"
					/>
				</div>
			</div>
		</div>
	</div>
	<div 
		class="modal fade" id="mdlClienteDireccion"
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
						<i class="fas fa-route me-1"></i>Cliente dirección <span v-if="cliente != null"> - {{ cliente.nombre_comercial }} </span>
					</h1>
					<button 
						type="button" 
						class="btn-close" 
						aria-label="Close" 
						@click="cmDireccion"
					>
					</button>
				</div>
				<div class="modal-body">
					<ClienteDireccionForm
						v-if="cliente != null"
						:cliente="cliente"
					/>
				</div>
			</div>
		</div>
	</div>	

	<div 
		class="modal fade" id="mdlClienteBodega"
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
						<i class="fas fa-store me-1"></i>Cliente bodega<span v-if="cliente != null"> - {{ cliente.nombre_comercial }} </span>
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
					<ClienteBodega
						v-if="cliente != null"
						:cliente="cliente"
					/>
				</div>
			</div>
		</div>
	</div>

	<div 
		class="modal fade" id="mdlClienteSucursal"
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
						<i class="fas fa-store me-1"></i>Cliente sucursal <span v-if="cliente != null"> - {{ cliente.nombre_comercial }} </span>
					</h1>
					<button 
						type="button" 
						class="btn-close" 
						aria-label="Close" 
						@click="cmSucursal"
					>
					</button>
				</div>
				<div class="modal-body">
					<ClienteSucursal
						v-if="cliente != null"
						:cliente="cliente"
					/>
				</div>
			</div>
		</div>		
	</div>
</template>

<script>
	import General from '@/mixins/General.js'
	import ContactoForm from '@/views/mnt/Cliente/ContactoForm.vue'
	import ClienteDireccionForm from '@/views/mnt/Cliente/ClienteDireccionForm.vue'
	import ClienteBodega from '@/views/mnt/Cliente/ClienteBodega.vue'
	import ClienteSucursal from '@/views/mnt/Cliente/ClienteSucursal.vue'

	export default {
		name: 'ClienteLista',
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
			modal2: null,
			modal3: null,
			modal4: null,
			cliente: null
		}),
		mounted() {
			this.modal = new this.$modal(document.getElementById('mdlClienteContacto'));
			this.modal2 = new this.$modal(document.getElementById('mdlClienteDireccion'));
			this.modal3 = new this.$modal(document.getElementById('mdlClienteBodega'));
			this.modal4 = new this.$modal(document.getElementById('mdlClienteSucursal'));
		
		},
		created(){
			this.controlador = 'mnt/cliente'
			this.autoBuscar = true
		},
		methods: {
			editar(obj, idx) {
				this.$emit('abrirModal', obj, idx)
				this.lista.splice(idx, 1)
			},
			anular_cliente(obj, idx) {
				if (confirm("¿Está seguro?")) {
					this.pk = obj.id

					this.$http
					.post(`${this.$baseUrl}/mnt/cliente/anular_cliente/${this.pk}`)
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
			verContacto(obj) {
				this.cliente  = obj
				this.modal.show()
			},

			verDireccion(obj) {
				this.cliente  = obj
				this.modal2.show()
			},
			verBodega(obj) {
				this.cliente  = obj
				this.modal3.show()
			},
			verSucursal(obj) {
				this.cliente  = obj
				this.modal4.show()
			},

			cmContacto() {
				this.cliente = null
				this.modal.hide()
			},
			cmDireccion() {
				this.cliente = null
				this.modal2.hide()
			},
			
			cmBodega() {
				this.cliente = null
				this.modal3.hide()
			},
			
			
			cmSucursal() {
				this.cliente = null
				this.modal4.hide()
			}
		},
		components: {
			ContactoForm,
			ClienteDireccionForm,
			ClienteBodega,
			ClienteSucursal
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