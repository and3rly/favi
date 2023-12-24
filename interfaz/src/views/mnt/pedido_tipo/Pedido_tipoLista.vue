<template>
	<div class="card">
		<div class="card-body p-4">
			<div class="table-responsive" style="max-height: calc(100vh - 120px - 100px - 20px);">
				<table class="table table-sm table-hover mb-0" style="text-align: center;">
					<thead>
						<tr>
                            
													<th scope="col" >#</th>
													<th scope="col">Nombre</th>
													<th scope="col">Descripción</th>
							<th class="text-center">reservado</th>
						</tr>
                        
					</thead>
					<tbody>
						<tr v-for="(i, idx) in filtrada">
							<td scope="row" class="text-center fw-bold">{{idx + 1}}</td>
							<td>
								<a 
									href="javascript:;"
									@click="$emit('editar', i, idx)" 
								>
									{{i.nombre}} 
								</a>
							</td>
                            <td>{{i.descripcion}}</td>
                            <td class="text-center">
								<i v-if="i.reservar_stock == 1" class="fa fa-check text-success"></i>
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

	export default {
		name: 'Pedido_tipoLista',
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

		})
	}
</script>

<style>
	td {
		vertical-align:middle !important;
	}
</style>