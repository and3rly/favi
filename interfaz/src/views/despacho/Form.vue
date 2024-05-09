<template>
  <form @submit.prevent="guardar">
    <div class="row g-2 mb-3">

     <div class="col-sm-3">
        <label for="inputEstado" class="fw-bold mb-1">
          Estado: 
        </label>
        <input 
          type="text" 
          class="form-control" 
          id="inputEstado"
          readonly
          v-model="form.estado"
        />
      </div>

      <div class="col-sm-3">
        <label for="selectTransaccion" class="fw-bold mb-1">
          Transacción: <span class="text-danger">*</span>
        </label>
        <select 
          name="selectTransaccion" 
          id="selectTransaccion" 
          class="form-select"
          v-model="form.tipo_transaccion_id"
          required
        > 
          <option value="">---------------</option>
          <option v-for="i in cat.transaccion" :value="i.id">{{ i.nombre }}</option>
        </select>
      </div>

      <div class="col-sm-6">
        <label for="selectBodega" class="fw-bold mb-1">
          Bodega: <span class="text-danger">*</span>
        </label>
        <select 
          name="selectBodega" 
          id="selectBodega" 
          class="form-select"
          v-model="form.bodega_id"
          required
        > 
          <option value="">---------------</option>
          <option v-for="i in cat.bodega" :value="i.id">{{ i.nombre }}</option>
        </select>
      </div>

      <div class="col-sm-3">
        <label for="selectVehiculo" class="fw-bold mb-1">
          Vehículo: 
        </label>
        <select 
          name="selectVehiculo" 
          id="selectVehiculo" 
          class="form-select"
          v-model="form.vehiculos_id"
          required
        > 
          <option value="">---------------</option>
          <option v-for="i in cat.vehiculo" :value="i.id">{{ i.marca }} - {{ i.tipo }}</option>
        </select>
      </div>

      <div class="col-sm-3">
        <label for="selectVehiculo" class="fw-bold mb-1">
          Piloto: 
        </label>
        <select 
          name="selectVehiculo" 
          id="selectVehiculo" 
          class="form-select"
          v-model="form.pilotos_id"
          required
        > 
          <option value="">---------------</option>
          <option v-for="i in cat.piloto" :value="i.id">{{ i.nombres }} {{ i.apellidos }}</option>
        </select>
      </div>

       <div class="col-sm-3">
        <label for="selectRuta" class="fw-bold mb-1">
          Ruta: 
        </label>
        <select 
          name="selectRuta" 
          id="selectRuta" 
          class="form-select"
          v-model="form.ruta_id"
          required
        > 
          <option value="">---------------</option>
          <option v-for="i in cat.ruta" :value="i.id">{{ i.nombre }} {{ i.vendedor }}</option>
        </select>
      </div>

      <div class="col-sm-3">
        <label for="inputObservacion" class="fw-bold mb-1">
          Observacion: 
        </label>
        <input 
          type="text" 
          class="form-control" 
          id="inputObservacion"
          v-model="form.observacion"
        />
      </div>

      <div class="col-sm-3">
        <label for="inptuMarchamo" class="fw-bold mb-1">
          No. Marchamo: 
        </label>
        <input 
          type="text" 
          class="form-control" 
          id="inptuMarchamo"
          v-model="form.marchamo"
        />
      </div>

      <div class="col-sm-3">
        <label for="selectVehiculo" class="fw-bold mb-1">
          Hora inicio: 
        </label>
        <input 
          type="time" 
          class="form-control" 
          id="inputFechaRec"
          v-model="form.hora_inicio"
        />
      </div>

      <div class="col-sm-3">
        <label for="selectVehiculo" class="fw-bold mb-1">
          Hora fin: 
        </label>
        <input 
          type="time" 
          class="form-control" 
          id="inputFechaRec"
          v-model="form.hora_fin"
        />
      </div>

        <div class="col-sm-2">
          <div class="form-check form-switch mt-2">
            <input 
              class="form-check-input" 
              type="checkbox" 
              role="switch" 
              id="chkActivo" 
              :true-value="1" 
              :false-value="0"
              v-model="form.activo"
              checked 
            >
            <label class="form-check-label" for="chkActivo">Activa</label>
          </div>
        </div>


      <div class="text-end">
        <button 
          type="submit" 
          class="btn btn-primary"
          :disabled="btnGuardar"
        > 
            <span 
              v-if="btnGuardar"
              class="spinner-border spinner-border-sm me-1" 
              role="status" 
              aria-hidden="true"
            ></span>
            <i v-else class="fas fa-save me-1"></i>

            <span v-if="btnGuardar">Guardando...</span>
            <span v-else>Guardar</span>
        </button>
      </div>
  </div>
  </form>
</template>

<script>
  import Helper from '@/mixins/Helper.js'

  export default {
    mixins: [Helper],
    props: {
      despacho: {
        type: Object,
        default: null
      },
      cat: {
        type: Array,
        required: true
      }
    },
    data: () => ({
      cat: []
    }),
    created() {
      this.controlador = 'despacho/principal'
      this.autoBuscar = false
      this._emit = true

      if (this.despacho !== null) {
        this.setDatosForm(this.despacho)
      } else {
        this.fbase = {
          vehiculos_id: "",
          bodega_id: "",
          pilotos_id: "",
          ruta_id: "",
          tipo_transaccion_id: 3,
          estado: "Nuevo",
          detalle: []
        }
      }
    },
    methods: {
    },
    watch: {
      despacho(v) {
        this.setDatosForm(v)
      }
    }
  }
</script>