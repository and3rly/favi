<template>
	<div class="alert alert-info">
		<i class="fas fa-lightbulb me-1"></i>
		En la columna de la derecha se muestran las bodegas asignadas <b>(se puede remover)</b>. Y en la columna de la izquierda puede seleccionar las bodegas que se desean agregar.
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
					class="list-group-item d-flex justify-content-between align-items-start" 
					v-for="(i, idx) in disponibles"
				>
					<div class="ms-2 me-auto">
						{{ i.nombre }}
					</div>
					<a 
						href="javascript:;"
						@click="guardar(i)"
						title="Asignar"
					>
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
				v-if="cat.producto_bodega && cat.producto_bodega.length > 0"
					
					class="list-group-item d-flex justify-content-between align-items-start" 
					v-for="(i, idx) in cat.producto_bodega"
				>	
					<a
						href="javascript:;"
						@click="anular(i, idx)"
						title="Quitar"
						class="ms-2 me-auto"
					>
						<i class="fas fa-arrow-left" style="color: red;"></i>
					</a>

					{{ i.bodega_nombre }}
				</li>
				<li
					v-else
					class="list-group-item text-center" 
				>		
					<span class="text-body-secondary">No hay asignadas.</span>
				</li>
			</ul>
		</div>
	</div>
</template>

<script>
	import Catalogo from '@/mixins/Catalogo.js'

	export default {
		name: 'Producto_bodega',
		mixins: [Catalogo],
		props: {
			producto: {
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
			this.controlador = 'producto/producto_bodega'
			this.args.producto_bodega = {producto_id: this.producto.id}
			this.getCatalogo(['producto', 'bodega', 'producto_bodega'])
		},
		methods: {
			guardar(o) {
				if (confirm("¿Está seguro?")) {
					let datos =  {producto_id: this.producto.id, bodega_id: o.id}

					this.$http
					.post(`${this.$baseUrl}/${this.controlador}/asignar_producto_bodega/${this.pk}`, datos)
					.then(res => {
						this.btnGuardar = false

						if (res.data.exito) {	
							this.cat.producto_bodega.push(res.data.reg)					
						}

					}).catch(e => {
						this.btnGuardar = false
						console.log(e)
					})
				}
			},
			anular(o, idx) {
				console.log(o)
				if (confirm("¿Está seguro?")) {
					this.pk = o.id
					this.$http
					.post(`${this.$baseUrl}/${this.controlador}/anular_producto_bodega/${this.pk}`)
					.then(res => {
						this.btnGuardar = false

						if (res.data.exito) {	
							this.cat.producto_bodega.splice(idx, 1)		
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

				if (this.cat.producto_bodega) {
					this.cat.producto_bodega.forEach(e => {
						datos.push(e.bodega_id)
					})
				}

				return datos
			},
			disponibles() {
				if (this.cat.bodega) {
					if (this.agregadas) {
						return this.cat.bodega.filter(e => 
							this.agregadas.indexOf(e.id) < 0
						)
					}
				}
				return []
			}
		}
	}
</script>