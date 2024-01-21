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
							v-if="cat.rol_modulo && cat.rol_modulo.length > 0"
							v-for="(i,idx) in cat.rol_modulo" 
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
										@click="anular_modulo_rol(i, idx)"
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
		name: 'RolModulo',
		mixins: [General, Catalogo],
		props: {
			rol: {
				type: Object,
				required: false
			},
			modulo: {
				type: Array,
				required: false
			}
		},
		data: () => ({
			modulos: []
		}),
		created() {
			this.modulos = this.modulo;
			this.args.rol_modulo = { rol_id: this.rol.id }
			this.getCatalogo(['rol_modulo'])

			this.controlador = 'mnt/modulo_rol'
		},
		methods: {
			guardar(o) {

				if (confirm("¿Está seguro?")) {
					let datos =  {modulo_id: o.id, rol_id: this.rol.id}
					
					this.$http
					.post(`${this.$baseUrl}/${this.controlador}/asignar_modulo/${this.pk}`, datos)
					.then(res => {
						this.btnGuardar = false

						if (res.data.exito) {
							this.cat.rol_modulo.push(res.data.reg[0])	
						}

					}).catch(e => {
						this.btnGuardar = false
						console.log(e)
					})
				}
			},
			anular_modulo_rol(o, idx) {
				if (confirm("¿Está seguro?")) {
					this.pk = o.modulo_rol_id
					this.$http
					.post(`${this.$baseUrl}/${this.controlador}/anular_modulo_rol/${this.pk}`)
					.then(res => {
						this.btnGuardar = false

						if (res.data.exito) {	
							this.cat.rol_modulo.splice(idx, 1)		
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

				if (this.cat.rol_modulo) {
					this.cat.rol_modulo.forEach(e => {
						datos.push(e.id)
					})
				}

				return datos
			},
			disponibles() {

				if (this.modulos) {
					if (this.agregadas) {
						return this.modulos.filter(e => 
							this.agregadas.indexOf(e.id) < 0
						)
					}
				}
				
				return []
			}
		}	
	}
</script>