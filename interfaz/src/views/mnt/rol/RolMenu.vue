<template>
	<div class="row mt-3 mb-3">
		<div class="col-sm-6">
			<Card>
				<CardHeader class="fw-bold">
					Disponibles
				</CardHeader>
				<CardBody class="p-0">
					<div class="list-group list-group-flush">
						<div 
							class="list-group-item list-group-item-action"
							v-if="disponibles.length > 0"
							v-for="(i,idx) in disponibles" 
							:key="idx"
						>
							<div class="d-flex">
								<div class="flex-grow-1">
									{{ i.nombre }}
								</div>
								<div class="">
									<a 
										type="button" 
										href="javascript:;"
										@click="guardar(i)"
										title="Asignar">
										<i class="fas fa-arrow-right" style="color: ;"></i>
									</a>
								</div>
							</div>
						</div>
						<div 
							class="mb-1 row"
							v-else
						>		
							<span class="text-body-secondary">No hay disponibles.</span>
						</div>
					</div>
				</CardBody>
			</Card>
		</div>
		<div class="col-sm-6">
			<Card>
				<CardHeader class="fw-bold">
					Asignadas
				</CardHeader>
				<CardBody class="p-0">
					<div class="list-group list-group-flush">
						<div 
							class="list-group-item list-group-item-action"
							v-if="cat.rol_menu && cat.rol_menu.length > 0"
							v-for="(i,idx) in cat.rol_menu" 
							:key="idx"
						>
							<div class="d-flex">
								<div class="flex-grow-1">
									{{ i.nombre }}
								</div>
								<div class="">
									<a 
										type="button" 
										title="Quitar"
										class="ms-2 me-auto"
										@click="anular_menu_rol(i, idx)"
									>
										<i class="fas fa-arrow-left" style="color: red;"></i>
									</a>
								</div>
							</div>
						</div>
						<div 
							class="mb-1 row"
							v-else
						>		
							<span class="text-body-secondary">No se tienen roles asignados.</span>
						</div>
					</div>
				</CardBody>
			</Card>
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
			rol: {
				type: Object,
				required: false
			},
			menu: {
				type: Array,
				required: false
			}
		},
		data: () => ({
			menus: []
		}),
		created() {
			this.menus = this.menu;
			this.args.rol_menu = { rol_id: this.rol.id }
			this.getCatalogo(['rol_menu','menu_modulo_filter'])

			this.controlador = 'mnt/menu_rol'
		},
		methods: {
			guardar(o) {

				if (confirm("¿Está seguro?")) {
					let datos =  {menu_modulo_id: o.id, rol_id: this.rol.id}
					
					this.$http
					.post(`${this.$baseUrl}/${this.controlador}/asignar_menu/${this.pk}`, datos)
					.then(res => {
						this.btnGuardar = false

						if (res.data.exito) {
							this.cat.rol_menu.push(res.data.reg[0])	
						}

					}).catch(e => {
						this.btnGuardar = false
						console.log(e)
					})
				}
			},
			anular_menu_rol(o, idx) {
				if (confirm("¿Está seguro?")) {
					this.pk = o.menu_rol_id
					this.$http
					.post(`${this.$baseUrl}/${this.controlador}/anular_menu_rol/${this.pk}`)
					.then(res => {
						this.btnGuardar = false

						if (res.data.exito) {	
							this.cat.rol_menu.splice(idx, 1)		
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

				if (this.cat.rol_menu) {
					this.cat.rol_menu.forEach(e => {
						datos.push(e.id)
					})
				}

				return datos
			},
			disponibles() {

				if (this.cat.menu_modulo_filter) {
					if (this.agregadas) {
						return this.cat.menu_modulo_filter.filter(e => 
							this.agregadas.indexOf(e.id) < 0
						)
					}
				}
				
				return []
			}
		}	
	}
</script>