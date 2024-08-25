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

        Despacho <span v-if="despacho !== null"> #{{ despacho.id }}</span>
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

  <template v-if="actual === 1">
    <Card class="mt-1">
      <form @submit.prevent="buscar" class="d-flex px-3 mt-3 mb-3">
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
        <div class="flex-fill me-1">
          <input 
            type="search" 
            class="form-control" 
            placeholder="Buscar por criterio..."
            v-model="bform.criterio"
          />
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
                <th>Bodega</th>
                <th>Transacción</th>
                <th>Estado</th>
                <th class="text-center">Hora inicio</th>
                <th class="text-center">Hora fin</th>
                <th class="text-center">Fecha</th>
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
                <td> {{ i.nombre_bodega }} </td>
                <td> {{ i.nombre_transaccion }} </td>
                <td>
                  <span 
                    :class="'badge bg-'+i.color+' bg-opacity-20 text-'+i.color+' fs-11px d-inline-flex align-items-center'"
                  >
                    <i 
                      :class="'fa fa-check-circle text-'+i.color+' fs-10px fa-fw me-1'"
                    ></i>{{ i.nombre_estado }}
                  </span>
                </td>
                <td class="text-center"> {{ i.hora_inicio }} </td>
                <td class="text-center"> {{ i.hora_fin }} </td>
                <td class="text-center">{{ formatoFecha(i.fecha_agr, 2)}}</td>
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

  <div v-else>
    <Despacho
      :despacho="despacho"
      @actualizar="actLista"
    />
  </div>
</template>

<script>
  import Despacho from "@/views/despacho/Despacho.vue"
  import Utileria from "@/mixins/Utileria.js"

  export default {
    name: "Principal",
    mixins: [Utileria],
    data: () => ({
      inicio: false,
      ud: false,
      oc: false,
      actual: 1,
      vista: 1,
      lista: [],
      pedidos: [],
      cat: [
      ],
      bform: {
        bodega_id: null
      },
      despacho: null,
      modal: null
    }),
    mounted() {
    },
    created() {
      this.bform.fdel = this.setFechaInicio()
      this.bform.fal = this.setFechaActual()

      this.getDatos()
      this.buscar()
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
      regresar() {
        this.actual = 1
        this.despacho = null
      },
      actLista(obj) {
        if (this.despacho === null) {
          this.lista.unshift(obj)
          this.despacho = obj

        } else {
          for (let i in this.despacho) {
            this.despacho[i] = obj[i]
          }
        }
      }
    },
    components: {
      Despacho
    }
  }
</script>