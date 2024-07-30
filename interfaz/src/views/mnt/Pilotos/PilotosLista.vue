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
							<th scope="col">Nombres</th>
							<th scope="col" >Apellidos</th>
							<th scope="col">No Licencia</th>
							<th scope="col">Telefono</th>
							<th class="text-center">Estado</th>
							<th scope="col">Acción</th>
						</tr>
					</thead>
					<tbody>
						<tr 
							v-if="!cargando" 
							v-for="(i, idx) in filtrada"
							style="cursor: pointer;" 
						>
							<th scope="row" class="text-center">{{ idx + 1 }}</th>
							
							<td>{{i.nombres}}</td>
							<td>{{i.apellidos}}</td>
							
							<td>{{ i.no_licencia }}</td>
							<td>{{ i.telefono }}</td>
						
							
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
										@click="verVehiculo(i)"
									    >
									    	<i class=" fas fa-car-side me-1"></i> Asignar Vehiculo
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
		class="modal fade" id="mdlVehiculoPiloto"
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
						<i class="fas fa-store me-1"></i>Piloto de Vehiculo
					</h1>
					<button 
						type="button" 
						class="btn-close" 
						aria-label="Close" 
						@click="cmVehiculo"
					>
					</button>
				</div>
				<div class="modal-body">
					<VehiculosPilotos
						v-if="pilotos != null"
						:pilotos="pilotos"
					/>
				</div>
			</div>
		</div>		
	</div>

</template>

<script>
	import General from '@/mixins/General.js'
	import VehiculosPilotos from  '@/views/mnt/Pilotos/VehiculosPilotos.vue'
	export default {
		name: 'PilotosLista',
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
			pilotos: null
		}),mounted(){

			this.modal = new this.$modal(document.getElementById('mdlVehiculoPiloto'));
		},
		
		created(){
			this.controlador = 'mnt/pilotos'
			this.autoBuscar = true
		},
		methods: {
			editar(obj, idx) {
				this.$emit('abrirModal', obj, idx)
			},
			
			verVehiculo(obj) {
				this.pilotos  = obj
				this.modal.show()
			},
			
			cmVehiculo() {
				this.pilotos = null
				this.modal.hide()
			},
		},
		components:{

VehiculosPilotos,

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