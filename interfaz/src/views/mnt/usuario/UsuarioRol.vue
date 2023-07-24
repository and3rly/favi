<template>
	<div class="row mt-3 mb-3">
		<div class="col-sm-12">
			<div class="alert alert-info p-2 mb-1 fw-bold m-0 rounded">
				<i class="fas fa-plus me-2"></i>Asignar roles
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
					:key="idx" 
					class="list-group-item d-flex justify-content-between align-items-start"
				>
					<div class="ms-2 me-auto">
						<div class="fw-bold">{{i.nombre}}</div>
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
					v-if="cat.usuario_rol && cat.usuario_rol.length > 0"
					v-for="(i,idx) in cat.usuario_rol" 
					:key="idx"
					class="list-group-item d-flex justify-content-between align-items-start">
					<a
						href="javascript:;"
						title="Quitar"
						class="ms-2 me-auto"
						@click="anular_rol_usuario(i, idx)"
					>
						<i class="fas fa-arrow-left" style="color: red;"></i>
					</a>
					<div class="fw-bold">
					 	{{i.nrol}}
					</div>				
				</li>
				<li
					v-else
					class="list-group-item text-center" 
				>		
					<span class="text-body-secondary">No se tienen roles asignados.</span>
				</li>

			</ul>
		</div>
	</div>
</template>

<script>
	import General from '@/mixins/General.js'
	import Catalogo from '@/mixins/Catalogo.js'

	export default {
		name: 'Usuario-Rol',
		mixins: [General, Catalogo],
		props: {
			user: {
				type: Object,
				required: false
			}, 
			rol: {
				type: Array,
				required: false
			}
		},
		data: () => ({
			roles: []
		}),
		created() {
			this.roles = this.rol
			this.args.usuario_rol = { usuario_id: this.user.id}
			this.getCatalogo(['usuario_rol'])

			this.controlador = 'mnt/rol_usuario'
		},
		methods: {
			guardar(o) {
				if (confirm("¿Está seguro?")) {
					let datos =  {usuario_id: this.user.id, rol_id: o.id}

					this.$http
					.post(`${this.$baseUrl}/${this.controlador}/asignar_rol/${this.pk}`, datos)
					.then(res => {
						this.btnGuardar = false

						if (res.data.exito) {	
							this.cat.usuario_rol.push(res.data.reg)					
						}

					}).catch(e => {
						this.btnGuardar = false
						console.log(e)
					})
				}
			},
			anular_rol_usuario(o, idx) {
				if (confirm("¿Está seguro?")) {
					this.pk = o.id
					this.$http
					.post(`${this.$baseUrl}/mnt/rol_usuario/anular_rol_usuario/${this.pk}`)
					.then(res => {
						this.btnGuardar = false

						if (res.data.exito) {	
							this.cat.usuario_rol.splice(idx, 1)		
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

				if (this.cat.usuario_rol) {
					this.cat.usuario_rol.forEach(e => {
						datos.push(e.rol_id)
					})
				}

				return datos
			},
			disponibles() {
				if (this.roles) {
					if (this.agregadas) {
						return this.roles.filter(e => 
							this.agregadas.indexOf(e.id) < 0
						)
					}
				}
				return []
			}
		}	
	}
</script>