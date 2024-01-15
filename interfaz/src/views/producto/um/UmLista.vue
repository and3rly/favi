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
							<th scope="col">Nombre</th>
							<th class="text-center">Estado</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr 
							v-for="(i, idx) in filtrada"
							style="cursor: pointer;" 
						>
							<th scope="row" class="text-center">{{idx + 1}}</th>
							<td>
								<a 
									href="javascript:;" 
									@click="$emit('editar', i, idx)"
								>
									{{i.nombre}}
								</a>
							</td>
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
								<button 
									class="btn btn-sm btn-secondary"
									@click="$emit('editar', i, idx)"
								>
									<i class="fas fa-edit"></i>
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
		</CardBody>
	</Card>
</template>

<script>
	import General from '@/mixins/General.js'

	export default {
		name: 'UmLista',
		mixins: [General],
		props: {
			tmpLinea: {
				type: Object,
				required: false,
				default: null
			}
		},
		data: () => ({

		}),
		created() {
			this.controlador = 'producto/unidad_medida'
			this.autoBuscar = true
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