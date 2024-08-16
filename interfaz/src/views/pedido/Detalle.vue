<template>
  <div class="table-responsive">
    <table class="table table-sm table-hover table-bordered">
      <thead class="bg-light">
        <tr>
          <th class="text-center">No. Línea</th>
          <th class="text-center">Código</th>
          <th class="text-center">Nombre</th>
          <th class="text-center">Cantidad</th>
          <th class="text-center">Precio</th>
          <th class="text-center">Total</th>
          <th class="text-center">Cantidad<br> Despachada</th>
          <th class="text-center">Peso</th>
          <th class="text-center">UM</th>
          <th class="text-center">Presentación</th>
          <th class="text-center">Lote</th>
          <th class="text-center">Fecha V.</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(i, idx) in detalle">
          <td>{{ i.no_linea }}</td>
          <td>{{ i.codigo_producto }}</td>
          <td>{{ i.nombre_producto }}</td>
          <td class="text-center">{{ i.cantidad }}</td>
          <td class="text-center">{{ i.precio }}</td>
          <td class="text-center">{{ ObtenerTotal(i.cantidad * i.precio) }}</td>
          <td class="text-center">{{ i.cantidad_despachada }}</td>
          <td class="text-center">{{ i.peso }}</td>
          <td class="text-center">{{ i.nombre_unidad_medida }}</td>
          <td class="text-center">{{ i.nombre_presentacion }}</td>
          <td class="text-center">{{ i.lote }}</td>
          <td class="text-center">{{ formatoFecha(i.fecha_vence,1) }}</td>
          <td class="text-center">
            <button
              class="btn btn-sm btn-danger me-1" 
              title="Eliminar"
              :disabled="finalizado"
              @click="eliminarDetalle(i)"
            >
              <span class="fas fa-trash"></span>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
  import Utileria from "@/mixins/Utileria.js"

  export default {
    name: "Detalle",
    mixins:[Utileria],
    props: {
      pedido: {
        type: Object
      },
      cat: {
        type: Array,
        required: true
      },
      ud: {
        type: Boolean,
        default:false
      },
      finalizado: false,
    },
    data: () => ({
      bform: {},
      detalle: [],
      pk_det: "",
      controlador: 'pedido/detalle',
      btnGuardar: false,
    }),
    created() {
      this.bform.pedido_enc_id = this.pedido.id

      this.buscar()
    },
    methods: {
      buscar() {
        this.inicio = true

        this.$http
        .get(`${this.$baseUrl}/${this.controlador}/buscar`, {params: this.bform})
        .then(res => {
          this.inicio = false
          if (res.data.lista) {
            this.detalle = res.data.lista
          }
        }).catch(e => {
          this.inicio = false
          console.log(e)
        })
      },
      eliminarDetalle(obj){
        if (confirm("¿Está seguro de eliminar el detalle?")) {

          this.$http
          .post(`${this.$baseUrl}/pedido/detalle/eliminarDetalle/${obj.id}`)
          .then(res => {

            if (res.data.exito) {
              this.$toast.success(res.data.mensaje)

              let idx = this.detalle.indexOf(obj)
              this.detalle.splice(idx, 1)
              
            } else {
              this.$toast.error(res.data.mensaje)
            } 

          }).catch(e => {
            this.btnGuardar = false
            console.log(e)
          })
        }
      },
      ObtenerTotal(value) {
          return `Q. ${parseFloat(value).toFixed(2)}`;
      }
    },
    watch: {
      ud(v) {
        if (v == true) {
          this.buscar()
        }
      }
    }
  }
</script>