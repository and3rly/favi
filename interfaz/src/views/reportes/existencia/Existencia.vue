<template>
  <div class="d-flex py-2">
    <div class="flex-fill me-1">
      <h1 class="page-header mb-1">
        <i class="fa-solid fa-chart-line"></i> Existencia
      </h1>
    </div>
  </div>

	<Card class="mt-1">
      <form @submit.prevent="ObtenerStock" class="d-flex px-3 mt-3 mb-3">
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
                <th class="text-center">Código Producto</th>
                <th class="text-center">Nombre Producto</th>
                <th class="text-center">Lote</th>
                <th class="text-center">Fecha Vencimiento</th>
                <th class="text-center">Presentación</th>
                <th class="text-center">Cantidad <br /> Presentación</th>
                <th class="text-center">UM</th>
                <th class="text-center">Cantidad Unidad <br /> Medida</th>
                <th class="text-center">Ubicación</th>
              </tr>
            </thead>
            <tbody>
              <tr 
                v-for="(i, idx) in stock" 
                :key="idx"
                style="cursor: pointer;"
              > 
                <th class="text-center"> {{ idx + 1 }} </th>
                <td class="text-center"> {{ i.codigo_producto }} </td>
                <td class="text-center"> {{ i.nombre_producto }} </td>
                <td class="text-center"> {{ i.lote }} </td>
                <td class="text-center"> {{ formatoFecha(i.fecha_vence,1) }} </td>
                <td class="text-center"> {{ i.nombre_presentacion }} </td>
                <td class="text-center"> {{ i.cantidad_presentacion }} </td>
                <td class="text-center"> {{ i.nombre_unidad_medida }} </td>
                <td class="text-center"> {{ i.cantidad_stock }} </td>
                <td class="text-center"> {{ i.codigo_bodega_ubicacion }} - {{ i.descripcion_bodega_ubicacion }} </td>
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
		name:"Stock",
		mixins:[Utileria],
		data: () => ({
		  inicio: false,
		  bform: {},
		  stock:[],
      btnGuardar: false,
      controlador: 'pedido/detalle',
      cat:[]
		}),
		created() {
	      this.ObtenerStock()
        this.getDatos()
        this.bform.bodega_id = null
	    },
	    methods:{
        getDatos() {
          this.inicio = true

          this.$http
          .get(`${this.$baseUrl}/pedido/principal/get_datos`)
          .then(res => {

            this.inicio = false
            this.cat = res.data.cat

          }).catch(e => {
            this.inicio = false
            console.log(e)
          })
        },
	    	ObtenerStock(){
	    		this.inicio = true;
          this.$emit("actualizar", false)
		        this.$http
		        .get(`${this.$baseUrl}/pedido/principal/ObtenerStock`, {params: this.bform})
		        .then(res => {

		          this.inicio = false
		          this.stock = res.data.stock

		        }).catch(e => {
		          this.inicio = false
		          console.log(e)
		        })
		    },
        /*guardar(obj){
          this.btnGuardar = true

          let datos = obj

          if (!datos.cantidad || datos.cantidad < 1) {
            this.$toast.error("Debe ingresar una cantida mayor a 0.")
            this.btnGuardar = false
            return
          }

          if (datos.cantidad > datos.cantidad_stock) {
            this.$toast.error("La cantida a ingresar no debe ser mayor a la existente.")
            this.btnGuardar = false
            return
          }

          if (!datos.presentacion_producto_id || datos.presentacion_producto_id < 1 ) {
            this.$toast.error("El producto debe tener configurada la presentación, por favor verifique la información")
            this.btnGuardar = false
            return
          }

          if (!datos.unidad_medida_id || datos.unidad_medida_id < 1) {
            this.$toast.error("El producto debe tener configurada la unidad de medida, por favor verifique la información")
            this.btnGuardar = false
            return
          }

          datos.pedido_enc_id = this.pedido.id
          datos.cantidad_despachada = 0

          this.$http
          .post(`${this.$baseUrl}/${this.controlador}/guardarDetalle`, datos)
          .then(res => {
            this.btnGuardar = false

            let exito = res.data.exito
            let idx = this.stock.indexOf(obj)

            if (exito == 1) {
              this.stock[idx].cantidad_stock = datos.cantidad_stock - datos.cantidad
              this.stock[idx].cantidad = null

              this.$toast.success(res.data.mensaje)
              this.$emit('actualizar', true)

            } else {
              this.$toast.error(res.data.mensaje)
            } 
          }).catch(e => {
            this.btnGuardar = false
            console.log(e)
          })

          this.$emit('actualizar', false)
        },*/
	    },
	}
</script>