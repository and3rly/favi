<template>
	<div class="d-flex align-items-center mb-4">
		<h1 class="page-header mb-0">
			<i class="fas fa-road fa-sm me-2 ms-1"></i>Tipo de Transacción
		</h1>

		<div class="ms-auto">
			<a href="#" class="btn btn-theme" @click="abrirModal">
				<i class="fa fa-plus-circle fa-fw me-2"></i> Nuevo
			</a>
		</div>
	</div>

	<Tipo_transaccionLista
		@editar="editarReg"
		:cargando="cargando"
		:filtrada="lista"
	/>

	<div 
		class="modal fade" 
		id="mdltransaccion"
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
						<i class="fas fa-road  fa-sm me-2 ms-1"></i>Transacción 
					
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
					<Tipo_transaccionForm
						v-if="verForm"
						:transaccion="reg"
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
 import Tipo_transaccionLista from '@/views/mnt/tipo_transaccion/Tipo_transaccionLista.vue'
 import Tipo_transaccionForm from '@/views/mnt/tipo_transaccion/Tipo_transaccionForm.vue'
	export default {
		name: "Transaccion",
		mixins: [General], 
		data:() => ({
			reg: null,
			modal: null,
			idx: null,
			verForm: false
		}),	
		mounted() {
			this.modal = new this.$modal(document.getElementById('mdltransaccion'));
		},
		created() {
			this.controlador = 'mnt/Tipo_transaccion'
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
			Tipo_transaccionLista,
			Tipo_transaccionForm
		}
	}
</script>