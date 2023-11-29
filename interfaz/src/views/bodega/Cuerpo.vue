<template>
	<template v-if="actual == 1">
		<h1 class="page-header fw-bold mb-1">
			Bodega
		</h1>
		<nav 
			class="navbar navbar-expand-lg navbar-light"
		>
			<button 
				class="navbar-toggler" 
				type="button" 
				data-bs-toggle="collapse" 
				data-bs-target="#navbarLight"
			>
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarLight">
				<form class="row row-cols-lg-auto g-1 align-items-center me-auto">
					<div class="col-12">
						<input 
							type="search" 
							class="form-control" 
							placeholder="Buscar por criterio"
						>
					</div>

					<div class="col-12">
						<button 
							type="submit" 
							class="btn btn-info text-white"
						>
							<i class="fas fa-search"></i>
						</button>
					</div>
				</form>	
				<button 
					class="btn btn-theme"
					@click="verBodega(null)"
				>
					<i class="fas fa-circle-plus me-2"></i>Nuevo
				</button>	
			</div>
		</nav>

		<Card class="mt-1">
			<CardBody>
				<div v-if="inicio === true" class="text-center">
		      <div class="spinner-border" role="status">
		        <span class="sr-only">Loading...</span>
		      </div>
		      <p>Cargando registros...</p>
		    </div>

				<div v-else class="table-responsive">
					<table class="table table-sm table-hover">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th class="text-center">Código</th>
								<th>Nombre</th>
								<th>Dirección</th>
								<th>Teléfono</th>
								<th>Correo</th>
								<th>Encargado</th>
								<th>Empresa</th>
								<th class="text-center">Largo</th>
								<th class="text-center">Ancho</th>
								<th class="text-center">Alto</th>
								<th class="text-center">Activo</th>
							</tr>
						</thead>
						<tbody>
							<tr 
								v-for="(i, idx) in lista" 
								:key="idx"
								@click="verBodega(i)"
								style="cursor: pointer;"
							>
								<td class="text-center">{{ idx + 1 }}</td>
								<td class="text-center">{{ i.codigo }}</td>
								<td>
									<a 
										href="javascript:;"
										@click="verBodega(i)"
									>
										{{ i.nombre }}
									</a>
								</td>
								<td>{{ i.direccion }}</td>
								<td>{{ i.telefono }}</td>
								<td>{{ i.correo }}</td>
								<td>{{ i.encargado }}</td>
								<td>{{ i.nombre_empresa }}</td>
								<td class="text-center">{{ i.largo }}</td>
								<td class="text-center">{{ i.ancho }}</td>
								<td class="text-center">{{ i.alto }}</td>
								<td class="text-center">
									<i v-if="i.activo == 1" class="fas fa-check text-success"></i>
									<i v-else  class="fas fa-times text-danger"></i>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</CardBody>
		</Card>
	</template>

	<Bodega 
		v-if="actual == 2"
		:bodega="bodega"
		@regresar="actual = 1"
	/>

</template>

<script>
	import Bodega from '@/views/bodega/Bodega.vue'

	export default {
		name: 'Cuerpo',
		data:() => ({
			inicio: false,
			lista: [],
			bform: {},
			actual: 1,
			bodega: null
		}),
		created() {
			this.buscar()
		},
		methods: {
			buscar() {
				this.inicio = true

				this.$http
				.get(`${this.$baseUrl}/bodega/bodega/buscar`, {params: this.bform})
				.then(res => {
					this.inicio = false
					if (res.data.lista) {
						this.lista = res.data.lista
					}
				}).catch(e => {
					this.inicio = false
					console.log(e)
				})
			},
			verBodega(obj) {
				this.bodega = obj
				this.actual = 2
			}
		},
		components: {
			Bodega
		}
	}
</script>