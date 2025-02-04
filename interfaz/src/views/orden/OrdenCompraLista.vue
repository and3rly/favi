<template>
	<template v-if="actual == 1">
		<div class="d-flex py-2">
			<div class="flex-fill me-1">
				<h1 class="page-header mb-1">
					<i class="fas fa-list-alt me-1"></i>Ordenes de compra
				</h1>
			</div>
			<div class="flex-fill text-end">
				<button 
					class="btn btn-theme"
					@click="$emit('abrirModal')" 
				>
					<i class="fas fa-circle-plus me-2"></i>Nuevo
				</button>	
			</div>
		</div>

		<Card class="mt-1">
			<CardHeader class="p-2 bg-white">			
				<div class="d-flex">
					<div class="flex-fill me-1">
						<input 
							type="search" 
							class="form-control" 
							placeholder="Buscar por criterio..."
							v-model="bformF.criterio"
						/>
					</div>
					<div class="flex-fill me-1">
						<input 
							type="date" 
							class="form-control"
							v-model="bformF.fdel"
						/>
					</div>
					<div class="flex-fill me-1">
						<input 
							type="date" 
							class="form-control"
							v-model="bformF.fal"
						/>
					</div>
					<div class="flex-fill me-1">
						<select 
							name="selectBodega" 
							id="selectBodega"
							class="form-select" 
							v-model="bformF.bodega_id"
						>
							<option :value="null">Seleccione una bodega...</option>
							<option v-for="i in cat.bodega" :value="i.id"> {{ i.nombre }} </option>
						</select>
					</div>
					<button
						class="btn btn-primary"
						@click="buscarFiltrado()"
					>
						<i class="fas fa-search"></i>
					</button>
				</div>
			</CardHeader>
			<CardBody class="p-0">
				<div class="card">
					<div class="card-body p-4">
						<div class="table-responsive mt-3">
							<table class="table table-sm table-hover table-striped">
								<thead>
									<tr>
										<th class="text-center" width="40">#</th>
										<th class="text-center">No. Documento</th>
										<th class="text-center">Procedencia</th>
										<th class="text-center">Fecha Creación</th>
										<th class="text-center">Referencia</th>
										<th class="text-center">Observación</th>
										<th class="text-center">Proveedor</th>
										<th class="text-center">Bodega</th>
										<th class="text-center">Status</th>
										<th class="text-center">Tipo</th>
										<th class="text-center">Motivo Devolución</th>
										<th class="text-center">Activo</th>
										<th width="100"></th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(i, idx) in filtArr">
										<td class="text-center fw-bold">{{idx + 1}}</td>
										<td class="text-center"> {{i.no_documento}} </td>
										<td>{{ i.procedencia }}</td>
										<td> {{i.fecha_creacion}} </td>
										<td>{{ i.referencia }}</td>
										<td>{{ i.observacion }}</td>
										<td>{{ i.nombre_proveedor }}</td>
										<td>{{ i.nombre_bodega }}</td>
										<td>{{ i.nombre_estado_oc }}</td>
										<td>{{ i.nombre_tipo_oc }}</td>
										<td>{{ i.nombre_motivo_dev || "Sin motivo de devolución" }}</td>
										<td class="text-center">
											<i v-if="i.activo == 1" class="fa fa-check text-success"></i>
											<i v-else class="fa fa-times text-danger" ></i>
										</td>
										<td class="text-center">
											<button
												class="btn btn-sm btn-secondary me-1"
												@click="buscarDet(i, idx)" 
												title="Imprimir"
											>
												<i class="fa-solid fa-print"></i>
											</button>
											<button
												class="btn btn-sm btn-secondary me-1"
												@click="$emit('editar', i, idx)" 
												title="Editar"
											>
												<i class="fas fa-edit"></i>
											</button>
											<button
												class="btn btn-sm btn-warning"
												@click="verDetalle(i)"
												title="Ver detalle"
											>
												<i class="fas fa-list-alt"></i>
											</button>
										</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<td v-if="cargando" colspan="100" class="text-center">
											<div class="d-flex justify-content-center mb-3 mt-3">
												<div class="spinner-border" role="status">
													<span class="visually-hidden">Loading...</span>
												</div>

											</div>
											Cargando información...
										</td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</CardBody>
		</Card>
	</template>

	<OrdenCompraDetalle
		v-if="actual == 2"
		:ordenCompra="reg"
		@regresar="actual = 1"
	/>

</template>

<script>
	import General from '@/mixins/General.js'
	import Catalogo from '@/mixins/Catalogo.js'
	import OrdenCompraDetalle from '@/views/orden/OrdenCompraDetalle.vue'
	import OrdenCompraForm from '@/views/orden/OrdenCompraForm.vue'
	import jsPDFInvoiceTemplate, { OutputType, jsPDF } from "@/views/orden/pdfTemplate.js";
	import { useLoginStore } from "@/stores/app-login";
	import Utileria from "@/mixins/Utileria.js"

	export default {
		name: 'OrdenCompraLista',
		mixins: [General, Catalogo, Utileria],
		props: {
			filtrada: {
				type: Array,
				required: false
			},
			cargando: {
				type: Boolean, 
				required: false
			}
		},
		data: () => ({
			filtArr: [],
			reg: {},
			actual: 1,
			bform: {},
			formDet: {
				detalle: []
			},
			bformF: {
				bodega_id: null
			},
		}),
		created() {
			this.filtArr = this.filtrada;
			
			this.args.empresa_usuario_sucursal = { usuario_id: useLoginStore().usuario.id }
			this.args.orden_compra_det = { orden_compra_enc_id: 2 }
			this.getCatalogo([
                "empresa_usuario_sucursal",
				"orden_compra_det",
				"bodega"
			])

			this.bformF.fdel = this.setFechaInicio()
      		this.bformF.fal = this.setFechaActual()
		},
		watch: {
			filtrada(newVal) {
			// Actualizar la propiedad de data cuando el prop cambie
				this.filtArr = newVal;
			}
		},
		methods: {
			buscarDet(i, idx) {
				this.inicio = true
				this.bform.orden_compra_enc_id = i.id

				this.$http
				.get(`${this.$baseUrl}/orden/detalle/OrdenCompraDetalle/buscar`, {params: this.bform})
				.then(res => {
					this.inicio = false
					if (res.data.lista) {
						this.formDet.detalle = res.data.lista
						this.generatePDF(i, idx);
					}
				}).catch(e => {
					this.inicio = false
					console.log(e)
				})
			},
			verDetalle(obj) {
				this.reg = obj
				this.actual = 2
			},
			buscarFiltrado() {
				this.inicio = true

				this.$http
				.get(`${this.$baseUrl}/orden/OrdenCompra/buscar`, {params: this.bformF})
				.then(res => {
					
					this.inicio = false

					if (res.data.lista) {
						this.filtArr = res.data.lista
					}
				}).catch(e => {
					this.inicio = false
					console.log(e)
				})
			},
			generatePDF(i, idx) {

				var total_oc = 0.00

				this.formDet.detalle.forEach(function(item, index) {
					total_oc += parseFloat(item.total_linea)
				});

				var props = {
					outputType: OutputType.Save,
					returnJsPDFDocObject: true,
					fileName: "Orden de Compra "+i.no_documento,
					orientationLandscape: false,
					compress: true,
					logo: {
						src: "/src/assets/images/logo.png",
						type: 'PNG', //optional, when src= data:uri (nodejs case)
						width: 53.33, //aspect ratio = width/height
						height: 26.66,
						margin: {
							top: 0, //negative or positive num, from the current position
							left: 0 //negative or positive num, from the current position
						}
					},
					business: {
						name: this.cat.empresa_usuario_sucursal[0].nombre,
						address: this.cat.empresa_usuario_sucursal[0].direccion,
						phone: this.cat.empresa_usuario_sucursal[0].telefono,
						email: this.cat.empresa_usuario_sucursal[0].correo,
						email_1: this.cat.empresa_usuario_sucursal[0].razon_social,
						website: this.cat.empresa_usuario_sucursal[0].nit,
					},
					contact: {
						label: "Bodega: "+i.nombre_bodega,
						name: "Proveedor: "+i.nombre_proveedor,
						address: "Estado de Orden de Compra: "+i.nombre_tipo_oc,
						phone: "Motivo Devolución: "+i.nombre_motivo_dev
					},
					invoice: {
						label: "Orden de Compra #: ",
						num: i.no_documento,
						invDate: "Fecha Creación: "+i.fecha_creacion,
						invGenDate: "Tipo Orden de Compra: "+i.nombre_tipo_oc,
						headerBorder: false,
						tableBodyBorder: false,
						header: [
						{
							title: "#", 
							style: { 
								width: 5
							} 
						}, 
						{ 
							title: "Código",
							style: {
								width: 15
							} 
						}, 
						{ 
							title: "Nombre",
							style: {
								width: 30
							} 
						}, 
						{ 
							title: "Presentación/UM",
							style: {
								width: 30
							}
						},
						{ 
							title: "Cantidad",
							style: {
								width: 25
							}
						},
						{ 
							title: "Peso",
							style: {
								width: 25
							}
						},
						{
							title: "Motivo Devolución",
							style: {
								width: 45
							}
						},
						{ 
							title: "Total",
							style: {
								width: 15
							}
						}
						],
						table: Array.from(this.formDet.detalle, (item, index)=>([
							index + 1,
							item.codigo_producto_j,
							item.nombre_producto_j,
							item.nombre_presentacion_j + ' / ' + item.nombre_unidad_medida_j,
							item.cantidad + ' / ' + item.cantidad_recibida,
							item.peso + ' / ' + item.peso_recibido,
							item.nombre_motivo_dev,
							'Q.'+item.total_linea
						])),
						additionalRows: [{
							col1: 'Total:',
							col2: 'Q.'+total_oc.toString(),
							style: {
								fontSize: 12 //optional, default 12
							}
						}],
						invDescLabel: "Observación",
						invDesc: i.observacion,
					},
					pageEnable: true,
					pageLabel: "Página ",
				};

				jsPDFInvoiceTemplate(props);
			}
		},
		components: {
			OrdenCompraForm,
			OrdenCompraDetalle
		}
	}
	
</script>

<style>
	td {
		vertical-align:middle !important;
	}
</style>