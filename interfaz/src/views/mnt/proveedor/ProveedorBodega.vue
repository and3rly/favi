<template>
	<div class="row mt-3 mb-3">		
		<div class="col-sm-12">
			<div class="alert alert-info p-2 mb-1 fw-bold m-0 rounded">
				<i class="fas fa-plus me-2"></i>Asignar Bodega
			</div>
		</div>
		
		<div class="col-sm-6">
			<ul class="list-group mt-2">
				<li 
					class="list-group-item active fw-bold" 
					aria-current="true"
				>
					Disponibles
				</li>

				<li 
					v-if="disponibles.length > 0"
					v-for="(i,idx) in disponibles"
					class="list-group-item d-flex justify-content-between align-items-start">
					<div class="ms-2 me-auto">
						<div class="fw-bold">{{ i.bodega }}</div>
					</div>
					<a 
						href="javascript:;"
						@click="guardar(i)"
						title="Asignar">
						<i class="fas fa-arrow-right" style="color: ;"></i>
					</a>
				</li>
				<li
					v-else
					class="list-group-item text-center" 
				>		
					<span class="text-body-secondary">No hay disponibles.</span>
				</li>

			</ul>
		</div>
		<div class="col-sm-6">
			<ul class="list-group mt-2">
				<li 
					class="list-group-item active fw-bold" 
					aria-current="true"
				>
					Asignada
				</li>

				<li 
					v-if="cat.proveedor_bodega && cat.proveedor_bodega.length > 0"
					v-for="(i, idx) in cat.proveedor_bodega"
					:key="idx"
					class="list-group-item d-flex justify-content-between align-items-start"
				>
					<a
						href="javascript:;"
						title="Quitar"
						class="ms-2 me-auto"
						@click="anular_bodega(i, idx)"
					>
						<i class="fas fa-arrow-left" style="color: red;"></i>
					</a>
					<div class="fw-bold">
					 	{{ i.bodega }}
					</div>				
				</li>
				<li
					v-else
					class="list-group-item text-center" 
				>		
					<span class="text-body-secondary">No se tienen bodegas asignadas.</span>
				</li>
			</ul>
		</div>
	</div>
</template>

<script>
	import General from '@/mixins/General.js'
	import Catalogo from '@/mixins/Catalogo.js'

	export default {
		name: 'Proveedor-Bodega',
		mixins: [General, Catalogo],
		props: {
			proveedor: {
				type: Object,
				required: false
			}
		},
		data: () => ({
			bodegas: [],
			idx: null,
		}),
		created() {


			this.args.proveedor_bodega = {
				proveedor_id: this.proveedor.id
			}

			this.getCatalogo(['proveedor_bodega'])
			this.controlador = 'mnt/Proveedor_bodega'
		},
		methods: {
			guardar(o) {
				if (confirm("¿Está seguro?")) {
					let datos =  {proveedor_id: this.proveedor.id, bodega_id: o.id}

					this.$http
					.post(`${this.$baseUrl}/${this.controlador}/asignar_bodega/${this.pk}`, datos)
					.then(res => {
						this.btnGuardar = false

						if (res.data.exito) {	
							this.cat.proveedor_bodega.push(res.data.reg)					
						}

					}).catch(e => {
						this.btnGuardar = false
						console.log(e)
					})
				}
			},
			anular_bodega(o, idx) {
				if (confirm("¿Está seguro?")) {
					this.pk = o.id
					this.$http
					.post(`${this.$baseUrl}/${this.controlador}/anular_bodega/${this.pk}`)
					.then(res => {
						this.btnGuardar = false

						if (res.data.exito) {	
							this.cat.proveedor_bodega.splice(idx, 1)		
							this.pk = ''	
						}

					}).catch(e => {
						this.btnGuardar = false
						console.log(e)
					})
				}
			},

			getBodegas() {
			this.inicio = true
			
			this.$http
			.get(`${this.$baseUrl}/bodega/bodega/buscar`, {params: this.fbuscar})
			.then(res => {
				this.inicio = false
				this.bodegas =res.data.lista
			}).catch(e => {
				this.inicio = false
				console.log(e)
			})
		}


		},
		computed: {
			agregadas() {
				let datos = []

				if (this.cat.proveedor_bodega) {
					this.cat.proveedor_bodega.forEach(e => {
						datos.push(e.bodega_id)
					})
				}

				return datos
			},
			disponibles() {
				if (this.bodegas) {
					if (this.agregadas) {
						return this.bodegas.filter(e => 
							this.agregadas.indexOf(e.id) < 0
						)
					}
				}
				return []
			}
		}
		
	}
</script>