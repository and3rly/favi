<template>
	<div class="row mt-3">
		<div class="col-sm-12">
			<div class="alert alert-info p-2 mb-1 fw-bold m-0 rounded">
				<i class="fas fa-plus me-2"></i>Agregar sucursales
			</div>
		</div>
		
		<div class="col-sm-6">
			<ul class="list-group mt-3">
				<li 
					class="list-group-item active fw-bold" 
					aria-current="true"
				>
					Disponibles
				</li>

				<li class="list-group-item d-flex justify-content-between align-items-start">
					<div class="ms-2 me-auto">
						<div class="fw-bold">Sucursal 1</div>
					</div>
					<a 
						href="javascript:;"
						title="Asignar">
						<i class="fas fa-arrow-right" style="color: ;"></i>
					</a>
				</li>

			</ul>
		</div>
		<div class="col-sm-6">
			<ul class="list-group mt-3">
				<li 
					class="list-group-item active fw-bold" 
					aria-current="true"
				>
					Asignadas
				</li>

				<li class="list-group-item d-flex justify-content-between align-items-start">
					<a
						href="javascript:;"
						title="Quitar"
						class="ms-2 me-auto"
					>
						<i class="fas fa-arrow-left" style="color: red;"></i>
					</a>
					<div class="fw-bold">
					 	Sucursal 1
					</div>				
				</li>

			</ul>
		</div>
	</div>
</template>

<script>
	export default {
		data: () => ({

		})
	}
</script>