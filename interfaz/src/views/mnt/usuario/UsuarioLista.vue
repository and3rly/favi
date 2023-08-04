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
							<!--th scope="col" class="text-center">Sucursal</th-->		
							<!--th scope="col" class="text-center">Rol</th-->
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
								<a 
									href="javascript:;" 
									class="text-decoration-none" 
									@click="editar(i, idx)"
								>
									{{ i.nombre }} {{ i.apellido }}
								</a>
							</td>
							<td class="text-center">{{ i.usuario }}</td>
							<td class="text-center">{{ i.telefono}}</td>
							<td class="text-center">{{ i.correo }}</td>
							<!--td class="text-center">{{ i.nsucursal }}</td-->
							<!--td class="text-center">{{ i.rol }}</td-->
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
								    <!--a 
								    	href="javascript:;" 
								    	class="dropdown-item"
								    >
								    	<i class="fas fa-project-diagram me-2"></i>Asignar sucursales
								    </a>

								    <a 
								    	href="javascript:;" 
								    	class="dropdown-item"
								    	@click="verRoles(i)"
								    >
								    	<i class="fas fa-user-plus me-2"></i>Asignar rol
								    </a-->

								    <a
								    	href="javascript:;" 
								    	class="dropdown-item"
								    	@click="anular_usuario(i, idx)"
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
			},
			tmpLinea: {
				type: Object,
				required: false
			},
		},
		data: () => ({
			idx: null
		}),
		created(){
			this.controlador = 'usuario'
			this.autoBuscar = true
		},
		methods: {
			editar(obj, idx) {
				this.$emit('abrirModal', obj, idx)
			}, 
			verRoles(obj) {
				this.$emit('abrirRoles', obj)
			},
			anular_usuario(obj, idx) {
				if (confirm("¿Está seguro?")) {
					this.pk = obj.id

					this.$http
					.post(`${this.$baseUrl}/usuario/anular_usuario/${this.pk}`)
					.then(res => {
						this.btnGuardar = false

						if (res.data.exito) {	
							this.lista.splice(idx, 1)
						}

					}).catch(e => {
						this.btnGuardar = false
						console.log(e)
					})
				}
			}
		},
		components: {
			Imagen
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