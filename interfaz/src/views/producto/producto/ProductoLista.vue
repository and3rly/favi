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
			<div class="table-responsive" style="max-height: calc(100vh - 120px - 100px - 20px);">
				<table class="table table-sm table-hover mb-0">
					<thead>
						<tr>
							<th scope="col" class="text-center" width="30">#</th>
							<th class="text-center" scope="col" width="70">Imagen</th>
							<th scope="col" width="100">Código</th>
							<!--th scope="col" width="100">Barra</th-->
							<th scope="col" width="150">Nombre</th>
							<!--th scope="col" width="150">Descripción</th-->
							<th class="text-cemter">Costo</th>
							<th class="text-cemter">Precio</th>
							<th class="text-center" scope="col">Existencia max.</th>
							<th class="text-center" scope="col">Existencia min.</th>
							<th class="text-center" scope="col">UM</th>
							<th scope="col">Marca</th>
							<th scope="col">Estado</th>
							<th scope="col">Clasificación</th>
							<th scope="col">Tipo</th>
							<th scope="col">Familia</th>
							<th class="text-center">Estado</th>
							<th class="text-center">Acción</th>
						</tr>
					</thead>
					<tbody>
						<tr 
							v-for="(i, idx) in filtrada"
							style="cursor: pointer;" 
						>
							<td scope="row" class="text-center fw-bold">{{idx + 1}}</td>
							<td class="text-center">
								<Imagen
									:imagen="i.imagen"
									:estilo="'width: 45px; height: 45px;'"
								/>
							</td>
							<td>{{ i.codigo }}</td>
							<!--td>{{ i.barra }}</td-->
							<td> 
								<a 
									href="javascript:;"
									class="text-decoration-none"
									@click="$emit('editar', i, idx)" 
								>
									{{i.nombre}} 
								</a>
							</td>
							<!--td>{{ i.descripcion }}</td-->
							<td class="text-center">{{ i.costo }}</td>
							<td class="text-center">{{ i.precio }}</td>
							<td class="text-center">{{ i.existencia_maxima }}</td>
							<td class="text-center">{{ i.existencia_minima }}</td>
							<td class="text-center">{{ i.um }}</td>
							<td>{{ i.nmarca }}</td>
							<td>
								<span 
									class="badge bg-opacity-25 px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center"
									:class="i.utilizable == 0 || i.danado == 1 ? 'bg-danger text-danger-800 ': 'bg-success text-success-800'"
								>
									<i v-if="i.utilizable == 0 || i.danado == 1" class="fa fa-times-circle text-danger fs-10px fa-fw me-5px"></i> 
									<i v-else class="fa fa-check-circle text-success fs-10px fa-fw me-5px"></i>{{ i.nestado }}
								</span>
							</td>
							<td>{{ i.nclasificacion }}</td>
							<td>{{ i.ntipo }}</td>
							<td>{{ i.nfamilia }}</td>
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
											@click="$emit('editar', i, idx)"
								    >
								    	<i class=" fas fa-edit"></i>Editar producto
								    </a>
								    <a
								    	href="javascript:;" 
								    	class="dropdown-item"
											@click="verPresentacion(i)"
								    >
										<i class="fas fa-boxes-stacked"></i>Asignar presentacion
								    </a>
								     <a
								    	href="javascript:;" 
								    	class="dropdown-item"
											@click="verBodega(i)"
								    >
										<i class="fas fa-store me-1"></i>Asignar bodega
								    </a>
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
		class="modal fade" 
		id="mdlPresentacion"
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
						<i class="fas fa-boxes-stacked me-1"></i> Presentación 
						<span v-if="producto != null"> - {{ producto.nombre }}</span>
					</h1>
					<button 
						type="button" 
						class="btn-close" 
						aria-label="Close"
						@click="cerrarPresentacion"
					>
					</button>
				</div>
				<div class="modal-body">
					<Presentacion
						v-if="producto != null"
						:producto="producto"
					/>
				</div>
			</div>
		</div>
	</div>

		<div 
		class="modal fade" id="mdlProductobodega"
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
						<i class="fas fa-store me-1"></i> Producto bodega <span v-if="producto != null">- {{ producto.nombre }}</span>
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
					<ProductoBodega
						v-if="producto != null"
						:producto="producto"
					/>
				</div>
			</div>
		</div>	
	</div>

</template>

<script>
	import General from '@/mixins/General.js'
	import Imagen from '@/components/general/Imagen.vue'
	import Presentacion from '@/views/producto/presentacion/Presentacion.vue'
	import ProductoBodega from '@/views/producto/producto/ProductoBodega.vue'

	export default {
		name: 'ProductoLista',
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
			modal: null,
			producto: null,
			modal2:null
		}),
		mounted() {
			this.modal = new this.$modal(document.getElementById('mdlPresentacion'));
			this.modal2 = new this.$modal(document.getElementById('mdlProductobodega'));
		},
		created() {
			this.controlador = 'producto/producto'
			this.autoBuscar = true
		},
		methods: {
			verPresentacion(obj) {
				this.producto = obj
				this.modal.show()
			},
			cerrarPresentacion() {
				this.producto = null
				this.modal.hide()
			},
			verBodega(obj) {
				this.producto  = obj
				this.modal2.show()
			},
			cmBodega() {
				this.producto = null
				this.modal2.hide()
			}
		},
		components: {
			Imagen,
			Presentacion,
			ProductoBodega
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