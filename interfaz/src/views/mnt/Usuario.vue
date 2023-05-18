<template>
	<div class="d-flex align-items-center mb-4">
		<h1 class="page-header mb-0">
			<i class="fas fa-user fa-sm me-1 ms-1"></i>Usuarios
		</h1>
		<div class="ms-auto">
			<a href="#" class="btn btn-theme">
				<i class="fa fa-plus-circle fa-fw me-1"></i> Nuevo Usuario
			</a>
		</div>
	</div>

	<div class="card">
		<div class="card-body p-4">
			<div class="input-group mb-4 mt-3">
					<div class="flex-fill position-relative">
						<div class="input-group">
							<input 
								type="text" 
								class="form-control ps-35px" 
								placeholder="Filtrar usuario" 
							/>
							<div 
								class="input-group-text position-absolute top-0 bottom-0 bg-none border-0" 
								style="z-index: 1020;"
							>
								<i class="fa fa-search opacity-5"></i>
							</div>
						</div>
					</div>

					<button 
						class="btn btn-default dropdown-toggle rounded-0" 
						type="button" 
						data-bs-toggle="dropdown"
					>
						<span class="d-none d-md-inline">
							Ordenar por
						</span>
						<span class="d-inline d-md-none">
							<i class="fa fa-credit-card"></i>
						</span>
					</button>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="#">Nombre</a>
						<a class="dropdown-item" href="#">Usuario</a>
						<a class="dropdown-item" href="#">Sucursal</a>
						<a class="dropdown-item" href="#">Rol</a>
					</div>

					<button 
						class="btn btn-default rounded-0" 
						type="button" 
					>
						<span class="d-none d-md-inline">
							<i class="fas fa-filter me-1"></i> Filtros
						</span>
					</button>

				</div>

			<div class="table-responsive-sm table-responsive-lg">
				<table class="table table-sm table-borderless text-nowrap mb-0">
					<thead>
						<tr>
							<th scope="col" class="text-center" width="30">#</th>
							<th scope="col" class="text-center">Foto</th>
							<th scope="col" class="text-center">Nombre</th>
							<th scope="col" class="text-center">Usuario</th>
							<th scope="col" class="text-center">Teléfono</th>
							<th scope="col" class="text-center">Correo</th>
							<th scope="col" class="text-center">Sucursal</th>		
							<th scope="col" class="text-center">Rol</th>
							<th scope="col" class="text-center" width="70">Acción</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th scope="row" class="text-center">1</th>
							<td class="text-center">
								<a href="javascript:;">Mark</a>
							</td>
							<td class="text-center">Otto</td>
							<td class="text-center">@mdo</td>
							<td class="text-center">Mark</td>
							<td class="text-center">Otto</td>
							<td class="text-center">@mdo</td>
							<td class="text-center">@mdo</td>
							<td class="text-center">
								<div class="dropdown position-static">
									<a 
										href="javascript:;"
										data-bs-toggle="dropdown"
										aria-expanded="false" 
										role="button"
									>
										<i class="fas fa-ellipsis-v"></i>
									</a>
								  <div class="dropdown-menu dropdown-menu-end">
								    <a 
								    	href="javascript:;" 
								    	class="dropdown-item"
								    >
								    	<i class="fas fa-edit me-2"> </i>Editar
								    </a>
								    <a
								    	href="javascript:;" 
								    	class="dropdown-item"
								    >
								    	<i class=" fas fa-trash-alt me-2"></i>Anular
								    </a>
								  </div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
</template>

<script>
	export default {

	}
</script>