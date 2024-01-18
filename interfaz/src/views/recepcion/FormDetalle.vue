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
			Detalle - Recepción #{{recepcion.id}}
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
				<!--button 
					class="btn btn-theme me-1"
					:disabled="btnGuardar"
				>
					<i class="fas fa-print me-1"></i>Imprimir
				</button-->
				<!--button 
					type="button" 
					class="btn btn-theme"
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
				</button-->
			</div>
		</div>
	</nav>

	<Card>
		<CardBoody class="p-0">
			<div class="alert alert-danger text-center rounded-0" role="alert" v-if="pendientes">
				<i class="fas fa-info-circle me-2"> </i>Tiene cambios pendientes por guardar.
			</div>
			<form @submit.prevent="agregarProducto" class="row g-2 p-3">
				<div class="col-md-2">
					<label for="inputCantidad" class="form-label fw-bold mb-0">Cantidad</label>
					<input 
						type="text" 
						class="form-control text-center"
						placeholder="Cantidad" 
						v-model="cantidad"
						:disabled="pendientes"
					/>
				</div>

				<div class="col-md-8">
					<label for="inputCantidad" class="form-label fw-bold mb-0">Código/Barra</label>
					<div class="input-group">				  
					  <input 
					  	type="text" 
					  	class="form-control"
					  	aria-label="Example text with button addon" 
					  	aria-describedby="button-addon1"
					  	v-model="codigo"
					  	:disabled="pendientes"
					  >
					  <button 
					  	type="submit" 
					  	class="btn btn-secondary" 		  	
					  	id="button-addon1"
					  >
					  	<i class="fas fa-plus"></i>
					  </button>
					</div>
				</div>

				<div class="col-md-1 d-grid text-center">
					<br>
					<button 
						type="button"
						class="btn btn-primary btn-block"
						@click="verProductos"
						:disabled="pendientes"
					>
						<i class="fas fa-search me-1"></i> Buscar
					</button>
				</div>
				<!--div class="col-md-1 d-grid text-center">
					<br>
					<button 
						type="button"
						class="btn btn-info"
						:disabled="pendiente"
					>
						<i class="fas fa-upload me-1"></i> Cargar OC
					</button>
				</div-->
			</form>

			<div v-if="inicio === true" class="text-center mt-3">
	      <div class="spinner-border" role="status">
	        <span class="sr-only">Loading...</span>
	      </div>
	      <p>Cargando detalle...</p>
	    </div>
			<div class="table-responsive mt-3" v-else>
				<table class="table table-sm table-striped m-0">
					<thead>
						<tr>
							<th class="text-center" width="50">#</th>
							<th class="text-center">Código</th>
							<th>Nombre</th>
							<th class="text-center" width="120">
								Cantidad Rec. <span class="text-danger">*</span>
							</th>
							<th class="text-center">Fecha Vence</th>
							<th class="text-center" width="160">Lote</th>
							<th class="text-center">Costo</th>
							<th class="text-center">Costo Oc</th>
							<th class="text-center">UM</th>
							<th class="text-center"> 
								Estado <span class="text-danger">*</span>
							</th>
							<th class="text-center">
								Presentación <span class="text-danger">*</span>
							</th>
							<th width="100"></th>
						</tr>
					</thead>
					<tbody>
						<tr 
							v-for="(i, idx) in form.detalle"
							style="cursor: pointer;"
							:style="i.pendiente ? 'background-color: #FFECB3;': ''"
						>
							<th class="text-center">{{ idx + 1 }}</th>
							<td class="text-center">{{ i.codigo_producto }}</td>
							<td>{{ i.nombre_producto }}</td>
							<td class="text-center">
								<input 
									type="number" 
									class="form-control text-center" 
									v-model="i.cantidad_recibida"
									:disabled="!i.pendiente"
								/>
							</td>
							<td 
								class="text-center no-wrap" 
								:class="i.control_vence == 1 && (i.fecha_vence == null || !i.fecha_vence) ? 'bg-danger bg-opacity-20': ''"
							>
								<input type="date" class="form-control text-center" v-model="i.fecha_vence" :disabled="!i.pendiente">
							</td>
							<td class="text-center">
								<input 
									type="text" 
									class="form-control text-center" 
									v-model="i.lote"
									required
									:disabled="!i.pendiente"
								>
							</td>
							<td class="text-center">
								<input 
									type="number" 
									class="form-control text-center" 
									v-model="i.costo"
									:disabled="!i.pendiente"
								>
							</td>
							<td class="text-center">
								<input 
									type="number" 
									class="form-control text-center" 
									v-model="i.costo_oc"
									:disabled="!i.pendiente"
								>
							</td>
							<td class="text-center">
								<select 
									name="selectUm" 
									id="selectUm"
									class="form-select"
									v-model="i.unidad_medida_id"
									disabled 
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
									:disabled="!i.pendiente"
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
									:disabled="!i.pendiente"
								>
									<option value="">Seleccione presentación...</option>
									<option 
										v-for="(l, idx) in cat.presentacion.filter(e =>  {return e.producto_id == i.id_producto} )" 
										:value="l.id"
									>
										{{ l.codigo }} - {{ l.factor}}
									</option>
								</select>
							</td>
							<td class="text-center">
								<button
									v-if="i.id && !i.pendiente"
									class="btn btn-sm btn-secondary me-1 ms-1" 
									title="Editar" 
									@click="editar(i)"
									:disabled="btnGuardar"
								>
  								<span class="fas fa-edit"></span>
  							</button>
								<button
									v-if="i.pendiente"
									class="btn btn-sm btn-primary me-1 ms-1" 
									title="Guardar" 
									@click="guardar(i)"
									:disabled="btnGuardar"
								>
  								<span class="fas fa-save"></span>
  							</button>
								<button
									class="btn btn-sm btn-danger" 
									title="Eliminar" 
									@click="quitarProducto(idx)"
									:disabled="btnGuardar"
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
		</CardBoody>
	</Card>

	<div 
		class="modal fade" 
		id="mdlProducto"
		data-bs-backdrop="static" 
		data-bs-keyboard="false" 
		tabindex="-1" 
		aria-labelledby="staticBackdropLabel" 
		aria-hidden="true">

		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h1 
						class="modal-title fs-5" 
						id="staticBackdropLabel"
					> 
						<i class="fas fa-search me-1"></i> Buscar producto
					</h1>
					<button 
						type="button" 
						class="btn-close" 
						aria-label="Close"
						@click="cerrarProductos"
					>
					</button>
				</div>
				<div class="modal-body">
					<ProductoBodega
						:lista="productos"
						@agregar="setProducto"
					/>
				</div>
			</div>
		</div>
	</div>

</template>

<script>
	import ProductoBodega from '@/views/producto/ProductoBodega.vue'

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
			pendiente: false,
			inicio: false,
			codigo: null,
			moda: null, 
			cantidad: 1,
			pk_det: '',
			form: {
				detalle: []
			},
			bform: {},
			controlador: 'recepcion/detalle'
		}),
		mounted() {
			this.modal = new this.$modal(document.getElementById('mdlProducto'));
		},
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
			guardar(obj) {
				if (confirm("¿Está seguro de guardar el detalle?")) {
					this.btnGuardar = true

					let datos = obj
					if (datos.hasOwnProperty('id')) {
						this.pk_det = datos.id
	        } 

	        if (datos.control_vence) {
						if (!datos.fecha_vence) {
							this.$toast.error("Debe ingresar una fecha de vencimiento")
							this.btnGuardar = false
							return
						} else {
							if (datos.fecha_vence <= this.cat.fecha) {
								this.$toast.error("La fecha de vencimiento no debe ser menor o igual a la actual")
								this.btnGuardar = false
								return
							}
						}
					}

					if (!datos.presentacion_producto_id) {
						this.$toast.error("Debe seleccionar una presentación.")
						this.btnGuardar = false
						return
					}

					if (!datos.estado_producto_id) {
						this.$toast.error("Debe seleccionar un estado.")
						this.btnGuardar = false
						return
					}

					datos.nombre_presentacion    = this.cat.presentacion.filter(e => { return e.id == datos.presentacion_producto_id})[0].nombre 
					datos.nombre_unidad_medida   = this.cat.um.filter(e => { return e.id == datos.unidad_medida_id})[0].nombre 
					datos.nombre_producto_estado = this.cat.estado_prod.filter(e => { return e.id == datos.estado_producto_id})[0].nombre 

					this.$http
					.post(`${this.$baseUrl}/${this.controlador}/guardar/${this.pk_det}`, datos)
					.then(res => {
						this.btnGuardar = false

						let exito = res.data.exito
						let idx = this.form.detalle.indexOf(obj)

						if (exito == 1) {
							this.form.detalle[idx] = res.data.linea
							this.$toast.success(res.data.mensaje)

						} else if (exito == 2) {
							this.form.detalle[idx].pendiente = true
							this.$toast.error(res.data.mensaje)

						} else {
							this.form.detalle[idx].pendiente = false
							this.$toast.error(res.data.mensaje)
						}		

						this.btnGuardar = false	
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
						tmp.cantidad = this.cantidad
						this.setProducto(tmp)
					} else {
						this.$toast.error("No se encontró el producto.")
					}
				} else {
					this.$toast.info("Ingrese código ó barra del producto")
				}
			},
			setProducto(obj) {
				this.producto = {
					no_linea: this.form.detalle.length + 1,
					id_producto: obj.id_producto,
					codigo_producto: obj.codigo,
					nombre_producto: obj.nombre,
					nombre_presentacion: null,
					nombre_unidad_medida: null,
					nombre_producto_estado: null,
					cantidad_recibida: obj.cantidad,
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
					recepcion_enc_id: this.recepcion.id,
					pendiente: true
				}

				this.form.detalle.push(this.producto)	
				
				this.codigo = null
				this.cantidad = 1
			},
			verPresentaciones(obj) {
				let tmp = this.cat.presentacion.filter(e => {
					return e.producto_id == obj.id_producto
				})

				return tmp
			},
			editar(obj) {
				if (!this.pendientes) {
					obj.pendiente = true
				} else {
					this.$toast.error("Tiene cambios pendientes por guardar.")
				}
			},	
			quitarProducto(idx) {
	      if (confirm('¿Está seguro de quitar el producto?')) {
	        let tmp = this.form.detalle[idx]

	        if (!tmp.hasOwnProperty('id')) {
	          this.form.detalle.splice(idx, 1)
	        } else {
	        	this.eliminar_producto(this.form.detalle[idx], idx)
	        }
	      }
	    },
	    eliminar_producto(obj, idx) {
	    	this.btnGuardar = true

				this.$http
				.post(`${this.$baseUrl}/${this.controlador}/eliminar_producto/${obj.id}`)
				.then(res => {
					this.btnGuardar = false

					if (res.data.exito) {	
						this.form.detalle.splice(idx, 1)
						this.$toast.success(res.data.mensaje)
					} else {
						this.$toast.error(res.data.mensaje)
					}	

				}).catch(e => {
					this.btnGuardar = false
					console.log(e)
				})		
	    },
	    verProductos() {
	    	this.modal.show()
	    },
	    cerrarProductos() {
	    	this.modal.hide()
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
			},
			pendientes() {
				if (this.form.detalle) {
					let tmp = this.form.detalle.filter(e => {
							return e.pendiente == true
					})[0]

					if (tmp) {
						return true
					}
				}

				return false
			}
		},
		components: {
			ProductoBodega
		},
		watch: {
		
		}
	}
</script>
