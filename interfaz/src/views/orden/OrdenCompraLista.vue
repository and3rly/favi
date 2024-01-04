<template>
	<div class="card">
		<div class="card-body p-4">
			<div class="table-responsive" style="max-height: calc(100vh - 120px - 100px - 20px);">
				<table class="table table-sm table-hover mb-0">
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
						</tr>
					</thead>
					<tbody>
						<tr v-for="(i, idx) in filtrada">
							<td class="text-center fw-bold">{{idx + 1}}</td>
							<td class="text-center">
								<a 
									href="javascript:;"
									@click="$emit('editar', i, idx)" 
								>
									{{i.no_documento}} 
								</a>
                            </td>
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
	
</template>

<script>
	import General from '@/mixins/General.js'
	import Imagen from '@/components/general/Imagen.vue'

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

		}),
	}
</script>

<style>
	td {
		vertical-align:middle !important;
	}
</style>