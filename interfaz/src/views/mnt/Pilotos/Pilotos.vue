<template>
	<div class="d-flex align-items-center mb-4">
		<h1 class="page-header mb-0">
			<i class="fas fa-user-tie fa-sm me-2 ms-1"></i> Pilotos
		</h1>

		<div class="ms-auto">
			<a href="#" class="btn btn-theme" @click="abrirModal">
				<i class="fa fa-plus-circle fa-fw me-2"></i> Nuevo
			</a>
		</div>
	</div>

	<PilotosLista 
		@abrirModal="editar" 
		:tmpLinea="tmpReg" 
	/>

	<div 
		class="modal fade" 
		id="mdlPilotos" 
		data-bs-backdrop="static" 
		data-bs-keyboard="false" 
		tabindex="-1"
		aria-labelledby="staticBackdropLabel" 
		aria-hidden="true"
	>
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="staticBackdropLabel">
						<i class="fas fa-user-tie me-1"></i> Piloto
					</h1>
					<button type="button" class="btn-close" aria-label="Close" @click="cerrarModal">
					</button>
				</div>
				<div class="modal-body">
					<PilotosForm
						v-if="verForm" 
						@cerrar="cerrarModal" 
						@actualizar="actualizar"
						:pilotos="reg" 
						/>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import PilotosLista from '@/views/mnt/Pilotos/PilotosLista.vue'
import PilotosForm from '@/views/mnt/Pilotos/PilotosForm.vue'
import Catalogo from '@/mixins/Catalogo.js'
import { Modal } from 'bootstrap'
import { Tab } from 'bootstrap'

export default {
	name: 'pilotos',
	mixins: [Catalogo],
	data: () => ({
		modal: null,
		usuario: null,
		reg: null,
		idx: null,
		verForm: false,
		actual: 1
	}),
	mounted() {
		this.modal = new Modal(document.getElementById('mdlPilotos'));
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
		actualizar(o, pk) {
			this.tmpReg = {
				linea: o,
				pk: pk,
				idx: this.idx
			}
		}
	},
	components: {
		PilotosLista,
		PilotosForm
	}
}
</script>