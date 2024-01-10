<template>
	<ul class="breadcrumb mb-0">
		<li class="breadcrumb-item"><a href="#">Recepción</a></li>
		<li class="breadcrumb-item active">Detalle</li>
	</ul>
	<nav class="navbar navbar-expand-lg bg-light">
		<button 
				class="btn btn-secondary me-2"
				@click="$emit('regresar')"
		>
			<i class="fas fa-arrow-left"></i>
		</button>

		<a class="navbar-brand fw-bold m-0" href="#">
			<i class="fas fa-list-check me-2"></i> Detalle - Recepción #{{recepcion.id}}
		</a>

		<button 
			class="navbar-toggler" 
			type="button" 
			data-bs-toggle="collapse" 
			data-bs-target="#navbarTogglerDemo03" 
			aria-controls="navbarTogglerDemo03" 
			aria-expanded="false" 
			aria-label="Toggle navigation"
		>
			<span class="navbar-toggler-icon"></span>
		</button>

		<div 
			class="collapse navbar-collapse" 
			id="navbarTogglerDemo03"
		>
			<div class="navbar-nav me-auto">
			</div>

			<div class="mt-1">
				<button 
					class="btn btn-success me-1"
					:disabled="btnGuardar"
				>
					<i class="fas fa-print me-1"></i>Imprimir
				</button>
				<button 
					type="button" 
					class="btn btn-primary"
					@click="guardar"
					:disabled="btnGuardar"
				>	
						<span 
							v-if="btnGuardar"
							class="spinner-border spinner-border-sm me-1" 
							role="status" 
							aria-hidden="true"
						></span>
						<i v-else class="fas fa-save me-1"></i>

						<span v-if="btnGuardar">Guardando...</span>
						<span v-else>Guardar</span>
				</button>
			</div>
		</div>
	</nav>

	<ul class="list-group mt-2">
		<li class="list-group-item p-2">
			<div class="alert alert-info">
				<b>Bodega: </b> {{recepcion.nombre_bodega}} 
			</div>

			<form @submit.prevent="agregarProducto">
				<div class="d-flex">
					<div class="flex me-1">
						<input 
							type="text" 
							class="form-control text-center"
							placeholder="Cantidad" 
							v-model="cantidad"
						>
					</div>
					<div class="flex-grow-1 me-1">
						<input 
							type="text" 
							class="form-control"
							placeholder="Buscar producto por código o barra" 
							v-model="codigo"
						>
					</div>
					<div class="flex-shrink-1">
						<button 
							type="submit"
							class="btn btn-lime text-white"
						>
							<i class="fas fa-plus"></i>
						</button>
					</div>
				</div>
			</form>
		</li>
		<li class="list-group-item p-0">
			<div v-if="inicio === true" class="text-center mt-3">
	      <div class="spinner-border" role="status">
	        <span class="sr-only">Loading...</span>
	      </div>
	      <p>Cargando detalle...</p>
	    </div>
			<div class="table-responsive mt-3" v-else>
				<table class="table table-sm table-striped">
					<thead>
						<tr>
							<th class="text-center" width="50">#</th>
							<th class="text-center">Código</th>
							<th>Nombre</th>
							<th class="text-center" width="100">Cantidad Rec.</th>
							<th class="text-center" width="150">Fecha Vence</th>
							<th class="text-center" width="150">Lote</th>
							<th class="text-center" width="120">Costo</th>
							<th class="text-center" width="120">Costo Oc</th>
							<th class="text-center">UM</th>
							<th>Estado</th>
							<th>Presentación</th>
							<th width="50"></th>
						</tr>
					</thead>
					<tbody>
						<tr 
							v-for="(i, idx) in form.detalle"
							style="cursor: pointer;"
						>
							<th class="text-center">{{ idx + 1 }}</th>
							<td class="text-center">{{ i.codigo_producto }}</td>
							<td>{{ i.nombre_producto }}</td>
							<td class="text-center">
								<input 
									type="number" 
									class="form-control text-center" 
									v-model="i.cantidad_recibida"
								/>
							</td>
							<td 
								class="text-center no-wrap" 
								:class="i.control_vence == 1 && (i.fecha_vence == null || !i.fecha_vence) ? 'bg-danger bg-opacity-20': ''"
							>
								<input type="date" class="form-control text-center" v-model="i.fecha_vence">
							</td>
							<td class="text-center">
								<input 
									type="text" 
									class="form-control text-center" 
									v-model="i.lote"
									required 
								>
							</td>
							<td class="text-center">
								<input type="number" class="form-control text-center" v-model="i.costo">
							</td>
							<td class="text-center">
								<input type="number" class="form-control text-center" v-model="i.costo_oc">
							</td>
							<td class="text-center">
								<select 
									name="selectUm" 
									id="selectUm"
									class="form-select"
									v-model="i.unidad_medida_id"
								>
									<option 
										v-for="(j, idx) in cat.um" 
										:value="j.id"
									>
										{{ j.nombre }}
									</option>
								</select>
							</td>
							<td>
								<select 
									name="selectEstado" 
									id="selectEstado" 
									class="form-select"
									v-model="i.estado_producto_id"
								>
									<option 
										v-for="(k, idx) in cat.estado_prod" 
										:value="k.id"
									>
										{{ k.nombre }}
									</option>
								</select>
							</td>
							<td :class="!i.presentacion_producto_id ? 'bg-danger bg-opacity-20': ''">
								<select 
									name="selectPresentacion" 
									id="selectPresentacion"
									class="form-select"
									v-model="i.presentacion_producto_id"
								>
									<option value="">Seleccione presentación...</option>
									<option 
										v-for="(l, idx) in cat.presentacion.filter(e => {return e.producto_id == i.id_producto})" 
										:value="l.id"
									>
										{{ l.codigo }} - {{ l.factor}}
									</option>
								</select>
							</td>
							<td class="text-center">
								<button
									class="btn btn-sm btn-danger" 
									title="Eliminar" 
									@click="quitarProducto(idx)"
								>
  								<span class="fas fa-trash"></span>
  							</button>
							</td>
						</tr>
					</tbody>
					<tfoot v-if="!inicio && this.form.detalle.length == 0">
						<tr>
							<td class="text-center p-4 fw-bold" colspan="100">
								<i class="fas fa-info-circle me-1"></i>	Sin detalle
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</li>
	</ul>
</template>

<script>
	export default {
		name: 'RecepcionDetalle',
		props: {
			recepcion: {
				type: Object,
				required: true,
				default: null
			},
			cat: {
				type: Array,
				required: true
			}
		},
		data: () => ({
			btnGuardar: false,
			inicio: false,
			codigo: null, 
			cantidad: 1,
			form: {
				detalle: []
			},
			bform: {},
			controlador: 'recepcion/detalle'
		}),
		created() {
			this.bform.recepcion_enc_id = this.recepcion.id
			this.buscar()
		},
		methods: {
			buscar() {
				this.inicio = true

				this.$http
				.get(`${this.$baseUrl}/${this.controlador}/buscar`, {params: this.bform})
				.then(res => {
					this.inicio = false
					if (res.data.lista) {
						this.form.detalle = res.data.lista
					}
				}).catch(e => {
					this.inicio = false
					console.log(e)
				})
			},
			guardar() {
				if (confirm("¿Está seguro de guardar el detalle?")) {

					for (let i in this.form.detalle) {
						if (!this.form.detalle.hasOwnProperty('id')) {
							this.form.detalle[i].no_linea = parseInt(i) + 1
						}
					}

					this.btnGuardar = true
					console.log(this.fom)
					this.$http
					.post(`${this.$baseUrl}/${this.controlador}/guardar/${this.recepcion.id}`, this.form)
					.then(res => {
						this.btnGuardar = false
						if (res.data.exito) {
							this.form.detalle = res.data.lista

							this.$toast.success(res.data.mensaje)
						} else {
							this.$toast.error(res.data.mensaje)
						}

					}).catch(e => {
						this.btnGuardar = false
						console.log(e)
					})
				}
			},	
			agregarProducto() {
				if (this.codigo != null && this.codigo) {
					let tmp = this.productos.filter(e => {
						return e.codigo.toLowerCase() == this.codigo.toLowerCase() || e.barra.toLowerCase() == this.codigo.toLowerCase()
					})[0]
					
					if (tmp) {
						this.setProducto(tmp)
					} else {
						this.$toast.error("No se encontró el producto.")
					}
				} else {
					this.$toast.info("Ingrese código ó barra del producto")
				}
			},
			setProducto(obj) {
				let auxProd = this.form.detalle.filter(e => {
					return e.id_producto == obj.id_producto
				})[0]

				if (auxProd) {
					auxProd.cantidad_recibida = parseFloat(auxProd.cantidad_recibida) + parseFloat(this.cantidad)
				} else {
					this.producto = {
						id_producto: obj.id_producto,
						codigo_producto: obj.codigo,
						nombre_producto: obj.nombre,
						nombre_presentacion: null,
						nombre_unidad_medida: null,
						nombre_producto_estado: null,
						cantidad_recibida: this.cantidad,
						presentacion_producto_id: '',
						unidad_medida_id: obj.unidad_medida_id,
						estado_producto_id: obj.estado_producto_id,
						lote: '',
						fecha_vence: null,
						peso: 0,
						peso_minimo: 0,
						peso_maximo: 0,
						costo: 0,
						costo_oc: 0,
						producto_bodega_id: obj.producto_bodega,
						control_vence: obj.control_vence,
						recepcion_enc_id: this.recepcion.id
					}

					this.form.detalle.push(this.producto)
				}	
				this.codigo = null
				this.cantidad = 1
			},
			verPresentaciones(obj) {
				console.log(obj)
				let tmp = this.cat.presentacion.filter(e => {
					return e.producto_id == obj.id_producto
				})

				return tmp
			},
			quitarProducto(idx) {
	      if (confirm('¿Está seguro de quitar el producto?')) {
	        let tmp = this.form.detalle[idx]

	        if (!tmp.hasOwnProperty('id')) {
	          this.form.detalle.splice(idx, 1)
	        } 
	      }
	    }
		},
		computed: {
			productos() {
				if (this.cat.productos) {
						return this.cat.productos.filter(e => {
							return e.bodega_id === this.recepcion.bodega_id
						})
				}
				return []
			}
		},
		watch: {
		}
	}
</script>
