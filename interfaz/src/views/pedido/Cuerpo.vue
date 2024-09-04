<template>

  <div class="d-flex py-2">
    <div class="flex-fill me-1">
      <h1 class="page-header mb-1">
        <button
          v-if="actual == 2"
          type="button"
          class="btn btn-secondary me-1"
          @click="regresar"
        >
          <i class="fas fa-arrow-left"></i>
        </button>
        Pedido
        <span v-if="this.pedido !== null"> #{{ this.pedido.id }}</span>
      </h1>
    </div>

    <div class="flex-fill text-end">
      <button 
        v-if="actual === 1"
        class="btn btn-theme"
        @click="verPedido(null)"
      >
        <i class="fas fa-circle-plus me-2"></i>Nuevo
      </button> 
    </div>
  </div>

  <div class="mb-sm-3 mb-3 mt-2 d-sm-flex" v-if="pedido != null">
    <div class="mt-sm-0 me-3 mt-2" v-if="this.pedido.estado_pedido_id == 1 || this.pedido.estado_pedido_id == 4">
      <a
        href="javascript:;" 
        class="text-body text-decoration-none"
        @click="agregarDetalle"
      >
        <i class="fas fa-tasks fa-fw me-1 text-muted"></i> Agregar detalle
      </a>
    </div>
    <div class="mt-sm-0 me-3 mt-2" v-if="this.pedido.estado_pedido_id == 2">
      <i class="fas fa-tasks fa-fw me-1 text-muted"></i> Finalizado
    </div>
    <div class="mt-sm-0 me-3 mt-2" v-if="this.pedido.estado_pedido_id == 3">
      <i class="fas fa-tasks fa-fw me-1 text-muted"></i> Anulado
    </div>
    <div class="mt-sm-0 me-3 mt-2" v-if="this.pedido.estado_pedido_id == 1 || this.pedido.estado_pedido_id == 4">
      <a 
        href="javascript:;"  
        class="text-body text-decoration-none"
        @click="finalizarPedido"
      >
        <i class="fas fa-check fa-fw text-muted"></i> Finalizar
      </a>
    </div>
    <div class="mt-sm-0 me-3 mt-2" v-if="this.pedido.estado_pedido_id != 3">
      <a 
        href="javascript:;"  
        class="text-body text-decoration-none"
        @click="anularPedido"
      >
        <i class="fas fa-trash fa-fw text-muted"></i> Anular

      </a>
    </div>
    <div class="mt-sm-0 me-3 mt-2" v-if="this.pedido.estado_pedido_id == 2 || this.pedido.estado_pedido_id == 5">
      <a
        :href="`${this.$urlImp}/pedido/principal/imprimir/${pedido.id}`" target="_blank"
        class="text-body text-decoration-none"
      >
        <i class="fas fa-print fa-fw me-1 text-muted"></i> Imprimir
      </a>
    </div>
  </div>

  <template v-if="actual === 1">
    <Card class="mt-1">
      <form @submit.prevent="buscar" class="d-flex px-3 mt-3 mb-3">
        <div class="flex-fill me-1">
          <input 
            type="search" 
            class="form-control" 
            placeholder="Buscar por criterio..."
            v-model="bform.criterio"
          />
        </div>
        <div class="flex-fill me-1">
          <input 
            type="date" 
            class="form-control"
            v-model="bform.fdel"
          />
        </div>
        <div class="flex-fill me-1">
          <input 
            type="date" 
            class="form-control"
            v-model="bform.fal"
          />
        </div>
        <div class="flex-fill me-1">
          <select 
            name="selectBodega" 
            id="selectBodega"
            class="form-select" 
            v-model="bform.bodega_id"
          >
            <option :value="null">Seleccione una bodega...</option>
            <option v-for="i in cat.bodega" :value="i.id"> {{ i.nombre }} </option>
          </select>
        </div>
        <button
          class="btn btn-primary"
        >
          <i class="fas fa-search"></i>
        </button>
      </form>

      <CardBody>
        <div v-if="inicio === true" class="text-center">
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
          <p>Cargando registros...</p>
        </div>

        <div v-else class="table-responsive">
          <table class="table table-sm table-hover table-bordered m-0">
            <thead class="bg-light">
              <tr>
                <th class="text-center" width="50">#</th>
                <th class="text-center">No. Documento</th>
                <th class="text-center">Fecha Pedido</th>
                <th class="text-center">Hora inicio</th>
                <th class="text-center">Hora fin</th>
                <th>Bodega</th>
                <th>Transacción</th>
                <th>Tipo</th>
                <th class="text-center">Observación</th>
                <th class="text-center">Estado</th>
                <th class="text-center">Activo</th>
              </tr>
            </thead>
            <tbody>
              <tr 
                v-for="(i, idx) in lista" 
                :key="idx"
                style="cursor: pointer;"
                @click="verPedido(i)"
              > 
                <th class="text-center"> {{ idx + 1 }} </th>
                <td class="text-center"> {{ i.no_documento }} </td>
                <td class="text-center"> {{ formatoFecha(i.fecha_pedido,1) }} </td>
                <td class="text-center"> {{ i.hora_inicio }} </td>
                <td class="text-center"> {{ i.hora_fin }} </td>
                <td> {{ i.nombre_bodega }} </td>
                <td> {{ i.nombre_transaccion }} </td>
                <td> {{ i.nombre_pedido_tipo }} </td>
                <td> {{ i.observacion }} </td>
                <td class="text-center">
                  <span 
                    :class="'badge bg-'+i.color_estado+' bg-opacity-20 text-'+i.color_estado+' fs-11px d-inline-flex align-items-center'"
                  >
                    <i 
                      :class="'fa fa-check-circle text-'+i.color_estado+' fs-10px fa-fw me-1'"
                    ></i>{{ i.nombre_estado }}
                  </span>
                </td>
                <td class="text-center">
                  <i class="fas fa-check-circle text-success" v-if="i.activo == 1"></i>
                  <i class="fas fa-times-circle text-danger" v-else></i>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </CardBody>
    </Card>
  </template>

  <template v-else>
    <Card class="mt-2">
      <ul class="nav nav-tabs nav-tabs-v2 ps-4 pe-4">
        <li class="nav-item me-3">
          <a 
            href="#tab-bodega" 
            class="nav-link active" 
            data-bs-toggle="tab"
            @click="vista = 1"
          >
            <i class="fas fa-arrow-alt-circle-down me-1"></i>Encabezado
          </a>
        </li>
        <li class="nav-item me-3" v-if="pedido !== null">
          <a
            id="tab-detalle"
            href="#tab-det" 
            class="nav-link" 
            data-bs-toggle="tab"
            @click="vista = 2"
          >
            <i class="fas fa-list me-1"></i>Detalle
          </a>
        </li>
      </ul>
      <div class="tab-content p-3">
        <div 
          class="tab-pane fade show active" 
          id="tab-bodega"
        >
          <Form
            :pedido="pedido"
            :catPed="cat"
            :finalizado="finalizado"
            :correlativo="correlativo"
            @actualizar="actLista"
          ></Form>
        </div>
        <div 
          class="tab-pane fade"
          id="tab-det"
        >
          <Detalle
            v-if="vista === 2"
            :pedido="pedido"
            :cat="cat"
            :finalizado="finalizado"
            :ud="ud"
            @actualizar="actUd"
          ></Detalle>
        </div>

      </div>
    </Card>
  </template>
  <div 

        class="modal fade" 
        id="mdlOc"
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
                <i class="fas fa-indent me-1"></i> Stock Bodega
              </h1>
              <button 
                type="button" 
                class="btn-close" 
                aria-label="Close"
                @click="cerrarPed"
              >
              </button>
            </div>
            <div class="modal-body">
              <Stock
                v-if="ped"
                :pedido = "pedido"
                @actualizar="actUd"
              ></Stock>
            </div>
          </div>
        </div>
      </div>

</template>

<script>
  import Form from "@/views/pedido/Form.vue"
  import FormProd from "@/views/pedido/FormProd.vue"
  import Detalle from "@/views/pedido/Detalle.vue"
  import Stock from "@/views/pedido/Stock.vue"
  import Utileria from "@/mixins/Utileria.js"

  export default {
    name: "Pedido",
    mixins: [Utileria],
    data: () => ({
      inicio: false,
      ud: false,
      oc: false,
      actual: 1,
      vista: 1,
      lista: [],
      cat: [],
      bform: {},
      pedido: null,
      modal: null,
      ped: false,
      finalizado: false,
      correlativo: 0,
    }),
    mounted() {
      this.modal = new this.$modal(document.getElementById('mdlOc'));
    },
    created() {
      this.bform.fdel = this.setFechaInicio()
      this.bform.fal = this.setFechaActual()
      
      this.buscar()
      this.getDatos()
      this.bform.bodega_id = null
    }, 
    methods: {
      getDatos() {
        this.inicio = true

        this.$http
        .get(`${this.$baseUrl}/pedido/principal/get_datos`)
        .then(res => {

          this.inicio = false
          this.cat = res.data.cat

        }).catch(e => {
          this.inicio = false
          console.log(e)
        })
      },
      buscar() {
        this.inicio = true

        this.$http
        .get(`${this.$baseUrl}/pedido/principal/buscar`, {params: this.bform})
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
      verPedido(obj) {

        if (!obj) {
          this.$http
            .get(`${this.$baseUrl}/pedido/principal/obtenerUltimoPedido`)
            .then(res => {
              if (res.data.correlativo) {

                this.correlativo = parseInt(res.data.correlativo, 10);
                this.actual = 2;
                this.pedido = obj;

              }
            })
            .catch(e => {
              this.inicio = false;
              console.log(e);
            });
        } else {
          this.actual = 2;
          this.pedido = obj;
        }

      },
      actLista(obj) {
        if (this.pedido === null) {
          this.lista.push(obj)
          this.pedido = obj

        } else {
          for (let i in this.pedido) {
            this.pedido[i] = obj[i]
          }
        }
      },
      regresar() {
        this.actual    = 1
        this.vista     = null
        this.pedido = null
      },
      agregarDetalle() {
        this.ud = false
        this.ped = true

        let tab = document.getElementById("tab-detalle");
        tab.click();

        this.modal.show()
      },
      cerrarPed() {
        this.ped = false
        this.modal.hide()
      },
      actUd(v) {
        this.ud = v
      },
      finalizarPedido(){
        if (confirm("¿Está seguro?")) {

          this.$http
          .post(`${this.$baseUrl}/pedido/principal/finalizarPedido/${this.pedido.id}`)
          .then(res => {

            if (res.data.exito) {
              this.$toast.success(res.data.mensaje)
              this.pedido.estado_pedido_id = 2
              this.pedido.color_estado = "teal"
              this.pedido.nombre_estado = "Finalizado"
            } else {
              this.$toast.error(res.data.mensaje)
            } 

          }).catch(e => {
            this.btnGuardar = false
            console.log(e)
          })
        }
      },
      anularPedido(){
        if (confirm("¿Está seguro de anular el pedido?")) {

          if (this.pedido.motivo_anulacion_pedido_id == null) {
            this.$toast.error("Seleccione un motivo de anulación")
            let motAnulacion = document.getElementById("selectMotAnul");
            motAnulacion.focus();
          }else{
            this.$http
            .post(`${this.$baseUrl}/pedido/principal/anularPedido/${this.pedido.id}`)
            .then(res => {

              if (res.data.exito) {
                this.$toast.success(res.data.mensaje)
                this.pedido.estado_pedido_id = 3
                this.pedido.color_estado = "danger"
                this.pedido.nombre_estado = "Anulado"
              } else {
                this.$toast.error(res.data.mensaje)
              } 

            }).catch(e => {
              this.btnGuardar = false
              console.log(e)
            })
          }
          
        }
      },
    },
    components: {
      Form,
      FormProd,
      Detalle,
      Stock
    }
  }
</script>