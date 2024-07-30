<template>
	<div class="alert alert-info">
		<i class="fas fa-lightbulb me-1"></i>
		En la columna de la derecha se muestran los vehiculos asignados al piloto <b>(se puede remover)</b>. Y en la columna de la izquierda puede seleccionar los  que se desean agregar.
	</div>

	<div class="row">
		<div class="col-sm-6">
			<ul class="list-group">
				<li 
					class="list-group-item bg-light fw-bold" 
					aria-current="true"
				>
					Disponibles
				</li>
				<li 
				v-if="disponibles.length > 0"
						v-for="(i, idx) in disponibles"
						class="list-group-item d-flex justify-content-between align-items-start">
					<div class="ms-2 me-auto">
						<div class="fw-bold">{{ i.tipo }} {{ i.marca }} {{ i.modelo }}</div>
					</div>
					<a 
						href="javascript:;"
						@click="guardar(i)"
						title="Asignar">
						<i class="fas fa-arrow-right" style="color: red;"></i>
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
			<ul class="list-group">
				<li 
					class="list-group-item bg-light fw-bold" 
					aria-current="true"
				>
					Asignadas
				</li>
				<li 
				
				v-if="cat.vehiculos_pilotos && cat.vehiculos_pilotos.length > 0"
					class="list-group-item d-flex justify-content-between align-items-start" 
					v-for="(i, idx) in cat.vehiculos_pilotos"
				>	
					<a
						href="javascript:;"
						@click="anular(i, idx)"
						title="Quitar"
						class="ms-2 me-auto"
					>
						<i class="fas fa-arrow-left" style="color: red;"></i>
					</a>

					{{ i.tipo }} {{ i.marca }} {{ i.modelo }}
				</li>
				<li
					v-else
					class="list-group-item text-center" 
				>		
					<span class="text-body-secondary">No hay asignadas</span>
				</li>
			</ul>
		</div>
	</div>
</template>

<script>
	import Catalogo from '@/mixins/Catalogo.js'

	export default {
		name: 'vehiculos_pilotos',
		mixins: [Catalogo],
		props: {
			pilotos: {
				type: Object,
				required: false
			}
		},
		data: () => ({
			controlador: null,
			btnGuardar: false,
			pk: ''
		}),
		created() {
			this.controlador = 'mnt/vehiculos_pilotos'
			this.args.vehiculos_pilotos = {pilotos_id: this.pilotos.id}
			this.getCatalogo(['pilotos', 'vehiculos', 'vehiculos_pilotos'])
		},
		methods: {
			guardar(o) {
				if (confirm("¿Está seguro?")) {
					let datos =  {pilotos_id: this.pilotos.id, vehiculos_id: o.id}

					this.$http
					.post(`${this.$baseUrl}/${this.controlador}/asignar_Vehiculos_Pilotos/${this.pk}`, datos)
					.then(res => {
						
						this.btnGuardar = false

						if (res.data.exito) {	
							this.cat.vehiculos_pilotos.push(res.data.reg)					
						}

					}).catch(e => {
						this.btnGuardar = false
						console.log(e)
					})
				
				
				}
			}
			
			
			,
			anular(o, idx) {
				console.log(o)
				if (confirm("¿Está seguro?")) {
					this.pk = o.id
					this.$http
					.post(`${this.$baseUrl}/${this.controlador}/anular_vehiculos_pilotos/${this.pk}`)
					.then(res => {
						this.btnGuardar = false

						if (res.data.exito) {	
							this.cat.vehiculos_pilotos.splice(idx, 1)		
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

				if (this.cat.vehiculos_pilotos) {
					this.cat.vehiculos_pilotos.forEach(e => {
						datos.push(e.vehiculos_id)
					})
				}

				return datos
			},
			disponibles() {
				if (this.cat.vehiculos) {
					if (this.agregadas) {
						return this.cat.vehiculos.filter(e => 
							this.agregadas.indexOf(e.id) < 0
						)
					}
				}
				return []
			}
		}
	}
</script>