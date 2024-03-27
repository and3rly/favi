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
				<table class="table table-sm table-hover table-striped m-0" style="text-align: center;">
					<thead>
						<tr>
							<th scope="col" class="text-center" width="40">#</th>
							<th scope="col">Código</th>
							<th scope="col">Nombre</th>
							<th scope="col">Apellido</th>
							<th scope="col">Correo</th>
							<th scope="col" >Teléfono</th>
							<th scope="col">Dirección</th>
							<th class="text-center">Estado</th>
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
							<td>{{ i.nombre }}</td>
							<td>{{ i.apellido }}</td>
							<td>{{ i.correo }}</td>
							<td>{{ i.telefono }}</td>
							<td>{{ i.direccion }}</td>
						
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
											@click="editar(i, idx)"
									    >
									    	<i class=" fas fa-edit me-1"></i> Editar
									  </a>
									  <a
									    href="javascript:;" 
									    class="dropdown-item"
											@click="verSucursal(i, idx)"
									    >
									    	<i class=" fas fa-edit me-1"></i> Agregar Sucursal
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
		class="modal fade" id="mdlEmpleadoSucursal"
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
						<i class="fas fa-store me-1"></i>Empleado sucursal <span v-if="empleado != null"> - {{ empleado.nombre }} </span>
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
					<EmpleadoSucursal
						v-if="empleado != null"
						:empleado="empleado"
					/>
				</div>
			</div>
		</div>		
	</div>
</template>

<script>
	import General from '@/mixins/General.js'

import EmpleadoSucursal from  '@/views/mnt/empleado/EmpleadoSucursal.vue'
	export default {
		name: 'EmpleadoLista',
		mixins: [General],
		props: {
			reg: {
				type: Object,
				required: false,
				default: null
			},
			tmpLinea: {
				type: Object,
				required: false,
				default: null
			},
		},
		data: () => ({
			idx: null,
			modal: null,
			empleado: null
		}),
		mounted(){
			this.modal = new this.$modal(document.getElementById('mdlEmpleadoSucursal'));
		},
	
		created(){
			this.controlador = 'mnt/Empleado'
			this.autoBuscar = true
		},
		methods: {
			editar(obj, idx) {
				this.$emit('abrirModal', obj, idx)
				this.lista.splice(idx, 1)
			},
			verSucursal(obj) {
				this.empleado  = obj
				this.modal.show()
			},
			cmSucursal() {
				this.empleado = null
				this.modal.hide()
			}
		},
		components: {
			
			EmpleadoSucursal
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