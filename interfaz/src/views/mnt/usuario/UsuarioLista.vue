<template>
	<div class="card">
		<div class="card-body p-4">
			<div class="table-responsive-sm table-responsive-lg">
				<table class="table table-sm table-hover mb-0">
					<thead>
						<tr>
							<th scope="col" class="text-center" width="30">#</th>
							<th scope="col" class="text-center">Foto</th>
							<th>Nombre</th>
							<th scope="col" class="text-center">Usuario</th>
							<th scope="col" class="text-center">Teléfono</th>
							<th scope="col" class="text-center">Correo</th>
							<th scope="col" class="text-center">Sucursal</th>		
							<th scope="col" class="text-center">Rol</th>
							<th scope="col" class="text-center">Estado</th>
							<th scope="col" class="text-center" width="70">Acción</th>
						</tr>
					</thead>
					<tbody>
						<tr v-if="!cargando" v-for="(i, idx) in lista">
							<th scope="row" class="text-center">{{ idx + 1 }}</th>
							<td class="text-center">
								<Imagen
									:imagen="i.foto"
									:estilo="'width: 42px; height: 42px;'"
									:clase="'rounded-circle'"
								/>
							</td>
							<td>
								<a href="javascript:;" @click="editar(idx, i)">
									{{ i.nombre }} {{ i.apellido }}
								</a>
							</td>
							<td class="text-center">{{ i.usuario }}</td>
							<td class="text-center">{{ i.telefono}}</td>
							<td class="text-center">{{ i.correo }}</td>
							<td class="text-center">{{ i.nsucursal }}</td>
							<td class="text-center">{{ i.rol }}</td>
							<td class="text-center">
								<span 
									v-if="i.activo == 1"
									class="badge text-bg-teal text-white px-2 pt-5px pb-5px"
									style="min-width: 65px;"
								>
									<i class="fa fa-check"></i> Activo
								</span>
								<span 
									v-else
									class="badge text-bg-danger px-2 pt-5px pb-5px"
									style="min-width: 65px;"
								>
									<i class="fa fa-times"></i> Inactivo
								</span>
							</td>
							<td class="text-center">
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
								    	<i class="fas fa-project-diagram me-2"></i>Asignar sucursales
								    </a>

								    <a 
								    	href="javascript:;" 
								    	class="dropdown-item"
								    >
								    	<i class="fas fa-user-plus me-2"></i>Asignar rol
								    </a>

								    <a
								    	href="javascript:;" 
								    	class="dropdown-item"
								    >
								    	<i class=" fas fa-trash-alt me-2"></i>Anular
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
	import Imagen from '@/components/general/Imagen.vue'

	export default {
		name: 'UsuarioLista',
		mixins: [General],
		props: {
			reg: {
				type: Object,
				required: false
			}
		},
		data: () => ({
			idx: null
		}),
		created(){
			this.controlador = 'usuario'
			this.autoBuscar = true
		},
		methods: {
			editar(idx, obj) {
				this.idx = idx
				let tmp = obj
				this.$emit('abrirModal', idx, tmp)
			}
		},
		components: {
			Imagen
		}
	}
</script>

<style>
	td {
		vertical-align:middle !important;
	}
</style>