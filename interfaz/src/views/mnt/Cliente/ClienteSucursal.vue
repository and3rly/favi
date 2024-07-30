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
				
				v-if="cat.cliente_sucursal && cat.cliente_sucursal.length > 0"
					class="list-group-item d-flex justify-content-between align-items-start" 
					v-for="(i, idx) in cat.cliente_sucursal"
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
		name: 'Cliente_sucursal',
		mixins: [Catalogo],
		props: {
			cliente: {
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
			this.controlador = 'mnt/cliente_sucursal'
			this.args.cliente_sucursal = {cliente_id: this.cliente.id}
			this.getCatalogo(['cliente', 'sucursal', 'cliente_sucursal'])
		},
		methods: {
			guardar(o) {
				if (confirm("¿Está seguro?")) {
					let datos =  {cliente_id: this.cliente.id, sucursal_id: o.id}

					this.$http
					.post(`${this.$baseUrl}/${this.controlador}/asignar_cliente_sucursal/${this.pk}`, datos)
					.then(res => {
						
						this.btnGuardar = false

						if (res.data.exito) {	
							this.cat.cliente_sucursal.push(res.data.reg)					
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
					.post(`${this.$baseUrl}/${this.controlador}/anular_cliente_sucursal/${this.pk}`)
					.then(res => {
						this.btnGuardar = false

						if (res.data.exito) {	
							this.cat.cliente_sucursal.splice(idx, 1)		
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

				if (this.cat.cliente_sucursal) {
					this.cat.cliente_sucursal.forEach(e => {
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