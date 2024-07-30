<template>
  <div class="text-end" v-if="recepcion.estado_recepcion_id != 6">
    <button 
      type="button" 
      class="btn btn-lime mb-2" 
      @click="recibir"
      :disabled="btnGuardar"
    >
      <i class="fas fa-check me-1"></i>Recibir
    </button>
  </div>

  <div class="alert alert-success text-center" role="alert" v-if="recepcion.estado_recepcion_id == 6"> 
    Recepción finalizada con éxito.
  </div>

  <div class="table-responsive">
    <table class="table table-sm table-hover table-bordered">
      <thead class="bg-light">
        <tr>
          <th>#</th>
          <th>Código</th>
          <th>Nombre</th>
          <th>Cantidad</th>
          <th>Fecha Vence</th>
          <th>Lote</th>
          <th>UM</th>
          <th>Estado</th>
          <th>Presentación</th>
          <th v-if="recepcion.estado_recepcion_id != 6"></th>
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
              v-model="i.cantidad_recibida"
            />
          </td>
          <td>
            <input 
              type="date" 
              class="form-control text-center"
              :class="i.control_vence == 1 && (i.fecha_vence == null || !i.fecha_vence) ? 'bg-danger bg-opacity-20': ''"
              v-model="i.fecha_vence"
              :disabled="i.control_vence == 0"
            />
          </td>
          <td>
            <input 
              type="text" 
              class="form-control text-center" 
              v-model="i.lote"
              required
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
              v-model="i.estado_producto_id" 
            >
              <option value=""></option>
              <option 
                v-for="(k, idx) in cat.estado_prod" 
                :value="k.id"
              >
                {{ k.nombre }}
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
                v-for="(l, idx) in cat.presentacion.filter(e =>  {return e.producto_id == i.id_producto})" 
                :value="l.id"
              >
                {{ l.codigo }} - {{ l.factor}}
              </option>
            </select>
          </td>
          <td class="text-center" v-if="recepcion.estado_recepcion_id != 6">
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
              @click="eliminar_producto(i, idx)"
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
      recepcion: {
        type: Object,
        default: null
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
      controlador: 'recepcion/detalle',
      btnGuardar: false
    }),
    created() {
      this.bform.recepcion_enc_id = this.recepcion.id

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

        if (parseInt(datos.control_vence) == 1) {
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
      eliminar_producto(obj, idx) {
        this.btnGuardar = true

        this.$http
        .post(`${this.$baseUrl}/${this.controlador}/eliminar_producto/${obj.id}`)
        .then(res => {
          this.btnGuardar = false

          if (res.data.exito) { 
            this.detalle.splice(idx, 1)
            this.$toast.success(res.data.mensaje)
          } else {
            this.$toast.error(res.data.mensaje)
          } 

        }).catch(e => {
          this.btnGuardar = false
          console.log(e)
        })    
      },
      recibir() {
        this.btnGuardar = true

        let datos = {
          detalle: this.detalle,
          bodega: this.recepcion.bodega_id,
          transaccion: this.recepcion.tipo_transaccion_id,
          rec: this.recepcion.id         
        }

        this.$http
        .post(`${this.$baseUrl}/recepcion/principal/recibir`, datos)
        .then(res => {
          this.btnGuardar = false

          if (res.data.exito) {
            this.$toast.success(res.data.mensaje)
            this.$emit("act-rec", res.data.recepcion.estado_recepcion_id)
          } else {
            this.$toast.error(res.data.mensaje)
          } 

        }).catch(e => {
          this.btnGuardar = false
          console.log(e)
        })    
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