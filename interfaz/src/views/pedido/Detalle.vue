<template>
  <div class="table-responsive">
    <table class="table table-sm table-hover table-bordered">
      <thead class="bg-light">
        <tr>
          <th>No. Línea</th>
          <th>Código</th>
          <th>Nombre</th>
          <th>Cantidad</th>
          <th>Cantidad Despachada</th>
          <th>Peso</th>
          <th>UM</th>
          <th>Presentación</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(i, idx) in detalle">
          <td>{{ i.no_linea }}</td>
          <td>{{ i.codigo_producto }}</td>
          <td>{{ i.nombre_producto }}</td>
          <td>
            <input 
              type="number" 
              class="form-control text-center" 
              v-model="i.cantidad"
            />
          </td>
          <td>
            <input 
              type="number" 
              class="form-control text-center" 
              v-model="i.cantidad_despachada"
            />
          </td>
          <td>
            <input 
              type="number" 
              class="form-control text-center" 
              v-model="i.peso"
            />
          </td>
          <td>
            <select 
              name="selectUm" 
              id="selectUm"
              class="form-select"
              v-model="i.unidad_medida_id" 
            >
              <option value=""></option>
              <option 
                v-for="(j, idx) in cat.um" 
                :value="j.id"
              >
                {{ j.nombre }}
              </option>
            </select>
          </td>
          <td>
            <select 
              name="selectUm" 
              id="selectUm"
              class="form-select"
              v-model="i.presentacion_producto_id" 
            >
              <option :value="null"></option>
              <option 
                v-for="(l, idx) in cat.presentacion" 
                :value="l.id"
              >
                {{ l.codigo }} - {{ l.factor}}
              </option>
            </select>
          </td>
          <td class="text-center">
            <!--button
              class="btn btn-sm btn-secondary me-1 ms-1" 
              title="Editar" 
            >
              <span class="fas fa-edit"></span>
            </button-->
            <button
              class="btn btn-sm btn-primary me-1" 
              title="Guardar" 
              :disabled="btnGuardar"
              @click="guardar(i)"
            >
              <span class="fas fa-save"></span>
            </button>
            <button
              class="btn btn-sm btn-danger me-1" 
              title="Eliminar"
              :disabled="btnGuardar"
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
  export default {
    name: "Detalle",
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
      }
    },
    data: () => ({
      bform: {},
      detalle: [],
      pk_det: "",
      controlador: 'pedido/detalle',
      btnGuardar: false
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
      guardar(obj) {  
        this.btnGuardar = true

        let datos = obj
        if (datos.hasOwnProperty('id')) {
          this.pk_det = datos.id
        } 

        if (datos.control_vence) {
          if (!datos.fecha_vence) {
            this.$toast.error("Debe ingresar una fecha de vencimiento")
            this.btnGuardar = false
            return
          }
        }
        
        if (!datos.estado_producto_id) {
          this.$toast.error("Debe seleccionar un estado.")
          this.btnGuardar = false
          return
        }

        if (datos.presentacion_producto_id) {
          datos.nombre_presentacion    = this.cat.presentacion.filter(e => { return e.id == datos.presentacion_producto_id})[0].nombre 
        }
        
        datos.nombre_unidad_medida   = this.cat.um.filter(e => { return e.id == datos.unidad_medida_id})[0].nombre 
        datos.nombre_producto_estado = this.cat.estado_prod.filter(e => { return e.id == datos.estado_producto_id})[0].nombre 

        this.$http
        .post(`${this.$baseUrl}/${this.controlador}/guardar/${this.pk_det}`, datos)
        .then(res => {
          this.btnGuardar = false

          let exito = res.data.exito
          let idx = this.detalle.indexOf(obj)

          if (exito == 1) {
            this.detalle[idx] = res.data.linea
            this.$toast.success(res.data.mensaje)

          } else if (exito == 2) {
            this.detalle[idx].pendiente = true
            this.$toast.error(res.data.mensaje)

          } else {
            this.detalle[idx].pendiente = false
            this.$toast.error(res.data.mensaje)
          }   

          this.btnGuardar = false 
        }).catch(e => {
          this.btnGuardar = false
          console.log(e)
        })        
      },  
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