<template>
	<template v-if="actual == 1">
		<h1 class="page-header fw-bold mb-1">
			Recepción
		</h1>
		<nav 
			class="navbar navbar-expand-lg navbar-light"
		>
		<a href="" class="navbar-brand m-0"></a>

			<button 
				class="navbar-toggler" 
				type="button" 
				data-bs-toggle="collapse" 
				data-bs-target="#navbarLight"
				aria-controls="navbarLight" 
		    aria-expanded="false" 
		    aria-label="Toggle navigation"
			>
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarLight">

				<form class="row row-cols-lg-auto g-1 align-items-center me-auto my-2">
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
					@click="verRecepcion(null)"
					class="btn btn-theme"
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
								<th class="text-center">Observación</th>
								<th>Marchamo</th>
								<th>Guía</th>
								<th>Fecha recepción</th>
								<th>Hora inicio</th>
								<th>Hora fin</th>
								<th>Bodega</th>
								<th>Transacción</th>
								<th class="text-center">Estado</th>
								<th class="text-center">Ingresa a stock</th>
								<th class="text-center">Anulada</th>
								<th class="text-center">Activo</th>
							</tr>
						</thead>
						<tbody>
							<tr 
								v-for="(i, idx) in lista" 
								:key="idx"
								style="cursor: pointer;"
							>
								
							</tr>
						</tbody>
					</table>
				</div>
			</CardBody>
		</Card>
	</template>

	<Form 
		v-if = "actual == 2"
		@regresar = "actual = 1"
	/>
</template>

<script>
	import Form from '@/views/recepcion/Form.vue'

	export default {
		data:() =>({
			lista: [],
			reg: {},
			actual: 1,
			inicio: false
		}),
		created() {
			this.buscar()
		},
		methods: {
			buscar() {
				this.inicio = true

				this.$http
				.get(`${this.$baseUrl}/recepcion/principal/buscar`, {params: this.bform})
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
			verRecepcion(obj) {
				this.reg = obj
				this.actual = 2
			}
		},
		components: {
			Form
		}
	}
</script>