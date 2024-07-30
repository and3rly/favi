<template>
	<div class="d-flex align-items-center mb-4">
		<h1 class="page-header mb-0">
			<i class="fas fa-person-walking-luggage fa-sm me-2 ms-1"></i>Cliente
		</h1>

		<div class="ms-auto">
			<a href="#" class="btn btn-theme" @click="abrirModal">
				<i class="fa fa-plus-circle fa-fw me-2"></i> Nuevo
			</a>
		</div>
	</div>

	<ClienteLista
	@abrirModal="editar"
		:tmpLinea="tmpReg"
	/>

	<div 
		class="modal fade" id="mdlCliente"
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
					<i class="fas fa-person-walking-luggage fa-sm me-1"></i>Cliente <span v-if="reg != null"> - {{reg.nombre_comercial}}</span>
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
					<ClienteForm 
						v-if="verForm" 
						@cerrar="cerrarModal" 
						@actualizar="actualizaLista"
						:cliente="reg" 
					/>					
				</div>
			</div>
		</div>
	</div>
	
</template>

<script>
	import General from '@/mixins/General.js'
	import ClienteLista from '@/views/mnt/Cliente/ClienteLista.vue'
	import ClienteForm from '@/views/mnt/Cliente/ClienteForm.vue'
	import ContactoForm from '@/views/mnt/Cliente/ContactoForm.vue'
	import ClienteBodega	from '@/views/mnt/Cliente/ClienteBodega.vue' 
	import ClienteSucursal	from '@/views/mnt/Cliente/ClienteSucursal.vue' 
	import Catalogo from '@/mixins/Catalogo.js'
	import { Modal } from 'bootstrap'
	import { Tab } from 'bootstrap'

	export default {
		name: 'Cliente',
		mixins: [Catalogo,General],
		data:() => ({
			modal: null,
			usuario: null,
			reg: null,
			idx: null,
			verForm: false,
			actual: 1
		}),	
		mounted() {
			this.modal = new Modal(document.getElementById('mdlCliente'));
		},
		created() {
			this.controlador = 'mnt/cliente'
			this.autoBuscar = true
		},
		methods: {
			editar(o, idx) {
				this.reg = o
				this.idx = idx
				this.abrirModal()
			},
			abrirModal() {
				this.verForm = true
				this.modal.show()
  			},
			cerrarModal() {
				this.reg = null
				this.verForm = false
				this.usuario = null
				this.modal.hide()
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
			ClienteLista,
			ClienteForm,
			ClienteBodega,
			ContactoForm,
		ClienteSucursal}
	}
</script>