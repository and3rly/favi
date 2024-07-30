<template>
	<div class="d-flex align-items-center mb-4">
		<h1 class="page-header mb-0">
			<i class="fas fa-car-side fa-sm me-2 ms-1"></i> Vehiculo
		</h1>

		<div class="ms-auto">
			<a href="#" class="btn btn-theme" @click="abrirModal">
				<i class="fa fa-plus-circle fa-fw me-2"></i> Nuevo
			</a>
		</div>
	</div>

	<VehiculosLista 
		@abrirModal="editar" 
		:tmpLinea="tmpReg" 
	/>

	<div 
		class="modal fade" 
		id="mdlVehiculo" 
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
						<i class="fas fa-car-side me-1"></i>Vehiculo 
					</h1>
					<button type="button" class="btn-close" aria-label="Close" @click="cerrarModal">
					</button>
				</div>
				<div class="modal-body">
					<VehiculosForm
						v-if="verForm" 
						@cerrar="cerrarModal" 
						@actualizar="actualizar"
						:vehiculos="reg" 
						/>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import VehiculosLista from '@/views/mnt/Vehiculos/VehiculosLista.vue'
import VehiculosForm from '@/views/mnt/Vehiculos/VehiculosForm.vue'
import Catalogo from '@/mixins/Catalogo.js'
import { Modal } from 'bootstrap'
import { Tab } from 'bootstrap'

export default {
	name: 'vehiculos',
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
		this.modal = new Modal(document.getElementById('mdlVehiculo'));
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
		VehiculosLista,
		VehiculosForm
	}
}
</script>