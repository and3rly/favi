<template>
	<div class="alert alert-info">
		<i class="fas fa-lightbulb me-1"></i>
		En la columna de la derecha se muestran las sucursales asignadas <b>(se puede remover)</b>. Y en la columna de la izquierda puede seleccionar las sucursales que se desean agregar.
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
			<ul class="list-group">
				<li 
					class="list-group-item bg-light fw-bold" 
					aria-current="true"
				>
					Asignadas
				</li>
				<li 
				
				v-if="cat.empleado_sucursal && cat.empleado_sucursal.length > 0"
					class="list-group-item d-flex justify-content-between align-items-start" 
					v-for="(i, idx) in cat.empleado_sucursal"
				>	
					<a
						href="javascript:;"
						@click="anular(i, idx)"
						title="Quitar"
						class="ms-2 me-auto"
					>
						<i class="fas fa-arrow-left" style="color: red;"></i>
					</a>

					{{ i.nombre_sucursal }}
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
		name: 'Empleado_sucursal',
		mixins: [Catalogo],
		props: {
			empleado: {
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
			this.controlador = 'mnt/empleado_sucursal'
			this.args.empleado_sucursal = {empleado_id: this.empleado.id}
			this.getCatalogo(['empleado', 'sucursal', 'empleado_sucursal'])
		},
		methods: {
			guardar(o) {
				if (confirm("¿Está seguro?")) {
					let datos =  {empleado_id: this.empleado.id, sucursal_id: o.id}

					this.$http
					.post(`${this.$baseUrl}/${this.controlador}/asignar_empleado_sucursal/${this.pk}`, datos)
					.then(res => {
						
						this.btnGuardar = false

						if (res.data.exito) {	
							this.cat.empleado_sucursal.push(res.data.reg)					
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
					.post(`${this.$baseUrl}/${this.controlador}/anular_empleado_sucursal/${this.pk}`)
					.then(res => {
						this.btnGuardar = false

						if (res.data.exito) {	
							this.cat.empleado_sucursal.splice(idx, 1)		
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

				if (this.cat.empleado_sucursal) {
					this.cat.empleado_sucursal.forEach(e => {
						datos.push(e.sucursal_id)
					})
				}

				return datos
			},
			disponibles() {
				if (this.cat.sucursal) {
					if (this.agregadas) {
						return this.cat.sucursal.filter(e => 
							this.agregadas.indexOf(e.id) < 0
						)
					}
				}
				return []
			}
		}
	}
</script>