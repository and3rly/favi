<template>
  <form @submit.prevent="guardar">
    <div class="row g-2 mb-3">
      <div class="col-sm-6">
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
          <option :value="null">---------------</option>
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
          <option :value="null">---------------</option>
          <option v-for="i in cat.bodega" :value="i.id">{{ i.nombre }}</option>
        </select>
      </div>

      <div class="col-sm-3">
        <label for="selectEstado" class="fw-bold mb-1">
          Estado: <span class="text-danger">*</span>
        </label>
        <select 
          name="selectEstado" 
          id="selectEstado" 
          class="form-select"
          v-model="form.estado_despacho_id"
          required
        > 
          <option :value="null">---------------</option>
          <option v-for="i in cat.estado" :value="i.id">{{ i.nombre }}</option>
        </select>
      </div>

      <div class="col-sm-3">
        <label for="selectVehiculo" class="fw-bold mb-1">
          Hora inicio: <span class="text-danger">*</span>
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
          Hora fin: <span class="text-danger">*</span>
        </label>
        <input 
          type="time" 
          class="form-control" 
          id="inputFechaRec"
          v-model="form.hora_fin"
        />
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
          <option :value="null">---------------</option>
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
          <option :value="null">---------------</option>
          <option v-for="i in cat.piloto" :value="i.id">{{ i.nombres }} {{ i.apellidos }}</option>
        </select>
      </div>

      <div class="col-sm-3">
        <label for="selectVehiculo" class="fw-bold mb-1">
          Ruta: 
        </label>
        <select 
          name="selectVehiculo" 
          id="selectVehiculo" 
          class="form-select"
          v-model="form.ruta_id"
          required
        > 
          <option :value="null">---------------</option>
          <option v-for="i in cat.ruta" :value="i.id">{{ i.nombre }}</option>
        </select>
      </div>

      <div class="col-sm-6">
        <label for="selectVehiculo" class="fw-bold mb-1">
          No. Marchamo: 
        </label>
        <input 
          type="text" 
          class="form-control" 
          id="inptuMarchamo"
          v-model="form.marchamo"
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

      <template v-if="pk !== ''">
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
            <label class="form-check-label" for="chkActivo">Activo</label>
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
    name: "Form",
    mixins: [Helper],
    props: {
      despacho: {
        type: Object, 
        default: null
      }
    },
    data: () => ({

    }),
    created() {
      this.getDatos()
      this._emit = true
      this.autoBuscar = false
      this.controlador = "despacho/principal"

      if (this.despacho !== null) {
        this.setDatosForm(this.despacho)
      } else {
        this.fbase = {
          ruta_id: null,
          bodega_id: null,
          pilotos_id: null,
          vehiculos_id: null,
          estado_despacho_id: 1,
          tipo_transaccion_id: 3
        }
      }
    },
    methods: {
      getDatos() {
        this.inicio = true

        this.$http
        .get(`${this.$baseUrl}/despacho/principal/get_catalogo`)
        .then(res => {

          this.inicio = false
          this.cat = res.data.cat

        }).catch(e => {
          this.inicio = false
          console.log(e)
        })
      },
    },
    watch: {
      'cat.bodega'(v) {
        this.form.bodega_id = v[0].id
      },
      despacho(v) {
        this.setDatosForm(v)
      }
    }
  }
</script>