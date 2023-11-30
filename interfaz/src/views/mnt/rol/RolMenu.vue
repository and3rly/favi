<template>
	<div class="row mt-3 mb-3">
		<div class="col-sm-12">
			<div class="alert alert-info p-2 mb-1 fw-bold m-0 rounded">
				<i class="fas fa-plus me-2"></i>Asignar accesos
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
						<div class="fw-bold">{{i.titulo}}</div>
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
					v-if="cat.menu_rol && cat.menu_rol.length > 0"
					v-for="(i,idx) in cat.menu_rol" 
					:key="idx"
					class="list-group-item d-flex justify-content-between align-items-start">
					<a
						href="javascript:;"
						title="Quitar"
						class="ms-2 me-auto"
						@click="anular_menu_rol(i, idx)"
					>
						<i class="fas fa-arrow-left" style="color: red;"></i>
					</a>
					<div class="fw-bold">
					 	{{i.titulo}}
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
		name: 'RolMenu',
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
			menus: []
		}),
		created() {
			this.menus = this.menu
			this.args.menu_rol = { rol_id: this.rol.id }
			this.getCatalogo(['menu_rol'])

			this.controlador = 'mnt/menu_rol'
		},
		methods: {
			guardar(o) {

				if (confirm("¿Está seguro?")) {
					let datos =  {rol_id: this.rol.id}

					this.$http
					.post(`${this.$baseUrl}/${this.controlador}/asignar_menu/${this.pk}`, datos)
					.then(res => {
						this.btnGuardar = false

						if (res.data.exito) {	
							this.cat.menu_rol.push(res.data.reg)					
						}

					}).catch(e => {
						this.btnGuardar = false
						console.log(e)
					})
				}
			},
			anular_menu_rol(o, idx) {
				if (confirm("¿Está seguro?")) {
					this.pk = o.id
					this.$http
					.post(`${this.$baseUrl}/${this.controlador}/anular_menu_rol/${this.pk}`)
					.then(res => {
						this.btnGuardar = false

						if (res.data.exito) {	
							this.cat.menu_rol.splice(idx, 1)		
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
				if (this.menus) {
					if (this.agregadas) {
						return this.menus.filter(e => 
							this.agregadas.indexOf(e.id) < 0
						)
					}
				}
				return []
			}
		}	
	}
</script>