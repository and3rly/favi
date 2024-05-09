<template>
  <div class="text-end" v-if="despacho.estado != 'Finalizado'">
    <button 
      type="button" 
      class="btn btn-lime mb-2" 
      @click="despachar"
      :disabled="btnGuardar"
    >
      <i class="fas fa-check me-1"></i>Despachar
    </button>
  </div>

  <div class="alert alert-success text-center" role="alert" v-if="despacho.estado == 'Finalizado'"> 
    Despacho finalizado con éxito.
  </div>

  <div class="table-responsive">
    <table class="table table-sm table-hover table-bordered">
      <thead class="bg-light">
        <tr>
          <th>#</th>
          <th>Código</th>
          <th>Nombre</th>
          <th>Cantidad Despachada</th>
          <th>Peso Despachado</th>
          <th>UM</th>
          <th>Estado</th>
          <th>Presentación</th>
          <th v-if="despacho.estado !='Finalizado'"></th>
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
              v-model="i.cantidad_despachada"
            />
          </td>
          <td>
            <input 
              type="number" 
              class="form-control text-center" 
              v-model="i.peso_despachado"
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
          <td class="text-center" v-if="despacho.estado != 'Finalizado'">
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
      despacho: {
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
      controlador: 'despacho/detalle',
      btnGuardar: false
    }),
    created() {
      this.bform.despacho_enc_id = this.despacho.id

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
      despachar() {
        this.btnGuardar = true

        let datos = {
          detalle: this.detalle,
          bodega: this.despacho.bodega_id
        }

        this.$http
        .post(`${this.$baseUrl}/despacho/principal/despachar`, datos)
        .then(res => {
          this.btnGuardar = false

          if (res.data.exito) {
            this.$toast.success(res.data.mensaje)
            this.$emit("act-rec", res.data.despacho.estado)
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