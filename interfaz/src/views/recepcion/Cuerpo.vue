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

        Recepción
      </h1>
    </div>

    <div class="flex-fill text-end">
      <button 
        v-if="actual === 1"
        class="btn btn-theme"
        @click="verRecepcion(null)"
      >
        <i class="fas fa-circle-plus me-2"></i>Nuevo
      </button> 
    </div>
  </div>

  <div class="mb-sm-3 mb-3 mt-2 d-sm-flex" v-if="recepcion != null">
    <div class="mt-sm-0 me-3 mt-2">
      <a
        href="javascript:;" 
        class="text-body text-decoration-none"
        @click="agregarDetalle"
      >
        <i class="fas fa-tasks fa-fw me-1 text-muted"></i> Agregar detalle
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
                <th class="text-center" width="50">Id</th>
                <th class="text-center" width="120">Fecha recepción</th>
                <!--th class="text-center">Hora inicio</th-->
                <!--th class="text-center">Hora fin</th-->
                <th>Bodega</th>
                <th>Transacción</th>
                <th>Estado</th>
                <th>No. Guía</th>
                <th>Observación</th>
                <th class="text-center">Ingresa Stock</th>
                <th class="text-center">Anulada</th>
                <th class="text-center">Activo</th>
              </tr>
            </thead>
            <tbody>
              <tr 
                v-for="(i, idx) in lista" 
                :key="idx"
                style="cursor: pointer;"
                @click="verRecepcion(i)"
              > 
                <th class="text-center"> {{ i.id }} </th>
                <td class="text-center"> {{ formatoFecha(i.fecha_recepcion,1) }} </td>
                <!--td class="text-center"> {{ i.hora_inicio }} </td-->
                <!--td class="text-center"> {{ i.hora_fin }} </td-->
                <td> {{ i.nombre_bodega }} </td>
                <td> {{ i.nombre_transaccion }} </td>
                <td> 
                  <span 
                    :class="'badge bg-'+i.nombre_color+' bg-opacity-20 text-'+i.nombre_color+' fs-11px d-inline-flex align-items-center'"
                  >
                    <i 
                      :class="'fa fa-check-circle text-'+i.nombre_color+' fs-10px fa-fw me-1'"
                    ></i>{{ i.nombre_estado }}
                  </span>
                </td>
                <td>{{ i.no_guia }}</td>
                <td>{{ i.observacion }}</td>
                <td class="text-center">
                  <i class="fas fa-check-circle text-success" v-if="i.ingresa_stock == 1"></i>
                  <i class="fas fa-times-circle text-danger" v-else></i>
                </td>
                <td class="text-center">
                  <i class="fas fa-check-circle text-success" v-if="i.anulada == 1"></i>
                  <i class="fas fa-times-circle text-danger" v-else></i>
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
        <li class="nav-item me-3" v-if="recepcion !== null">
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
            :recepcion="recepcion"
            :cat="cat"
            @actualizar="actLista"
          ></Form>
        </div>
        <div 
          class="tab-pane fade"
          id="tab-det"
        >
          <Detalle
            v-if="vista === 2"
            :recepcion="recepcion"
            :cat="cat"
            :ud="ud"            
            @act-rec="actualizarRec"
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
            <i class="fas fa-indent me-1"></i> Orden de compra
          </h1>
          <button 
            type="button" 
            class="btn-close" 
            aria-label="Close"
            @click="cerrarOc"
          >
          </button>
        </div>
        <div class="modal-body">
          <FormOc
            v-if="oc"
            :rec="recepcion"
            @actualizar="actUd"
          ></FormOc>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
  import Form from "@/views/recepcion/Form.vue"
  import FormOc from "@/views/recepcion/FormOc.vue"
  import Detalle from "@/views/recepcion/Detalle.vue"
  import Utileria from "@/mixins/Utileria.js"

  export default {
    name: "Recepcion",
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
      recepcion: null,
      modal: null
    }),
    mounted() {
      this.modal = new this.$modal(document.getElementById('mdlOc'));
    },
    created() {
      this.buscar()
      this.getDatos()
    }, 
    methods: {
      getDatos() {
        this.inicio = true

        this.$http
        .get(`${this.$baseUrl}/recepcion/principal/get_datos`)
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
        .get(`${this.$baseUrl}/recepcion/principal/buscar`, {params: this.bform})
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
      verRecepcion(obj) {
        this.actual = 2
        this.recepcion = obj
      },
      actLista(obj) {
        if (this.recepcion === null) {
          this.lista.push(obj)
          this.recepcion = obj

        } else {
          for (let i in this.recepcion) {
            this.recepcion[i] = obj[i]
          }
        }
      },
      regresar() {
        this.actual    = 1
        this.vista     = null
        this.recepcion = null
      },
      agregarDetalle() {
        this.ud = false
        this.oc = true

        let tab = document.getElementById("tab-detalle");
        tab.click();

        this.modal.show()
      },
      cerrarOc() {
        this.oc = false
        this.modal.hide()
      },
      actUd(v) {
        this.ud = v
      },
      actualizarRec(e) {
        if (this.recepcion !== null) {
          this.recepcion.estado_recepcion_id = e
        }
      }
    },
    components: {
      Form,
      FormOc,
      Detalle
    }
  }
</script>