<template>
	<div class="d-flex align-items-center mb-4">
		<h1 class="page-header mb-0">
			<i class="fas fa-user fa-sm me-1 ms-1"></i>Menus
		</h1>
		<div class="ms-auto">
			<a href="#" class="btn btn-theme" @click="abrirModal">
				<i class="fa fa-plus-circle fa-fw me-1"></i> Nuevo Menú
			</a>
		</div>
	</div>

	<MenuLista 
		@abrirModal="editar"
		:tmpLinea="tmpReg"
	/>

	<div 
		class="modal fade" id="modalNuevoMenu"
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
						Menú<span v-if="reg != null">: {{reg.nombre}}</span>
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
					<MenuForm
						v-if="verForm"
						:menu="reg"
						@actualizar="actualizar"
						@cerrar="cerrarModal"
					/>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import MenuLista from '@/views/mnt/menu/MenuLista.vue'
	import MenuForm from '@/views/mnt/menu/MenuForm.vue'
	import Catalogo from '@/mixins/Catalogo.js'
	import { Modal } from 'bootstrap'
	import { Tab } from 'bootstrap'

	export default {
		name: 'Menu',
		mixins: [Catalogo],
		data:() => ({
			modal: null,
			usuario: null,
			reg: null,
			idx: null,
			verForm: false,
			actual: 1
		}),
		mounted() {
			this.modal = new Modal(document.getElementById('modalNuevoMenu'));
		},
		created() {
			this.getCatalogo(['menu'])
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
				this.verForm = false
				this.usuario = null
				this.reg = null
				this.modal.hide()
			},
			actualizar(o, pk) {
				this.tmpReg = {
					linea: o,
					pk: pk,
					idx: this.idx
				}
			}
		},
		components: {
            MenuLista,
            MenuForm
		}
	}
</script>