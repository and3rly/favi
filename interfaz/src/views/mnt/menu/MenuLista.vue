<template>
	<Card>
		<CardBody class="p-0">
			<div class="input-group mt-3 mb-4 p-2 px-3">
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
				<table class="table table-sm table-striped mb-0">
					<thead>
						<tr>
							<th scope="col" class="text-center" width="30">#</th>
							<th>Título</th>
							<th>Nombre</th>
							<th>Nivel | Padre</th>
							<th>Ruta</th>
							<th scope="col" class="text-center">Ícono</th>
							<th scope="col" class="text-center">Solicita Clave</th>
							<th scope="col" class="text-center">Estado</th>
							<th scope="col" class="text-center">Acción</th>
						</tr>
					</thead>
					<tbody>
						<tr 
							v-if="!cargando" 
							v-for="(i, idx) in filtrada"
							style="cursor: pointer;" 
						>
							<th scope="row" class="text-center">{{ idx + 1 }}</th>
							<td>
								<a 
									href="javascript:;" 
									class="text-decoration-none" 
									@click="editar(i, idx)"
								>
									{{ i.titulo }}
								</a>
							</td>
							<td> {{ i.nombre }} </td>
							<td> {{ i.nivel }} | {{ displayNulos(i.titulo_padre) }} </td>
							<td> {{ i.ruta }} </td>
							<td>
                 <i :class="i.icono+' me-2'"></i>{{ i.icono }}
              </td>
							<td class="text-center">
								<span 
									v-if="i.solicita_clave == 1"
									class="badge bg-success text-success-800 bg-opacity-25 px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center"
								>
									<i class="fa fa-check-circle text-success fs-10px fa-fw me-5px"></i> Si
								</span>

								<span 
									v-else
									class="badge bg-danger text-danger-800 bg-opacity-25 px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center"
								>
									<i class="fa fa-times-circle text-danger fs-10px fa-fw me-5px"></i> No
								</span>

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
									type="button"
									class="btn btn-sm btn-secondary me-1 ms-1" 
									@click="editar(i, idx)"
									title="Editar menú"
								>
									<i class="fas fa-edit"></i> 
								</button>
								<button 
									type="button"
									class="btn btn-sm btn-danger" 
									@click="anular_menu(i, idx)"
									title="Eliminar menú"
								>
									<i class="fas fa-trash"></i> 
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
	import Imagen from '@/components/general/Imagen.vue'

	export default {
		name: 'MenuLista',
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
			this.controlador = 'mnt/menu'
			this.autoBuscar = true
		},
		methods: {
			editar(obj, idx) {
				this.$emit('abrirModal', obj, idx)
			},
			anular_menu(obj, idx) {
				if (confirm("¿Está seguro?")) {
					this.pk = obj.id

					this.$http
					.post(`${this.$baseUrl}/${this.controlador}/anular_menu/${this.pk}`)
					.then(res => {
						this.btnGuardar = false

						if (res.data.exito) {	
							this.filtrada.splice(idx, 1)
						}

					}).catch(e => {
						this.btnGuardar = false
						console.log(e)
					})
				}
			},
      displayNulos(varDisplay) {
        return varDisplay || "No hay padre";
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