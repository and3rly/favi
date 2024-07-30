<template>
	<div class="row mt-3 mb-3">		
		<div class="col-sm-12">
			<div class="alert alert-info p-2 mb-1 fw-bold m-0 rounded">
				<i class="fas fa-plus me-2"></i>Asignar sucursales
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
						<div class="fw-bold">{{ i.nombre }}</div>
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
					Asignadas
				</li>

				<li 
					v-if="cat.usuario_sucursal && cat.usuario_sucursal.length > 0"
					v-for="(i, idx) in cat.usuario_sucursal"
					:key="idx"
					class="list-group-item d-flex justify-content-between align-items-start"
				>
					<a
						href="javascript:;"
						@click="anular_sucursal(i, idx)"
						title="Quitar"
						class="ms-2 me-auto"
					>
						<i class="fas fa-arrow-left" style="color: red;"></i>
					</a>
					<div class="fw-bold">
					 	{{ i.nsucursal }}
					</div>				
				</li>
				<li
					v-else
					class="list-group-item text-center" 
				>		
					<span class="text-body-secondary">No se tienen sucursales asignadas.</span>
				</li>
			</ul>
		</div>
	</div>
</template>

<script>
	import General from '@/mixins/General.js'
	import Catalogo from '@/mixins/Catalogo.js'

	export default {
		name: 'Usuario-Sucursal',
		mixins: [General, Catalogo],
		props: {
			user: {
				type: Object,
				required: false
			},
			sucursal: {
				type: Array,
				required: false
			}
		},
		data: () => ({
			sucursales: []
		}),
		created() {
			this.sucursales = this.sucursal
			this.args.usuario_sucursal = {
				usuario_id: this.user.id
			}

			this.getCatalogo(['usuario_sucursal'])
			this.controlador = 'mnt/usuario_sucursal'
		},
		methods: {
			guardar(o) {
				if (confirm("¿Está seguro?")) {
					let datos =  {usuario_id: this.user.id, sucursal_id: o.id}

					this.$http
					.post(`${this.$baseUrl}/${this.controlador}/asignar_sucursal/${this.pk}`, datos)
					.then(res => {
						this.btnGuardar = false

						if (res.data.exito) {	
							this.cat.usuario_sucursal.push(res.data.reg)					
						}

					}).catch(e => {
						this.btnGuardar = false
						console.log(e)
					})
				}
			},
			anular_sucursal(o, idx) {
				if (confirm("¿Está seguro?")) {
					this.pk = o.id
					this.$http
					.post(`${this.$baseUrl}/${this.controlador}/anular_sucursal/${this.pk}`)
					.then(res => {
						this.btnGuardar = false

						if (res.data.exito) {	
							this.cat.usuario_sucursal.splice(idx, 1)		
							this.pk = ''	
						}

					}).catch(e => {
						this.btnGuardar = false
						console.log(e)
					})
				}
			}
		},
		computed: {
			agregadas() {
				let datos = []

				if (this.cat.usuario_sucursal) {
					this.cat.usuario_sucursal.forEach(e => {
						datos.push(e.sucursal_id)
					})
				}

				return datos
			},
			disponibles() {
				if (this.sucursales) {
					if (this.agregadas) {
						return this.sucursales.filter(e => 
							this.agregadas.indexOf(e.id) < 0
						)
					}
				}
				return []
			}
		}
		
	}
</script>