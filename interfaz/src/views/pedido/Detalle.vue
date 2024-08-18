<template>
  <div class="table-responsive">
    <table class="table table-sm table-hover table-bordered">
      <thead class="bg-light">
        <tr>
          <th class="text-center align-middle">No. Línea</th>
          <th class="text-center align-middle">Código</th>
          <th class="text-center align-middle">Nombre</th>
          <th class="text-center align-middle">Cantidad</th>
          <th class="text-center align-middle">Precio</th>
          <th class="text-center align-middle">Total</th>
          <th class="text-center align-middle">Cantidad<br> Despachada</th>
          <th class="text-center align-middle">Peso</th>
          <th class="text-center align-middle">UM</th>
          <th class="text-center align-middle">Presentación</th>
          <th class="text-center align-middle">Lote</th>
          <th class="text-center align-middle">Fecha V.</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(i, idx) in detalle">
          <td class="align-middle">{{ i.no_linea }}</td>
          <td class="align-middle">{{ i.codigo_producto }}</td>
          <td class="align-middle">{{ i.nombre_producto }}</td>
          <td class="text-center align-middle">{{ i.cantidad }}</td>
          <td class="text-center col-md-1">
            <input 
              type="number" 
              class="form-control text-center" 
              v-model="i.precio"
              min="0"
              @blur="CambiarPrecio(i, idx)"
              @keydown.enter="EditarPrecio(i, idx)"
            />
          </td>
          <td class="text-center align-middle">{{ ObtenerTotal(i.total) }}</td>
          <td class="text-center align-middle">{{ i.cantidad_despachada }}</td>
          <td class="text-center align-middle">{{ i.peso }}</td>
          <td class="text-center align-middle">{{ i.nombre_unidad_medida }}</td>
          <td class="text-center align-middle">{{ i.nombre_presentacion }}</td>
          <td class="text-center align-middle">{{ i.lote }}</td>
          <td class="text-center align-middle">{{ formatoFecha(i.fecha_vence,1) }}</td>
          <td class="text-center align-middle">
            <button
              class="btn btn-sm btn-primary me-1" 
              title="Guardar"
              :disabled="finalizado || !(itemsCambiados && itemsCambiados.includes(idx))"
              @click="EditarPrecio(i, idx)"
            >
              <span class="fas fa-save me-1"></span>
            </button>

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
      itemsCambiados: [],
      detalleOriginal: []
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
            this.detalleOriginal = JSON.parse(JSON.stringify(this.detalle));
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
      },
      EditarPrecio(obj, idx){

        if (confirm("¿Está seguro de editar el precio?")) {

          let datos = obj

          this.$http
            .post(`${this.$baseUrl}/pedido/detalle/guardar`, datos)
            .then(res => {
              this.itemsCambiados.splice(idx);

              let exito = res.data.exito

              if (exito == 1) {

                this.detalleOriginal[idx].precio = obj.precio
                this.detalleOriginal[idx].total = obj.total

                this.$toast.success(res.data.mensaje)
              } else {
                this.$toast.error(res.data.mensaje)
                this.itemsCambiados.push(idx)
              } 
            }).catch(e => {
              this.itemsCambiados.push(idx);
              console.log(e)
            })
        }

      },
      CambiarPrecio(item, idx) {

        const valorAntiguo = this.detalleOriginal[idx].precio;
        const cantidadOrignal = this.detalleOriginal[idx].cantidad;
        const nuevoValor = item.precio;

        if (valorAntiguo !== nuevoValor) {
          if (!this.itemsCambiados.includes(idx)) {
            this.itemsCambiados.push(idx);
            item.total = cantidadOrignal * nuevoValor
          }else{
            this.itemsCambiados.splice(idx);
          }
        }
      },
    },
    watch: {
      ud(v) {
        if (v == true) {
          this.buscar()
        }
      },
    }
  }
</script>