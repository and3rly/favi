<template>
	<ul class="breadcrumb mb-0">
		<li class="breadcrumb-item"><a href="#" @click="$emit('regresar')">Ordenes de compra</a></li>
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
			Detalle - Orden de Compra #{{this.ordenCompra.no_documento}}
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
			</div>
		</div>
	</nav>
	
	<Card>
		<CardBody class="p-0">
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
			</form>

			<div v-if="inicio === true" class="text-center mt-3">
				<div class="spinner-border" role="status">
					<span class="sr-only">Loading...</span>
				</div>
				<p>Cargando detalle...</p>
			</div>

			<div class="table-responsive mt-3" v-else>
				<table class="table table-sm m-0">
					<thead>
						<tr>
							<th class="text-center" width="40">#</th>
							<th class="text-center">No. Linea</th>
							<th class="text-center">Código Producto</th>
							<th class="text-center">Nombre Producto</th>
							<th class="text-center">Presentación</th>
							<th class="text-center">Unidad de Medida</th>
							<th class="text-center">Cantidad / Recibida</th>
							<th class="text-center">Peso / Recibido</th>
							<th class="text-center">Motivo Devolución</th>
							<th class="text-center">Total</th>
							<th class="text-center">Activo</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr 
							v-for="(i, idx) in form.detalle"
							style="cursor: pointer;"
							:style="i.pendiente ? 'background-color: #FFECB3;': ''"
						>
							<td class="text-center fw-bold">{{idx + 1}}</td>
							<td class="text-center"> {{ i.no_linea }} </td>
							<td class="text-center">{{ i.codigo_producto_j }}</td>
							<td>{{ i.nombre_producto_j }}</td>
							<td class="text-center">
								<div v-if="i.pendiente">
									<select 
										style="width: 110px;"
										name="selectPresentacion" 
										id="selectPresentacion"
										class="form-select"
										v-model="i.presentacion_producto_id"
										:disabled="!i.pendiente"
									>
										<option :value="null">Seleccione presentación...</option>
										<option 
											v-for="(l, idx) in cat.presentacion.filter(e =>  {return e.producto_id == i.id_producto_j} )" 
											:value="l.id"
										>
											{{ l.codigo }} - {{ l.factor}}
										</option>
									</select>
								</div>
								<a v-else>{{ i.codigo_presentacion_j }} - {{ i.nombre_presentacion_j }}</a>
							</td>
							<td class="text-center">
								<div v-if="i.pendiente">
									<select 
										style="width: 110px;"
										name="selectUm" 
										id="selectUm"
										class="form-select"
										v-model="i.unidad_medida_id"
										disabled 
									>
										<option 
											v-for="(j, idx) in cat.um.filter(e =>  {return e.id == i.unidad_medida_id} )"  
											:value="j.id"
										>
											{{ j.nombre }}
										</option>
									</select>
								</div>
								<a v-else>{{ i.nombre_unidad_medida_j }}</a>
							</td>
							<td class="text-center">
								<div v-if="i.pendiente" style="display: flex;">
									<input
										style="width: 75px;"
										type="number" 
										class="form-control text-center" 
										v-model="i.cantidad"
										:disabled="!i.pendiente"
										@change="onChangeQuantity($event,idx)"
									/>
									<h4>/</h4>
									<input
										style="width: 75px;"
										type="number" 
										class="form-control text-center" 
										v-model="i.cantidad_recibida"
										:disabled="true"
									/>
								</div>
								
								<a v-else>{{ i.cantidad }} / {{ i.cantidad_recibida }}</a>
							</td>
							<td class="text-center">
								<div v-if="i.pendiente" style="display: flex;">
									<input
										style="width: 75px;"
										type="number" 
										class="form-control text-center" 
										v-model="i.peso"
										:disabled="!i.pendiente"
									/>
									<h4>/</h4>
									<input
										style="width: 75px;"
										type="number" 
										class="form-control text-center" 
										v-model="i.peso_recibido"
										:disabled="true"
									/>
								</div>
								
								<a v-else>{{ i.peso }} / {{ i.peso_recibido }}</a>
							</td>
							<td class="text-center">
								<div v-if="i.pendiente">
									<select 
										style="width: 150px;"
										name="selectMD" 
										id="selectMD" 
										class="form-select"
										v-model="i.motivo_devolucion_id"
										:disabled="!i.pendiente"
									>	
										<option :value="null">Seleccione Motivo...</option>
										<option v-for="(j, idx) in cat.motivo_devolucion" :value="j.id">{{ j.nombre ? j.nombre : 'Sin motivo' }}</option>
									</select>
								</div>
								
								<a v-else>{{ i.nombre_motivo_dev ? i.nombre_motivo_dev : 'Sin motivo' }}</a>
							</td>
							<td class="text-center">
								<div v-if="i.pendiente">
									<input
										style="width: 90px;"
										type="number"
										class="form-control text-center"
										v-model="i.total_linea"
										:disabled="!i.pendiente"
									/>
								</div>
								<a v-else>{{ i.total_linea }}</a>
							</td>
							<td class="text-center">
								<i v-if="i.activo == 1" class="fa fa-check text-success"></i>
								<i v-else class="fa fa-times text-danger" ></i>
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
		</CardBody>
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
						v-if="vp"
						:recepcion="ordenCompra"
						@agregar="setProducto"
					/>
				</div>
			</div>
		</div>
	</div>

</template>

<script>
	import General from '@/mixins/General.js'
	import Catalogo from '@/mixins/Catalogo.js'
	import OrdenCompraAgregarDetalle from '@/views/orden/orden_detalle/OrdenCompraAgregarDetalle.vue'
	import ProductoBodega from '@/views/producto/ProductoBodega.vue'
	import { Tab } from 'bootstrap'

	export default {
		name: 'OrdenCompraDetalle',
		mixins: [General,Catalogo],
		props: {
			cargando: {
				type: Boolean, 
				required: false
			},
			ordenCompra: {
				type: Object,
				required: true,
				default: null
			}
		},
		data: () => ({
			btnGuardar: false,
            reg: null,
			modal: null,
			vp: false,
			pendiente: false,
			inicio: false,
			codigo: null,
			no_linea_last: 0,
			pk_det: '',
			form: {
				detalle: []
			},
			form2: {
				detalle: []
			},
			bform: {},
			bform2: {},
			verForm: false,
			controlador: 'orden/detalle/OrdenCompraDetalle'
        }),
		created() {
			this.getCatalogo([
                "producto_bodega_orden",
                "presentacion",
                "um",
                "motivo_devolucion",
				"productos_bodega"
            ])
			this.bform.orden_compra_enc_id = this.ordenCompra.id
			this.bform2.orden_compra_enc_id = this.ordenCompra.id
			this.buscar()
		},
		mounted() {
			this.modal = new this.$modal(document.getElementById('mdlProducto'));
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
						res.data.lista.forEach(element => {
							if(element.no_linea>this.no_linea_last){
								this.no_linea_last = element.no_linea;
							}
						});
					}
					
				}).catch(e => {
					this.inicio = false
					console.log(e)
				})
			},
			actualizar_no_linea() {
				this.inicio = true

				this.$http
				.get(`${this.$baseUrl}/${this.controlador}/buscar`, {params: this.bform2})
				.then(res => {
					
					if (res.data.lista.length>0) {
						this.form2.detalle = res.data.lista

						this.form2.detalle.forEach(element => {
							this.$http
							.get(`${this.$baseUrl}/${this.controlador}/actualizar_linea/${element.id}`)
							.then(res => {
								console.log(res)
							}).catch(e => {
								this.inicio = false
								console.log(e)
							})
						})

					}
					
					this.buscar()

				}).catch(e => {
					this.inicio = false
					console.log(e)
				})
			},
			abrirModal() {
				this.verForm = true
				this.modal.show()

				let item = document.querySelector('#myTab li:first-child button')
				let tab = new Tab(item);
				tab.show();
			},
			cerrarProductos() {
				this.vp = false
				this.modal.hide()
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
				this.no_linea_last = parseInt(this.no_linea_last) + 1;
				
				this.producto = {
					no_linea: this.no_linea_last,
					id_producto: obj.id_producto,
					id_producto_j: obj.id_producto,
					codigo_producto: obj.codigo,
					codigo_producto_j: obj.codigo,
					nombre_producto: obj.nombre,
					nombre_producto_j: obj.nombre,
					nombre_presentacion: obj.nombre_presentacion,
					nombre_unidad_medida: obj.nombre_unidad_medida,
					nombre_producto_estado: obj.nombre_producto_estado,
					cantidad_recibida: 0,
					cantidad: obj.cantidad,
					presentacion_producto_id: obj.presentacion_producto_id,
					unidad_medida_id: obj.unidad_medida_id,
					estado_producto_id: obj.estado_producto_id,
					lote: obj.lote,
					fecha_vence: obj.fecha_vence,
					peso: obj.peso,
					peso_recibido: 0,
					peso_minimo: obj.peso_minimo,
					peso_maximo: obj.peso_maximo,
					costo: obj.costo,
					costo_oc: obj.costo_oc,
					producto_bodega_id: obj.producto_bodega,
					control_vence: obj.control_vence,
					orden_compra_enc_id: this.ordenCompra.id,
					pendiente: true,
					motivo_devolucion_id: obj.motivo_devolucion_id,
					total_linea: obj.costo * obj.cantidad,
					activo: 1
				}

				this.form.detalle.push(this.producto)	
				
				this.codigo = null
				this.cantidad = 1
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

					this.form.detalle.forEach(element => {
						if(element.no_linea>tmp.no_linea){
							element.no_linea = parseInt(element.no_linea) - 1
						}
					});

					this.no_linea_last = parseInt(this.no_linea_last) - 1;

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
							this.bform2.no_linea = obj.no_linea;
							this.actualizar_no_linea()
							this.$toast.success(res.data.mensaje)
						} else {
							this.$toast.error(res.data.mensaje)
						}

					}).catch(e => {
						this.btnGuardar = false
						console.log(e)
					})		
			},
			actualizaListaDet(o, pk) {
				this.tmpReg = {
					linea: o,
					pk: pk,
					idx: this.idx
				}

				this.setRegLista(this.tmpReg)
			},
			verProductos() {
				this.vp = true
				this.modal.show()
			},
			onChangeQuantity(event, idx){
				const newQuantity = event.target.value;

				this.form.detalle[idx].total_linea = parseFloat(this.form.detalle[idx].costo) * parseFloat(newQuantity);
			},
			guardar(obj) {	
				this.btnGuardar = true

				let datos = obj
				if (datos.hasOwnProperty('id')) {
					this.pk_det = datos.id
				}

				if (datos.presentacion_producto_id) {
					datos.nombre_presentacion    = this.cat.presentacion.filter(e => { return e.id == datos.presentacion_producto_id})[0].nombre 
				}else {
					datos.nombre_presentacion    = null;
				}
				
				if(datos.unidad_medida_id){
					datos.nombre_unidad_medida   = this.cat.um.filter(e => { return e.id == datos.unidad_medida_id})[0].nombre
				}else {
					this.$toast.error("Seleccione una unidad de medida")
					this.btnGuardar = false
					return
				}

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
			},	
        },
		computed: {
			productos() {
				if (this.cat.productos_bodega) {
					return this.cat.productos_bodega.filter(e => {
						return e.bodega_id === this.ordenCompra.bodega_id
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
			ProductoBodega,
			OrdenCompraAgregarDetalle
		}
	}
</script>

<style>
	td {
		vertical-align:middle !important;
	}
</style>