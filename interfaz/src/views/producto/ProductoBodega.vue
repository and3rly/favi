<template>
	<div class="row mb-4">
    <div class="col">
      <input type="text" 
        class="form-control" 
        placeholder="Buscar termino..."
        v-model="filtro.termino"
      >
    </div>
  </div>

	<div class="table-responsive">
		<table class="table table-sm table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Código</th>
					<th>Nombre</th>
					<th>Costo</th>
					<th>Precio</th>
					<th>Um</th>
					<th>Marca</th>
					<th>Estado</th>
					<th class="text-center" width="150">Cantidad</th>
					<th class="text-center"></th>
				</tr>
			</thead>
			<tbody>
				<tr 
					v-for="(i, idx) in filtrada"
				>
					<th>{{ idx + 1 }}</th>
					<td>{{ i.codigo }}</td>
					<td>{{ i.nombre }}</td>
					<td>{{ i.precio }}</td>
					<td>{{ i.costo }}</td>
					<td>{{ i.nombre_um }}</td>
					<td>{{ i.nombre_marca }}</td>
					<td>{{ i.nombre_estado }}</td>
					<td class="text-center">
						<input type="number" class="form-control text-center" v-model="i.cantidad"/>
					</td>
					<td class="text-center">
						<button 
							class="btn btn-sm btn-theme"
							title="Agregar producto" 
							@click="$emit('agregar', i)"
						>
							<i class="fa fa-plus"></i>						
						</button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script>
	import Catalogo from '@/mixins/Catalogo.js'

	export default {
		name:"ProductoBodega",
		mixins: [Catalogo],
		props: {
			cat: {
				type: Array, 
				required: false
			},
			recepcion: {
				type: Object,
				required: false
			}
		},	
		data: () => ({
			filtro: {}
		}),
		created() {
			this.args.productos_bodega = {
				bodega: this.recepcion.bodega_id
			}

			this.getCatalogo(['productos_bodega'])
		},
		computed: {
			filtrada() {
				if (this.cat.productos_bodega) {
					if (this.filtro.termino) {
						return this.cat.productos_bodega.filter(obj => {
						let ter = this.filtro.termino.toLowerCase()
						let continuar = false

							for (let i in obj) {
							if (typeof obj[i] === 'string' && obj[i].toLowerCase().includes(ter)) {
								continuar = true
							}
							}

						return continuar
						})
					}
				}
				return this.cat.productos_bodega
			}
		}
	}
</script>