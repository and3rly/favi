<template>
	<div class="d-flex align-items-center mb-4">
		<h1 class="page-header mb-0">
			<i class="fas fa-building fa-sm me-2 ms-1"></i>Motivo de Anulación Pedido
		</h1>

		<div class="ms-auto">
			<a href="#" class="btn btn-theme" @click="abrirModal">
				<i class="fa fa-plus-circle fa-fw me-2"></i> Nuevo
			</a>
		</div>
	</div>

	<Motivo_anulacion_pedidoLista
		@editar="editarReg"
		:cargando="cargando"
		:filtrada="lista"
	/>

	<div 
		class="modal fade" 
		id="Motivo_anulacion_pedidoForm"
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
						<i class="fas fa-building  fa-sm me-2 ms-1"></i>Motivo de Anulación de pedido 
						<span v-if="reg != null"> - {{reg.nombre}}</span>
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
					<Motivo_anulacion_pedidoForm
						v-if="verForm"
						:Motivo_anulacion_pedido="reg"
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
    import Motivo_anulacion_pedidoLista from '@/views/mnt/motivo_anulacion_pedido/Motivo_anulacion_pedidoLista.vue'
	import Motivo_anulacion_pedidoForm from '@/views/mnt/motivo_anulacion_pedido/Motivo_anulacion_pedidoForm.vue'


	export default {
		name: "Motivo_anulacion_pedido",
		mixins: [General], 
		data:() => ({
			reg: null,
			modal: null,
			idx: null,
			verForm: false
		}),	
		mounted() {
			this.modal = new this.$modal(document.getElementById('Motivo_anulacion_pedidoForm'));
		},
		created() {
			this.controlador = 'mnt/motivo_anulacion_pedido'
			this.autoBuscar = true
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
			Motivo_anulacion_pedidoLista,
			Motivo_anulacion_pedidoForm
		}
	}
</script>