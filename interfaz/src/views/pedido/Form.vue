<template>
  <form @submit.prevent="guardar">
    <div class="row g-2 mb-3">

      <div :class="form.cliente_id == '' || form.cliente_id == null || form.cliente_id == clienteComodin || pedido != null ? 'col-sm-3' : 'col-sm-6'">
        <label for="selectCliente" class="fw-bold mb-1">
          Cliente: <span class="text-danger">*</span>
        </label>
        <vue-select 
          id="selectCliente"
          :options="clientes"
          :reduce="r => r.value"
          placeholder="------------"
          v-model="form.cliente_id"
        >  
        </vue-select>
      </div>

      <div class="col-sm-3 d-flex flex-column justify-content-beetwen" v-if="form.cliente_id == '' || form.cliente_id == null">
        <div class="text-right mt-auto">
          <a href="#" class="btn btn-theme" @click="abrirModal" title="Agregar Cliente">
            <i class="bi bi-person-plus-fill fs-6"></i>
          </a>
        </div>
      </div>

      <div class="col-sm-3" v-if="form.cliente_id != clienteComodin && pedido != null">
        <label class="fw-bold mb-1">
          Teléfono: 
        </label>
        <input 
          type="text" 
          class="form-control" 
          id="txtTelefono"
          disabled="false"
          required 
          v-model="form.telefono"
        />
      </div>

      <div class="col-sm-3" v-if="form.cliente_id == clienteComodin">
        <label class="fw-bold mb-1">
          Nombre Cliente: <span class="text-danger">*</span>
        </label>
        <input 
          type="text" 
          class="form-control" 
          id="txtNombreClienteComodin"
          required 
          v-model="form.nombre_cliente_comodin"
        />
      </div>

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
          disabled 
        > 
          <option value="">---------------</option>
          <option v-for="i in catPed.transaccion" :value="i.id">{{ i.nombre }}</option>
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
          <option v-for="i in catPed.bodega" :value="i.id">{{ i.nombre }}</option>
        </select>
      </div>

      <div class="col-sm-3">
        <label for="selectPedidoTipo" class="fw-bold mb-1">
          Tipo Pedido: 
        </label>
        <select 
          name="selectPedidoTipo" 
          id="selectPedidoTipo" 
          class="form-select"
          v-model="form.pedido_tipo_id"
          required
        > 
          <option value="">---------------</option>
          <option v-for="i in catPed.pedido_tipo" :value="i.id">{{ i.nombre }}</option>
        </select>
      </div>

      <div class="col-sm-3">
        <label for="selectMotAnul" class="fw-bold mb-1">
          Motivo Anulación: 
        </label>
        <select 
          name="selectMotAnul" 
          id="selectMotAnul" 
          class="form-select"
          v-model="form.motivo_anulacion_pedido_id"
          @change="cambiarMotivo"
        > 
          <option value="null">---------------</option>
          <option v-for="i in catPed.motivo_anulacion_pedido" :value="i.id">{{ i.nombre }}</option>
        </select>
      </div>

      <div class="col-sm-3">
        <label for="inputNoDoc" class="fw-bold mb-1">
          No. Documento: 
        </label>
        <input 
          type="text" 
          class="form-control" 
          id="inputNoDocumento"
          v-model="form.no_documento"
        />
      </div>
      
      <div class="col-sm-3">
        <label for="inputHoraInicio" class="fw-bold mb-1">
          Hora inicio: 
        </label>
        <input 
          type="time" 
          class="form-control" 
          id="inputHoraIni"
          v-model="form.hora_inicio"
        />
      </div>

      <div class="col-sm-3">
        <label for="inputHoraFinal" class="fw-bold mb-1">
          Hora fin: 
        </label>
        <input 
          type="time" 
          class="form-control" 
          id="inputHoraFin"
          v-model="form.hora_fin"
        />
      </div>

      <div class="col-sm-6">
        <label for="datePedido" class="fw-bold mb-1">
          Fecha pedido: 
        </label>
        <input 
          type="date" 
          class="form-control" 
          id="inputFechaPed"
          v-model="form.fecha_pedido"
        />
      </div>

      <div class="col-sm-12">
        <div class="col-sm-6">
          <label for="dateEntrega" class="fw-bold mb-1">
            Fecha entrega: 
          </label>
          <input 
            type="date" 
            class="form-control" 
            id="inputFechaEnt"
            v-model="form.fecha_entrega"
          />  
        </div>
      </div>

      <div class="col-sm-6">
        <label for="textRef" class="fw-bold mb-1">
          Referencia: 
        </label>
        <textarea 
          class="form-control" 
          id="inputReferencia" 
          v-model="form.referencia"
          rows="3"
        ></textarea>
      </div>

      <div class="col-sm-6">
        <label for="selectVehiculo" class="fw-bold mb-1">
          Observación: 
        </label>
        <textarea 
          class="form-control" 
          id="inputDescripcion" 
          v-model="form.observacion"
          rows="3"
        ></textarea>
      </div>



      <template v-if="pk !== ''">
        <!--<div class="col-sm-2">
          <div class="form-check form-switch mt-2">
            <input 
              class="form-check-input" 
              type="checkbox" 
              role="switch" 
              id="chkAnulada" 
              :true-value="1" 
              :false-value="0"
              v-model="form.estado"
              checked 
            >
            <label class="form-check-label" for="chkAnulada">Anulada</label>
          </div>
        </div>-->

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
          :disabled="btnGuardar || (this.pedido && (this.pedido.estado_pedido_id == 2 || this.pedido.estado_pedido_id == 3)) "
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

  <div 
    class="modal fade" id="mdlCliente"
    data-bs-backdrop="static" 
    data-bs-keyboard="false" 
    tabindex="-1" 
    aria-labelledby="staticBackdropLabel" 
    aria-hidden="true">

    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 
            class="modal-title fs-5" 
            id="staticBackdropLabel"
          > 
          <i class="fas fa-person-walking-luggage fa-sm me-1"></i>Cliente
          </h1>
          <button 
            type="button" 
            class="btn-close" 
            aria-label="Close" 
            @click="cerrarModal"
          >
          </button>
        </div>
        <div class="modal-body">
          <ClienteForm 
            v-if="verForm" 
            @cerrar="cerrarModal" 
            @actualizar="actualizaLista"
            :cliente="reg" 
          />          
        </div>
      </div>
    </div>
  </div>

</template>

<script>
  import Helper from '@/mixins/Helper.js';
  import ClienteForm from '@/views/mnt/Cliente/ClienteForm.vue'
  import { Modal } from 'bootstrap'

  export default {
    mixins: [Helper],
    props: {
      pedido: {
        type: Object,
        default: null
      },
      catPed: {
        type: Object,
        required: true,
      },
      correlativo: 0,
    },
    data: () => ({
      clientes: [],
      clienteComodin: 0,
      modal: null,
      verForm: false,
      reg: null,
    }),
    mounted() {
      this.modal = new Modal(document.getElementById('mdlCliente'));
    },
    created() {

      this.controlador = 'pedido/principal'
      this.autoBuscar = false
      this._emit = true

      if (this.catPed && this.catPed.parametros_sistema) {
        this.clienteComodin = this.catPed.parametros_sistema.find(x => x.nombre_parametro == "cliente_comodin_pedido").valor_parametro  
      }
      
      if (this.pedido !== null) {
        this.pedido.fecha_pedido = this.ObtenerFecha(this.pedido.fecha_pedido, 1)
        this.pedido.fecha_entrega = this.ObtenerFecha(this.pedido.fecha_entrega, 1)

        if (this.pedido.no_documento && !this.pedido.no_documento.includes("PED")) {
          let numeroFormateado = this.pedido.no_documento.toString().padStart(10, '0');
          this.pedido.no_documento =  `PED${numeroFormateado}`
        }

        this.setDatosForm(this.pedido)

      } else {
        let numeroFormateado = this.correlativo.toString().padStart(10, '0');

        this.fbase = {
          cliente_id: "",
          bodega_id: "",
          tipo_transaccion_id: 2,
          pedido_tipo_id: 1,
          motivo_anulacion_pedido_id: null,
          anulada: 0,
          detalle: [],
          estado: "NUEVO",
          fecha_pedido: new Date().toISOString().split('T')[0],
          hora_inicio: new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: false }),
          no_documento: `PED${numeroFormateado}`
        }
      }
    },
    methods: {
      abrirModal() {
      this.verForm = true
      this.modal.show()
      },
      cerrarModal() {
        this.reg = null
        this.verForm = false
        this.modal.hide()
      },
      actualizaLista(o, pk) {
        this.catPed.cliente.push({
          id: o.id,
          nombre_comercial: o.nombre_comercial
        });
        this.form.cliente_id = o.id;
      },
      ObtenerFecha(f, tipo){
        if (f) {
          var fecha = f.split(" ");

          switch(tipo){
            case 1:
              return fecha[0]
            case 2:
              return fecha[1]
          }
        }

        return ''
      },
      cambiarMotivo(event) {
        this.$emit('cambiarMotivoAnulacion', event.target.value);
      },
    },
    computed: {
      clientes() {

        return this.setDatoSelect(this.catPed.cliente, "id", "nombre_comercial")
      },
    },
    watch: {
      pedido(v) {
        v.fecha_pedido = this.ObtenerFecha(this.pedido.fecha_pedido, 1)
        v.fecha_entrega = this.ObtenerFecha(this.pedido.fecha_entrega, 1)

        this.setDatosForm(v)
      }
    },
    components:{
      ClienteForm
    }
  }
</script>