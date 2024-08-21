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

        Despacho
      </h1>
    </div>

    <div class="flex-fill text-end">
      <button 
        v-if="actual === 1"
        class="btn btn-theme"
        @click="verDespacho(null)"
      >
        <i class="fas fa-circle-plus me-2"></i>Nuevo
      </button> 
    </div>
  </div>

  <div class="mb-sm-3 mb-3 mt-2 d-sm-flex" v-if="despacho != null">
    <div class="mt-sm-0 me-3 mt-2">
      <a
        href="javascript:;" 
        class="text-body text-decoration-none"
        @click="agregarDetalle"
      >
        <i class="fas fa-tasks fa-fw me-1 text-muted"></i> Agregar pedido
      </a>
    </div>
    <div class="mt-sm-0 me-3 mt-2">
      <a 
        href="javascript:;"  
        class="text-body text-decoration-none"
      >
        <i class="fas fa-check fa-fw text-muted"></i> Finalizar
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
                <th class="text-center">Fecha despacho</th>
                <th class="text-center">Hora inicio</th>
                <th class="text-center">Hora fin</th>
                <th>Bodega</th>
                <th>Transacción</th>
                <th>Estado</th>
                <th class="text-center">Activo</th>
              </tr>
            </thead>
            <tbody>
              <tr 
                v-for="(i, idx) in lista" 
                :key="idx"
                style="cursor: pointer;"
                @click="verDespacho(i)"
              > 
                <th class="text-center"> {{ i.id }} </th>
                <td class="text-center"> {{ formatoFecha(i.fecha_agr,1) }} </td>
                <td class="text-center"> {{ i.hora_inicio }} </td>
                <td class="text-center"> {{ i.hora_fin }} </td>
                <td> {{ i.nombre_bodega }} </td>
                <td> {{ i.nombre_transaccion }} </td>
                <td class="text-center"> {{ i.estado }} </td>
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
        <li class="nav-item me-3" v-if="despacho !== null">
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
        </div>
        <div 
          class="tab-pane fade"
          id="tab-det"
        >
        </div>
      </div>
    </Card>
  </template>
</template>

<script>
  import Utileria from "@/mixins/Utileria.js"

  export default {
    name: "Despacho",
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
      despacho: null,
      modal: null
    }),
    mounted() {
    },
    created() {
      this.buscar()
      this.getDatos()
    }, 
    methods: {
      getDatos() {
        this.inicio = true

        this.$http
        .get(`${this.$baseUrl}/despacho/principal/get_datos`)
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
        .get(`${this.$baseUrl}/despacho/principal/buscar`, {params: this.bform})
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
      verDespacho(obj) {
        this.actual = 2
        this.despacho = obj
      },
      actLista(obj) {
        if (this.despacho === null) {
          this.lista.push(obj)
          this.despacho = obj

        } else {
          for (let i in this.despacho) {
            this.despacho[i] = obj[i]
          }
        }
      },
      regresar() {
        this.actual    = 1
        this.vista     = null
        this.despacho = null
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
      }
    },
    components: {
    }
  }
</script>