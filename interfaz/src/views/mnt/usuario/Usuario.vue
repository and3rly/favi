<template>
	<div class="d-flex align-items-center mb-4">
		<h1 class="page-header mb-0">
			<i class="fas fa-user fa-sm me-1 ms-1"></i>Usuarios
		</h1>
		<div class="ms-auto">
			<a href="#" class="btn btn-theme" @click="abrirModal">
				<i class="fa fa-plus-circle fa-fw me-1"></i> Nuevo Usuario
			</a>
		</div>
	</div>

	<UsuarioLista/>

	<div 
		class="modal fade" id="modalNuevoUsuario"
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
						Nuevo usuario
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
					<UsuarioForm v-if="verForm" @cerrar="cerrarModal"/>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import UsuarioLista from '@/views/mnt/usuario/UsuarioLista.vue'
	import UsuarioForm from '@/views/mnt/usuario/UsuarioForm.vue'
	import { Modal } from 'bootstrap'

	export default {
		name: 'Usuario',
		data:() => ({
			modal: null,
			verForm: false
		}),
		mounted() {
			this.modal = new Modal(document.getElementById('modalNuevoUsuario'));
		},
		methods: {
			abrirModal() {
				this.verForm = true
				this.modal.show()
			},
			cerrarModal() {
				this.verForm = false
				this.modal.hide()
			}
		},
		components: {
			UsuarioLista,
			UsuarioForm
		}
	}
</script>