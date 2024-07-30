<template>
  <div v-if="actual == 1">
    <div class="alert alert-info p-2 mb-2">
      <i class="fas fa-lightbulb me-1"></i> Seleccione una orden de compra para poder cargar su detalle.
    </div>

    <div v-if="inicio" class="text-center mt-1 mb-3">
      <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <br>
      Cargando registros...
    </div>
    <div 
      class="table-responsive mt-0"
      v-else
    >
      <table class="table table-hover table-bordered table-sm m-0">
        <thead class="bg-light">
          <tr>
            <td colspan="100">
              <input 
                type="text" 
                v-model="termino"
                class="form-control"
                placeholder="Buscar..." 
              />
            </td>
          </tr>
          <tr>
            <th class="text-center">Id</th>
            <th>No. Documento</th>
            <th>Procedencia</th>
            <th class="text-center">Fecha</th>
            <th>Proveedor</th>
            <th>Bodega</th>
            <th>Motivo Devolución</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="!inicio && filtrada.length == 0">
            <td colspan="100" class="text-center">
              No se encontraron ordenes de compra.
            </td>
          </tr>
          <tr 
            v-else
            v-for="(i, idx) in filtrada"
            @click="getDetalle(i)"
            style="cursor: pointer;"
          >
            <th class="text-center">{{ i.id }}</th>
            <td>{{ i.no_documento }}</td>
            <td>{{ i.procedencia }}</td>
            <td class="text-center">{{ formatoFecha(i.fecha_creacion, 2) }}</td>
            <td>{{ i.nombre_proveedor }}</td>
            <td>{{ i.nombre_bodega }}</td>
            <td>{{ i.nombre_motivo_dev }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <template v-if="actual == 2">
    <div class="d-flex mb-2">
      <div class="flex mr-2">
        <button class="btn btn-secondary me-2" @click="actual = 1" :disabled="btnGuardar">
          <i class="fas fa-arrow-left"></i>
        </button>
      </div>
      <div class="flex-grow-1">
        <div class="alert alert-info p-2 mb-2 fw-bold">
          No. Documento #{{ this.oc.no_documento }}
        </div>
      </div>
    </div>
    <div v-if="inicio" class="text-center mt-1 mb-3">
      <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <br>
      Cargando detalle...
    </div>

    <template v-else>     
      <div class="table-responsive">
        <table class="table table-sm table-bordered">
          <thead class="bg-light">
            <tr>
              <th class="text-center">No.</th>
              <th>Código producto</th>
              <th>Nombre</th>
              <th>Cantidad</th>
              <th>Presentación</th>
              <th>UM</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(i, idx) in detalle">
              <td class="text-center">{{ idx + 1 }}</td>
              <td>{{ i.codigo_producto }}</td>
              <td>{{ i.nombre_producto }}</td>
              <td>{{ i.cantidad }}</td>
              <td>{{ i.nombre_presentacion }}</td>
              <td>{{ i.nombre_unidad_medida }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="text-end">
        <button class="btn btn-success" :disabled="btnGuardar" @click="guardar">
          <i class="fa fa-check"></i> Aceptar
        </button>
      </div>
    </template>
  </template>
</template>

<script>
  import Utileria from '@/mixins/Utileria.js'
  export default {
    mixins: [Utileria],
    name:"FormProd",
    props: {
      rec: {
        type: Object
      }
    },
    data: () => ({
      inicio: false,
      btnGuardar: false,
      actual: 1,
      termino: '',
      oc: null,
      bform: {},
      lista: [],
      detalle: [],
      form: {}
    }),
    created() {
      this.bform.bodega_id = this.rec.bodega_id
      this.getListaOc()
    },
    methods: {
      getListaOc() {
        this.inicio = true

        this.$http
        .get(`${this.$baseUrl}/orden/ordencompra/buscar`, {params: this.bform})
        .then(res => {
          this.inicio = false
          if (res.data.lista) {
            this.lista = res.data.lista
          }
        }).catch(e => {
          this.inicio = false
          console.log(e)
        })
      },
      getDetalle(obj) {
        this.$emit("actualizar", false)
        this.oc = obj
        this.actual = 2
        this.inicio = true

        this.$http
        .get(`${this.$baseUrl}/orden/detalle/ordencompradetalle/buscar`, {params: { orden_compra_enc_id: obj.id }})
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
      guardar() {
        this.btnGuardar = true
        this.form.detalle = this.detalle
        this.form.id = this.rec.id
        this.form.oc = this.oc.id

        this.$http
        .post(`${this.$baseUrl}/recepcion/detalle/guardar_detalle`, this.form)
        .then(result => {
          this.btnGuardar = false

          let res = result.data
          
          if (res.exito) {
              this.$emit('actualizar', true)
          } else {
            this.$toast.error(res.mensaje)
          }
        }).catch(e => {
          this.btnGuardar = false
          console.log(e)
        })
      }
    },
    computed: {
      filtrada() {
      return this.lista.filter(o => {
        if (this.termino === '') {
            return true;
        } else {
            let res = false
            let ter = this.termino.toLowerCase()

            for (let i in o) {
              if (typeof o[i] === 'string' && o[i].toLowerCase().includes(ter)) {
                  res = true
              } else if (o[i] == ter) {
                  res = true
              }
            }

            return res
        }
      })
    }
    }
  }
</script>