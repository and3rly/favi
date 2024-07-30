<template>

	<OrdenCompraLista
		@editar="editarReg"
		:cargando="cargando"
		:filtrada="lista"
		@abrirModal="abrirModal"
	/>

	<div 
		class="modal fade" 
		id="mdlOrdenCompra"
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
						<i class="fas fa-cubes-stacked  fa-sm me-2 ms-1"></i>Orden de Compra 
						<span v-if="reg != null"> - {{reg.no_documento}}</span>
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

					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item" role="presentation">
							<button 
								class="nav-link active" 
								id="home-tab" 
								data-bs-toggle="tab" 
								data-bs-target="#home-tab-pane" 
								type="button"
								role="tab" 
								aria-controls="home-tab-pane" 
								aria-selected="true"
							>
								<i class="fas fa-list-ul me-1"></i> Datos Generales
							</button>
						</li>
					</ul>

					<div class="tab-content" id="myTabContent">
						<div 
							class="tab-pane fade show active" 
							id="home-tab-pane" 
							role="tabpanel" 
							aria-labelledby="home-tab" 
							tabindex="0"
						>
                            <OrdenCompraForm
								class="mt-3"
                                v-if="verForm"
                                :ordenCompra="reg"
                                @actualizar="actualizaLista"
                                @cerrar="cerrarModal"
                            />
						</div>
					</div>

					
				</div>
			</div>
		</div>
	</div>
	
</template>

<script>
	import General from '@/mixins/General.js'
	import OrdenCompraLista from '@/views/orden/OrdenCompraLista.vue'
	import OrdenCompraForm from '@/views/orden/OrdenCompraForm.vue'
	import OrdenCompraDetalle from '@/views/orden/OrdenCompraDetalle.vue'
	import { Tab } from 'bootstrap'

	export default {
		name: "OrdenCompra",
		mixins: [General], 
		data:() => ({
			reg: null,
			modal: null,
			idx: null,
			verForm: false,
			actual: 1
		}),	
		mounted() {
			this.modal = new this.$modal(document.getElementById('mdlOrdenCompra'));
		},
		created() {
			this.controlador = 'orden/OrdenCompra'
			this.autoBuscar = true
		},
		methods: {
			abrirModal() {
				this.verForm = true
				this.modal.show()

				let item = document.querySelector('#myTab li:first-child button')
				let tab = new Tab(item);
				tab.show();
			},
			cerrarModal() {
				this.verForm = false
				this.reg = null
				this.idx = null
				this.modal.hide()
			},
			editarReg(o, idx) {
				this.reg = null
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
			OrdenCompraLista,
			OrdenCompraForm,
            OrdenCompraDetalle
		}
	}
</script>