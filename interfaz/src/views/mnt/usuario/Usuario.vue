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

	<UsuarioLista 
		@abrirModal="editar"
		:tmpLinea="tmpReg"
	/>

	<div 
		class="modal fade" id="modalNuevoUsuario"
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
						Usuario<span v-if="reg != null">: {{reg.nombre}} {{reg.apellido}}</span>
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
								aria-selected="true"
							>
								<i class="fas fa-list-ul me-1"></i> Datos Generales
							</button>
						</li>

						<template v-if="reg != null">
							<li class="nav-item" role="presentation">
								<button 
									@click="actual = 2"
									class="nav-link"
									id="profile-tab" 
									data-bs-toggle="tab" 
									data-bs-target="#profile" 
									type="button"
									role="tab" 
									aria-controls="profile-tab-pane" 
									aria-selected="false"
								>
									<i class="fas fa-male me-1"></i> Roles
								</button>
							</li>
							<li class="nav-item" role="presentation">
								<button 
									@click="actual = 3"
									class="nav-link" 
									id="contact-tab" 
									data-bs-toggle="tab" 
									data-bs-target="#contact-tab-pane" 
									type="button" 
									role="tab" 
									aria-controls="contact-tab-pane" 
									aria-selected="false"
								>
									<i class="fas fa-sitemap me-1"></i> Sucursales
								</button>
							</li>
						</template>
					</ul>

					<div class="tab-content" id="myTabContent">
						<div 
							class="tab-pane fade show active" 
							id="home-tab-pane" 
							role="tabpanel" 
							aria-labelledby="home-tab" 
							tabindex="0"
						>
							<UsuarioForm 
								class="mt-3"
								v-if="verForm" 
								@cerrar="cerrarModal" 
								@actualizar="actualizar"
								:usuario="reg" 
							/>
						</div>
						
						<template v-if="reg != null">
							<div 
								class="tab-pane fade" 
								id="profile" 
								role="tabpanel" 
								aria-labelledby="profile-tab" 
								tabindex="0"
							>	
								<UsuarioRol
									v-if="actual == 2"
									:rol="cat.rol"
									:user="reg" 
								/>
							</div>

							<div 
								class="tab-pane fade" 
								id="contact-tab-pane" 
								role="tabpanel" 
								aria-labelledby="contact-tab" 
								tabindex="0"
							>
								<UsuarioSucursal
									v-if="actual == 3"
									:sucursal="cat.sucursal"
									:user="reg" 
								/>
							</div>
						</template>
					</div>

					
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import UsuarioLista from '@/views/mnt/usuario/UsuarioLista.vue'
	import UsuarioForm from '@/views/mnt/usuario/UsuarioForm.vue'
	import UsuarioSucursal	from '@/views/mnt/usuario/UsuarioSucursal.vue' 
	import UsuarioRol	from '@/views/mnt/usuario/UsuarioRol.vue' 
	import Catalogo from '@/mixins/Catalogo.js'
	import { Modal } from 'bootstrap'
	import { Tab } from 'bootstrap'

	export default {
		name: 'Usuario',
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
			this.modal = new Modal(document.getElementById('modalNuevoUsuario'));
		},
		created() {
			this.getCatalogo(['rol', 'sucursal'])
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

  				let item = document.querySelector('#myTab li:first-child button')
  				let tab = new Tab(item);
   				tab.show();
  			},
			cerrarModal() {
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
			UsuarioLista,
			UsuarioForm,
			UsuarioSucursal,
			UsuarioRol
		}
	}
</script>