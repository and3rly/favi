<template>
	<div class="d-flex align-items-center mb-4">
		<h1 class="page-header mb-0">
			<i class="fas fa-users fa-sm me-1 ms-1"></i>Proveedor
		</h1>
		<div class="ms-auto">
			<a href="#" class="btn btn-theme" @click="abrirModal">
				<i class="fa fa-plus-circle fa-fw me-1"></i> Nuevo
			</a>
		</div>
	</div>

	<ProveedorLista 		
	@abrirModal="editarReg"
		:tmpLinea="tmpReg"  />

	<div class="modal fade" id="mdlProveedor" 
	data-bs-backdrop="static"
	 data-bs-keyboard="false"
	  tabindex="-1"
		aria-labelledby="staticBackdropLabel" 
		aria-hidden="true">

		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" 
					id="staticBackdropLabel">
						Proveedor<span v-if="reg != null">- {{reg.nombre}}</span>
					</h1>
					<button type="button" 
					class="btn-close" 
					aria-label="Close" 
					@click="cerrarModal">
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
								aria-selected="true">
								<i class="fas fa-list-ul me-1"></i> Datos Generales
							</button>
						</li>
						<template v-if="reg !=null">
						<li class="nav-item" role="presentation">
								<button @click="actual = 2" 
								class="nav-link"
								 id="profile-tab"
								  data-bs-toggle="tab"
									data-bs-target="#profile"
									 type="button"
									  role="tab" 
									  aria-controls="profile-tab-pane"
									aria-selected="false">
									<i class="fas fa-store me-1"></i> Bodega
								</button>
							</li>
						</template>
					</ul>

					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active"
						 id="home-tab-pane"
						 role="tabpanel" 
						 aria-labelledby="home-tab"
							tabindex="0">
							<ProveedorForm 
							class="mt-3"
							 v-if="verForm" 
							 @cerrar="cerrarModal"
							 @actualizar="actualizarLista"
							 :proveedor="reg"
							 />

						</div>
						<template v-if="reg !=null">
							<div class="tab-pane fade"
							 id="profile" 
							 role="tabpanel" 
							 aria-labelledby="profile-tab"
								tabindex="0">
								<ProveedorBodega 
								v-if="actual == 2" 
								:bodega="cat.bodega"
								 :proveedor="reg" />
							</div>	
						</template>						
					</div>

				</div>
			</div>
		</div>
	</div>
</template>

<script>
import ProveedorLista from '@/views/mnt/proveedor/ProveedorLista.vue'
import ProveedorForm from '@/views/mnt/proveedor/ProveedorForm.vue'
import ProveedorBodega from '@/views/mnt/proveedor/ProveedorBodega.vue'
import General from '@/mixins/General.js'
import Catalogo from '@/mixins/Catalogo.js'
import { Modal } from 'bootstrap'
import { Tab } from 'bootstrap'

export default {
	name: 'Proveedor',
	mixins: [Catalogo],
	data: () => ({
		modal: null,
		proveedor : null,
		reg: null,
		idx: null,
		verForm: false,
		actual: 1
	}),
	mounted() {
		this.modal = new Modal(document.getElementById('mdlProveedor'));
		
	},
	created() {
		this.getCatalogo(['empresa'])
	},

	methods: {
		editarReg(o, idx) {
			this.reg = null
			this.idx = idx
			this.reg = o
			this.abrirModal()
		},
		abrirModal() {
			this.verForm = true
			this.modal.show()

			let item = document.querySelector('#myTab li:first-child button')
			let tab = new Tab(item);
			tab.show();
		},
		cerrarModal() {
			this.reg = null
			this.idx = null
			this.verForm = false
			this.proveedor = null
			this.modal.hide()
		},
		actualizarLista(o, pk) {
			this.tmpReg = {
				linea: o,
				pk: pk,
				idx: this.idx
			}
		}
	},
	components: {
		ProveedorLista,
		ProveedorForm,
		ProveedorBodega
	}
}
</script>