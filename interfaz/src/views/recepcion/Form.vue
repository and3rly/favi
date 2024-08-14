<template>
  <form @submit.prevent="guardar">
    <div class="row g-2 mb-3">
      <div class="col-sm-3">
        <label for="selectEstado" class="fw-bold mb-1">
          Estado: <span class="text-danger">*</span>
        </label>
        <select 
          name="selectEstado" 
          id="selectEstado" 
          class="form-select"
          v-model="form.estado_recepcion_id"
          required
        > 
          <option value="">---------------</option>
          <option v-for="i in cat.estado" :value="i.id">{{ i.nombre }}</option>
        </select>
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

      <div class="col-sm-3">
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
        <label for="selectBodega" class="fw-bold mb-1">
          Tipo: <span class="text-danger">*</span>
        </label>
        <select 
          name="selectBodega" 
          id="selectBodega" 
          class="form-select"
          v-model="form.recepcion_tipo_id"
          required
        > 
          <option value="0">---------------</option>
          <option v-for="i in cat.tipos" :value="i.id">{{ i.nombre }}</option>
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
        <label for="selectVehiculo" class="fw-bold mb-1">
          No. Guía: 
        </label>
        <input 
          type="text" 
          class="form-control" 
          id="inputNoGuia"
          v-model="form.no_guia"
        />
      </div>

      <div class="col-sm-3">
        <label for="selectVehiculo" class="fw-bold mb-1">
          No. Marchamo: 
        </label>
        <input 
          type="text" 
          class="form-control" 
          id="inptuMarchamo"
          v-model="form.no_marchamo"
        />
      </div>

      <div class="col-sm-6">
        <label for="selectVehiculo" class="fw-bold mb-1">
          Fecha recepción: 
        </label>
        <input 
          type="date" 
          class="form-control" 
          id="inputFechaRec"
          v-model="form.fecha_recepcion"
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

      <div class="col-sm-12">
        <label for="inputObservacion" class="fw-bold mb-1">
          Observación: 
        </label>
        <textarea 
          class="form-control" 
          id="inputObservacion" 
          v-model="form.observacion"
          rows="3"
        ></textarea>
      </div>

      <div class="col-sm-2">
        <div class="form-check form-switch mt-2">
          <input 
            class="form-check-input" 
            type="checkbox" 
            role="switch" 
            id="chkStock" 
            :true-value="1" 
            :false-value="0"
            v-model="form.ingresa_stock"
            checked 
          >
          <label class="form-check-label" for="chkStock">Ingresa a stock</label>
        </div>
      </div>

      <template v-if="pk !== ''">
        <div class="col-sm-2">
          <div class="form-check form-switch mt-2">
            <input 
              class="form-check-input" 
              type="checkbox" 
              role="switch" 
              id="chkAnulada" 
              :true-value="1" 
              :false-value="0"
              v-model="form.anulada"
              checked 
            >
            <label class="form-check-label" for="chkAnulada">Anulada</label>
          </div>
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
      </template>

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
      recepcion: {
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
      this.controlador = 'recepcion/principal'
      this.autoBuscar = false
      this._emit = true

      if (this.recepcion !== null) {
        this.setDatosForm(this.recepcion)
      } else {
        this.fbase = {
          vehiculos_id: "",
          bodega_id: "",
          pilotos_id: "",
          recepcion_tipo_id: "0",
          tipo_transaccion_id: 1,
          estado_recepcion_id: 1,
          ingresa_stock: 1,
          anulada: 0,
          detalle: []
        }
      }
    },
    methods: {
    },
    watch: {
      recepcion(v) {
        this.setDatosForm(v)
      }
    }
  }
</script>