<template>
  <div class="d-flex py-2">
    <div class="flex-fill me-1">
      <h1 class="page-header mb-1">
        <i class="fa-solid fa-chart-line"></i> Movimientos por Bodega
      </h1>
    </div>
  </div>

	<Card class="mt-1">
      <form @submit.prevent="ObtenerMovimientos" class="d-flex px-3 mt-3 mb-3">
        <div class="flex-fill me-1">
          <select 
            name="selectBodega" 
            id="selectBodega"
            class="form-select" 
            v-model="bform.bodega_id"
          >
            <option :value="null">Seleccione una bodega...</option>
            <option v-for="i in cat.bodega" :value="i.id"> {{ i.nombre }} </option>
          </select>
        </div>
        <div class="flex-fill me-1">
          <input 
            type="search" 
            class="form-control" 
            placeholder="Buscar por criterio..."
            v-model="bform.criterio"
          />
        </div>
        <button
          class="btn btn-primary"
        >
          <i class="fas fa-search"></i>
        </button>
      </form>

      <CardBody>
        <div v-if="inicio === true" class="text-center">
          <div class="spinner-border" role="status">
            <span class="sr-only"/>
          </div>
          <p>Cargando registros...</p>
        </div>

        <div v-else class="table-responsive">
          <table class="table table-sm table-hover table-bordered m-0">
            <thead class="bg-light">
              <tr>
                <th class="text-center" width="50">#</th>
                <th class="text-center">Tipo Transaccion</th>
                <th class="text-center">Código Producto</th>
                <th class="text-center">Nombre Producto</th>
                <th class="text-center">Lote</th>
                <th class="text-center">Fecha Vencimiento</th>
                <th class="text-center">Presentación</th>
                <th class="text-center">Cantidad <br /> Presentación</th>
                <th class="text-center">Peso</th>
                <th class="text-center">Cantidad <br /> Anterior</th>
                <th class="text-center">UM</th>
                <th class="text-center">Cantidad Unidad <br /> Medida</th>
                <th class="text-center">Estado Origen</th>
                <th class="text-center">Estado Destino</th>
                <th class="text-center" width="500">Ubicación Origen</th>
                <th class="text-center" width="500">Ubicación Destino</th>
                <th class="text-center">Fecha Operación</th>
              </tr>
            </thead>
            <tbody>
              <tr 
                v-for="(i, idx) in movimientos" 
                :key="idx"
                style="cursor: pointer;"
              > 
                <th class="text-center"> {{ i.id }} </th>
                <span 
                    :class="'badge bg-'+i.color+' bg-opacity-20 text-'+i.color+' fs-11px d-inline-flex align-items-center'"
                  >
                    <i 
                      :class="'fa fa-check-circle text-'+i.color+' fs-10px fa-fw me-1'"
                    ></i>{{ i.nombre_transacion_tipo }}
                  </span>
                <td class="text-center"> {{ i.codigo_producto }} </td>
                <td class="text-center"> {{ i.nombre_producto }} </td>
                <td class="text-center"> {{ i.lote }} </td>
                <td class="text-center"> {{ formatoFecha(i.fechaVence,1) }} </td>
                <td class="text-center"> {{ i.nombre_presentacion }} </td>
                <td class="text-center"> {{ i.cantidad_presentacion }} </td>
                <td class="text-center"> {{ i.peso }} </td>
                <td class="text-center"> {{ i.cantHist }} </td>
                <td class="text-center"> {{ i.nombre_um }} </td>
                <td class="text-center"> {{ i.cantidad }} </td>
                <td class="text-center"> {{ i.nombre_estado_origen }} </td>
                <td class="text-center"> {{ i.nombre_estado_destino }} </td>
                <td class="text-center"> {{ i.ubic_origen }} </td>
                <td class="text-center"> {{ i.ubic_destino }} </td>
                <td class="text-center"> {{ formatoFecha(i.fechaOperacion,1) }} </td>
              </tr>
            </tbody>
          </table>
        </div>
      </CardBody>
    </Card>
</template>

<script>
	import Utileria from '@/mixins/Utileria.js'

	export default{
		name:"Movimientos",
		mixins:[Utileria],
		data: () => ({
		  inicio: false,
		  bform: {},
		  movimientos:[],
      btnGuardar: false,
      controlador: 'movimientos/principal',
      cat:[]
		}),
		created() {
	      this.ObtenerMovimientos()
        this.getDatos()
        this.bform.bodega_id = null
	    },
	    methods:{
        getDatos() {
          this.inicio = true

          this.$http
          .get(`${this.$baseUrl}/movimientos/principal/get_datos`)
          .then(res => {

            this.inicio = false
            this.cat = res.data.cat

          }).catch(e => {
            this.inicio = false
            console.log(e)
          })
        },
	    	ObtenerMovimientos(){
	    		this.inicio = true;
          this.$emit("actualizar", false)
		        this.$http
		        .get(`${this.$baseUrl}/movimientos/principal/ObtenerMovimientos`, {params: this.bform})
		        .then(res => {

		          this.inicio = false
		          this.movimientos = res.data.movimientos

		        }).catch(e => {
		          this.inicio = false
		          console.log(e)
		        })
		    },
	    },
	}
</script>