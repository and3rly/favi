<template>
	<div class="card">
		<div class="card-body p-4">
			<div class="table-responsive" style="max-height: calc(100vh - 120px - 100px - 20px);">
				<table class="table table-sm table-hover mb-0">
					<thead>
						<tr>
							<th scope="col" class="text-center" width="40">#</th>
							<th class="text-center" scope="col" width="100">Imagen</th>
							<th scope="col" width="100">Nombre</th>
							<th scope="col" width="100">Razón Social </th>
							<th scope="col" width="150">Representante Legal</th>
							<th class="text-center" scope="col" width="150">Nit</th>
							<th class="text-center" scope="col">Dirección</th>
							<th class="text-center" scope="col">Teléfono</th>
							<th class="text-center" scope="col">Correo</th>
							<th class="text-center">Activo</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(i, idx) in filtrada">
							<td scope="row" class="text-center fw-bold">{{idx + 1}}</td>
							<td class="text-center">
								<Imagen
									:imagen="i.imagen"
									:estilo="'width: 42px; height: 42px;'"
									:clase="'rounded-circle'"
								/>
							</td>
							<td>
								<a 
									href="javascript:;"
									@click="$emit('editar', i, idx)" 
								>
									{{i.nombre}} 
								</a>
							</td>
							<td>{{ i.razon_social }}</td>
							<td>{{ i.representante }}</td>
							<td class="text-center" >{{ i.nit }}</td>
							<td>{{i.direccion}}</td>
							<td>{{i.telefono}}</td>
							<td>{{i.correo}}</td>
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
		name: 'EmpresaLista',
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