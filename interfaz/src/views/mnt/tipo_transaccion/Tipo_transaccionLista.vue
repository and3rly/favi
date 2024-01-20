<template>
	<div class="card">
		<div class="card-body p-4">
			<div class="table-responsive" style="max-height: calc(100vh - 120px - 100px - 20px);">
				<table class="table table-sm table-hover mb-0" style="text-align: center;">
					<thead>
						<tr>
							<th scope="col" class="text-center" width="40">#</th>
							<th scope="col" >Nombre</th>
							<th scope="col">Activo</th>
							<th scope="col" >Acción</th>
						</tr>
					</thead>
					<tbody>
						
						<tr 
							v-if="!cargando" 
							v-for="(i, idx) in filtrada"
							style="cursor: pointer;" 
						>
							<td scope="row" class="text-center">{{idx + 1}}</td>
					
							<td>{{ i.nombre }}</td>
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
										@click="$emit('editar', i, idx)" 
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
		</div>
	</div>
	
</template>

<script>
	import General from '@/mixins/General.js'

	export default {
		name: 'Transaccion',
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