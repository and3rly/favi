<template>
	<div class="row mt-3 mb-3">
        <div class="alert alert-info p-2 mb-1 fw-bold m-0 rounded d-flex align-items-center mb-4">
            <i class="fas fa-plus me-2"></i>Detalles de Orden
            
            <div class="ms-auto">
                <a href="#" class="btn btn-theme" @click="abrirModal">
                    <i class="fa fa-plus-circle fa-fw me-2"></i> Nuevo
                </a>
            </div>
        </div>
        <div class="card">
            <div class="card-body p-4">
                <div class="table-responsive" style="max-height: calc(100vh - 120px - 100px - 20px);">
                    <table class="table table-sm table-hover mb-0">
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
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="cat.orden_compra_det && cat.orden_compra_det.length > 0" v-for="(i,idx) in cat.orden_compra_det">
                                <td class="text-center fw-bold">{{idx + 1}}</td>
                                <td class="text-center">
									<a 
										href="javascript:;"
										@click="editarRegDet(i, idx)" 
									>
										{{ i.no_linea }}
									</a>
								</td>
                                <td class="text-center">{{ i.codigo_producto_j }}</td>
                                <td>{{ i.nombre_producto_j }}</td>
                                <td class="text-center">{{ i.codigo_presentacion_j }} - {{ i.nombre_presentacion_j }}</td>
                                <td class="text-center">{{ i.nombre_unidad_medida_j }}</td>
                                <td class="text-center">{{ i.cantidad }} / {{ i.cantidad_recibida }}</td>
                                <td class="text-center">{{ i.peso }} / {{ i.peso_recibido }}</td>
                                <td class="text-center">{{ i.nombre_motivo_dev }}</td>
                                <td class="text-center">{{ i.total_linea }}</td>
                                <td class="text-center">
                                    <i v-if="i.activo == 1" class="fa fa-check text-success"></i>
                                    <i v-else class="fa fa-times text-danger" ></i>
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
	</div>

    <div 
		class="modal fade" 
		id="mdlOrdenCompraDet"
		data-bs-backdrop="static" 
		data-bs-keyboard="false"
		aria-labelledby="staticBackdropLabel" 
		aria-hidden="true">

		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h1 
						class="modal-title fs-5" 
						id="staticBackdropLabel"
					> 
						<i class="fas fa-cubes-stacked  fa-sm me-2 ms-1"></i>Detalle de Orden
						<span v-if="reg != null"> - {{reg.id}}</span>
					</h1>
					<button 
						type="button" 
						class="btn-close" 
						aria-label="Close"
						@click="cerrarModal" 
					>
					</button>
				</div>
				<div class="modal-body">

                    <OrdenCompraAgregarDetalle
                        class="mt-3"
                        v-if="verForm"
                        :ordenCompra="ordenCompra"
                        :ordenCompraDet="reg"
                        @actualizar="actualizaLista"
                        @cerrar="cerrarModal"
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

	export default {
		name: 'OrdenCompraDetalle',
		mixins: [General,Catalogo],
		props: {
			filtrada: {
				type: Array,
				required: false
			},
			cargando: {
				type: Boolean, 
				required: false
			},
			ordenCompra: {
				type: Object,
				required: false
			}
		},
		data: () => ({
            reg: null,
			modal: null,
			verForm: false
        }),
		created() {
			this.args.orden_compra_det = { orden_compra_enc_id: this.ordenCompra.id }
			this.getCatalogo(['orden_compra_det'])
		},
		mounted() {
			this.modal = new this.$modal(document.getElementById('mdlOrdenCompraDet'));
		},
		methods: {
			abrirModal() {
				this.verForm = true
				this.modal.show()
			},
			cerrarModal() {
				this.verForm = false
				this.reg = null
				this.idx = null
				this.modal.hide()
			},
			editarRegDet(o, idx) {
				this.idx = idx
				this.reg = o
				this.abrirModal()
			},
			actualizaLista(o, pk) {
				this.tmpReg = {
					linea: o,
					pk: pk,
					idx: this.idx
				}

				this.setRegLista(this.tmpReg)
			}
        },
		components: {
			OrdenCompraAgregarDetalle
		}
	}
</script>

<style>
	td {
		vertical-align:middle !important;
	}
</style>