<template>
	<template v-if="actual == 1">
		<div class="d-flex py-2">
			<div class="flex-fill me-1">
				<h1 class="page-header mb-1">
					<i class="fas fa-list-alt me-1"></i>Ordenes de compra
				</h1>
			</div>
			<div class="flex-fill text-end">
				<button 
					class="btn btn-theme"
					@click="$emit('abrirModal')" 
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
				<div class="card">
					<div class="card-body p-4">
						<div class="table-responsive mt-3">
							<table class="table table-sm table-hover table-striped">
								<thead>
									<tr>
										<th class="text-center" width="40">#</th>
										<th class="text-center">No. Documento</th>
										<th class="text-center">Procedencia</th>
										<th class="text-center">Fecha Creación</th>
										<th class="text-center">Referencia</th>
										<th class="text-center">Observación</th>
										<th class="text-center">Proveedor</th>
										<th class="text-center">Bodega</th>
										<th class="text-center">Status</th>
										<th class="text-center">Tipo</th>
										<th class="text-center">Motivo Devolución</th>
										<th class="text-center">Activo</th>
										<th width="80"></th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(i, idx) in filtrada">
										<td class="text-center fw-bold">{{idx + 1}}</td>
										<td class="text-center"> {{i.no_documento}} </td>
										<td>{{ i.procedencia }}</td>
										<td> {{i.fecha_creacion}} </td>
										<td>{{ i.referencia }}</td>
										<td>{{ i.observacion }}</td>
										<td>{{ i.nombre_proveedor }}</td>
										<td>{{ i.nombre_bodega }}</td>
										<td>{{ i.nombre_estado_oc }}</td>
										<td>{{ i.nombre_tipo_oc }}</td>
										<td>{{ i.nombre_motivo_dev }}</td>
										<td class="text-center">
											<i v-if="i.activo == 1" class="fa fa-check text-success"></i>
											<i v-else class="fa fa-times text-danger" ></i>
										</td>
										<td class="text-center">
											<button
												class="btn btn-sm btn-secondary me-1"
												@click="$emit('editar', i, idx)" 
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
			</CardBody>
		</Card>
	</template>

	<OrdenCompraDetalle
		v-if="actual == 2"
		:ordenCompra="reg"
		@regresar="actual = 1"
	/>

</template>

<script>
	import General from '@/mixins/General.js'
	import OrdenCompraDetalle from '@/views/orden/OrdenCompraDetalle.vue'
	import OrdenCompraForm from '@/views/orden/OrdenCompraForm.vue'

	export default {
		name: 'OrdenCompraLista',
		mixins: [General],
		props: {
			filtrada: {
				type: Array,
				required: false
			},
			cargando: {
				type: Boolean, 
				required: false
			}
		},
		data: () => ({
			reg: {},
			actual: 1
		}),
		methods: {
			verDetalle(obj) {
				this.reg = obj
				this.actual = 2
			},
		},
		components: {
			OrdenCompraForm,
			OrdenCompraDetalle
		}
	}
</script>

<style>
	td {
		vertical-align:middle !important;
	}
</style>