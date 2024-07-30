<template>
	<div class="d-flex align-items-center mb-4">
		<h1 class="page-header mb-0">
			<i class="fas fa-balance-scale fa-sm me-2 ms-1"></i>Unidad medida
		</h1>

		<div class="ms-auto">
			<a href="#" class="btn btn-theme" @click="abrirModal">
				<i class="fa fa-plus-circle fa-fw me-2"></i> Nuevo
			</a>
		</div>
	</div>

	<UmLista
		@editar="editarReg"
		:tmpLinea="tmpReg"
	/>

	<div 
		class="modal fade" id="modalUm"
		data-bs-backdrop="static" 
		data-bs-keyboard="false" 
		tabindex="-1" 
		aria-labelledby="staticBackdropLabel" 
		aria-hidden="true">

		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h1 
						class="modal-title fs-5" 
						id="staticBackdropLabel"
					> 
						<i class="fas fa-balance-scale fa-sm me-2 ms-1"></i>Unidad de Medida <span v-if="reg != null"> - {{reg.nombre}}</span>
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
					<UmForm
						v-if="verForm"
						:um="reg"
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
	import UmLista from '@/views/producto/um/UmLista.vue'
	import UmForm from '@/views/producto/um/UmForm.vue'

	export default {
		name: 'UM',
		mixins: [General],
		data:() => ({
			reg: null,
			modal: null,
			idx: null,
			verForm: false
		}),
		mounted() {
			this.modal = new this.$modal(document.getElementById('modalUm'));
		},
		created()  {
			this.controlador = 'producto/unidad_medida'
			this.autoBuscar = false
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
			}
		},
		components: {
			UmLista,
			UmForm
		}
	}
</script>