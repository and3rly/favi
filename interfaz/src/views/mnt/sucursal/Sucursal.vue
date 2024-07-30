<template>
	<div class="d-flex align-items-center mb-4">
		<h1 class="page-header mb-0">
			<i class="fas fa-sitemap fa-sm me-1 ms-1"></i>Sucursales
		</h1>

		<div class="ms-auto">
			<a href="#" class="btn btn-theme" @click="abrirModal">
				<i class="fa fa-plus-circle fa-fw me-2"></i> Nuevo
			</a>
		</div>
	</div>
	
	<SucursalLista
		@editar="editarReg"
		:filtrada="lista"
	/>

	<div 
		class="modal fade" id="modalSucursal"
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
						Sucursal
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
					<SucursalForm
						v-if="verForm"
						:sucursal="reg"
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
	import SucursalLista from '@/views/mnt/sucursal/SucursalLista.vue'
	import SucursalForm from '@/views/mnt/sucursal/SucursalForm.vue'

	export default {
		name: 'Sucursal',
		mixins: [General],
		data:() => ({
			modal: null,
			idx: null,
			verForm: false,
			reg: null,
		}),
		mounted() {
			this.modal = new this.$modal(document.getElementById('modalSucursal'));
		},
		created() {
			this.controlador = 'mnt/sucursal'
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
			SucursalLista,
			SucursalForm
		}
	}
</script>