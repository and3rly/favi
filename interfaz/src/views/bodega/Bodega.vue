<template>
	<ul class="breadcrumb mb-0">
		<li class="breadcrumb-item"><a href="#">Bodega</a></li>
		<li class="breadcrumb-item active">Configuración</li>
	</ul>
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
				<div class="mt-2">
					<button 
						class="btn btn-secondary me-2"
						@click="$emit('regresar')"
					>
						<i class="fas fa-arrow-left"></i>
					</button>
					<a class="navbar-brand fw-bold" href="#">
						<span> {{ bodega != null ? 'Bodega ' + bodega.nombre : 'Nueva bodega'}}</span>
					</a>
				</div>
			</div>
		</nav>

		<Card class="mt-2">
			<CardBody>
				<nav>
					<div class="nav nav-tabs" id="nav-tab" role="tablist">
						<button 
							class="nav-link active" 
							id="nav-bodega-tab" 
							data-bs-toggle="tab" 
							data-bs-target="#nav-bodega" 
							type="button" 
							role="tab" 
							aria-controls="nav-bodega" 
							aria-selected="true"
						>
							Bodega
						</button>
						<button 
							class="nav-link" 
							id="nav-area-tab" 
							data-bs-toggle="tab" 
							data-bs-target="#nav-area" 
							type="button" 
							role="tab" 
							aria-controls="nav-area" 
							aria-selected="false"
						>
							Área
						</button>
						<button 
							class="nav-link" 
							id="nav-sector-tab" 
							data-bs-toggle="tab" 
							data-bs-target="#nav-sector" 
							type="button" 
							role="tab" 
							aria-controls="nav-sector" 
							aria-selected="false"
						>
							Sector
						</button>
						<button 
							class="nav-link" 
							id="nav-tramo-tab" 
							data-bs-toggle="tab" 
							data-bs-target="#nav-tramo" 
							type="button" 
							role="tab" 
							aria-controls="nav-tramo" 
							aria-selected="false" 
						>
							Tramo
						</button>
						<button 
							class="nav-link" 
							id="nav-ubicacion-tab" 
							data-bs-toggle="tab" 
							data-bs-target="#nav-ubicacion" 
							type="button" 
							role="tab" 
							aria-controls="nav-ubicacion" 
							aria-selected="false" 
						>
							Ubicación
						</button>
					</div>
				</nav>
				<div class="tab-content" id="nav-tabContent">
					<div 
						class="tab-pane fade show active" 
						id="nav-bodega" 
						role="tabpanel" 
						aria-labelledby="nav-bodega-tab" 
						tabindex="0"
					>
						<FormBodega
							class="mt-3"
							v-if="vista == 1"
							:cat="cat"
							:bodega="bodega"
							@actualizar="actualizaBodega"
						/>
					</div>
					<div 
						class="tab-pane fade" 
						id="nav-area" 
						role="tabpanel" 
						aria-labelledby="nav-area-tab" 
						tabindex="0"
					>
						area
					</div>
					<div 
						class="tab-pane fade" 
						id="nav-sector" 
						role="tabpanel" 
						aria-labelledby="nav-sector-tab" 
						tabindex="0"
					>
						sector
					</div>
					<div 
						class="tab-pane fade" 
						id="nav-tramo" 
						role="tabpanel" 
						aria-labelledby="nav-tramo-tab" 
						tabindex="0"
					>
						tramo
					</div>
					<div 
						class="tab-pane fade" 
						id="nav-ubicacion" 
						role="tabpanel" 
						aria-labelledby="nav-ubicacion-tab" 
						tabindex="0"
					>
						ubicacion
					</div>
				</div>
			</CardBody>
		</Card>
</template>

<script>
	import FormBodega from '@/views/bodega/FormBodega.vue'

	export default {
		name:"Bodega",
		props: {
			bodega: {
				type: Object,
				required: false,
				default: null
			}
		},
		data:() => ({
			cat: [],
			vista: 1
		}),
		created() {
			this.getDatos()
		},
		methods: {
			getDatos() {
				this.inicio = true

	      this.$http
				.get(`${this.$baseUrl}/bodega/bodega/get_datos`)
				.then(res => {
					this.inicio = false
					this.cat = res.data.cat
				}).catch(e => {
					this.inicio = false
					console.log(e)
				})
			},
			actualizaBodega(obj) {
	      this.$emit("actualizar", obj)
	    },
		},
		components: {
			FormBodega
		}
	}
</script>
