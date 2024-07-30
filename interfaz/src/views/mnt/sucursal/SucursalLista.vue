<template>
	<div class="card">
		<div class="card-body p-4">
			<div class="table-responsive-sm table-responsive-lg">
				<table class="table table-sm table-hover mb-0">
					<thead>
						<tr>
							<th scope="col" class="text-center" width="40">#</th>
							<th scope="col">Nombre</th>
							<th>Razón Social</th>
							<th scope="col" class="text-center">Teléfono</th>
							<th scope="col">Dirección</th>
							<th scope="col">Encargado</th>
							<th scope="col">Correo</th>
							<th scope="col" class="text-center">Empresa</th>
							<!--th scope="col" class="text-center">Fecha Agr</th-->
							<!--th class="text-center">Acciones</th-->
						</tr>
					</thead>
					<tbody>
						<tr v-if="!cargando" v-for="(i, idx) in filtrada">
							<th scope="row" class="text-center">{{ idx + 1 }}</th>
							<td>
								<a 
									href="javascript:;" 
									class="text-decoration-none"
									@click="editar(i, idx)"
								>
									{{ i.nombre }}
								</a>
							</td>
							<td>
								{{ i.razon_social }}
							</td>
							<td class="text-center">
								{{ i.telefono }}
							</td>
							<td>
								{{ i.direccion }}
							</td>
							<td>
								{{ i.encargado }}
							</td>
							<td>
								{{ i.correo }}
							</td>
							<td class="text-center">
								{{ i.nempresa }}
							</td>
							<!--td class="text-center">
								<div class="dropdown position-static">
									<a 
										href="javascript:;"
										data-bs-toggle="dropdown"
										aria-expanded="false" 
									>
										<i class="fas fa-ellipsis-v"></i>
									</a>
								  <div class="dropdown-menu dropdown-menu-end">
								    <a 
								    	href="javascript:;" 
								    	class="dropdown-item"
								    >
								    	<i class="fas fa-project-diagram me-2"></i> Anular
								    </a>
								  </div>
								</div>
							</td-->
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
		name: 'SucursalLista',
		mixins: [General],
		props: {
			tmpLinea: {
				type: Object,
				required: false
			},
			filtrada: {
				type: Array,
				required: true
			}
		},
		data: () => ({

		}),
		created() {
			this.controlador = 'mnt/sucursal'
			this.autoBuscar = true
		},	
		methods: {
			editar(o, idx) {
				this.$emit('editar', o, idx)
				this.lista.splice(idx, 1)
			}
		},
		watch: {
			/*'tmpLinea'(o) {
				if (o) {
					this.setRegLista(o)
				}
			}*/
		}
	}
</script>