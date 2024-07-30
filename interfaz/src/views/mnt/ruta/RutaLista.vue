<template>
	<div class="card">
		<div class="card-body p-4">
			<div class="table-responsive" style="max-height: calc(100vh - 120px - 100px - 20px);">
				<table class="table table-sm table-hover mb-0" style="text-align: center;">
					<thead>
						<tr>
							<th scope="col" class="text-center" width="40">#</th>
							<th scope="col" width="100">Codigo</th>
							<th scope="col" width="100">Nombre</th>
							<th scope="col" width="100">Vendedor </th>
							<th scope="col" width="150">Venta</th>
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
									{{i.codigo}} 
								</a>
							</td>
							<td>{{ i.nombre }}</td>
							<td>{{ i.vendedor }}</td>
							<td class="text-center" >{{ i.venta }}</td>
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
		name: 'RLista',
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
		}
	}
</script>

<style>
	td {
		vertical-align:middle !important;
	}
</style>