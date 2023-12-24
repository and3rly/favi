<template>
	<div class="card">
		<div class="card-body p-4">
			<div class="table-responsive-sm table-responsive-lg">
				<table class="table table-sm table-hover mb-0" style="text-align: center;"  >
					<thead>
						<tr>
							<th scope="col" class="text-center" width="40">#</th>
							<th scope="col" width="100">Código</th>
							<th scope="col" width="150">Nombre</th>
							<th scope="col" width="150">Teléfono</th>
							<th scope="col">NIT</th>
							<th  scope="col">Dirección</th>
							<th scope="col">Correo</th>
							<th scope="col">Tipo de Cliente</th> 
							<th>Activo</th>
						</tr>
					</thead>
					<tbody>
						<tr v-if="!cargando" v-for="(i, idx) in lista">
							<th scope="row" class="text-center">{{ idx + 1 }}</th>
							<td>
								<a 
									href="javascript:;" 
									class="text-decoration-none" 
									@click="editar(i, idx)"
								>
								{{i.codigo}} 
								</a>
							</td>
							<td>{{ i.nombre_comercial}}</td>
							<td>{{ i.telefono }}</td>
							<td>{{ i.nit }}</td>
							<td>{{ i.direccion }}</td>
							<td>{{ i.email }}</td>
							<td>{{ i.tipos_clientes}}</td>
							<td>
								<i v-if="i.activo == 1" class="fa fa-check text-success"></i>
								<i v-else class="fa fa-times text-danger"></i>
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
		name: 'ClienteLista',
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
			this.controlador = 'mnt/Cliente'
			this.autoBuscar = true
		},
		methods: {
			editar(obj, idx) {
				this.$emit('abrirModal', obj, idx)
			}
		}
	}
</script>

<style>
	td {
		vertical-align:middle !important;
	}
</style>