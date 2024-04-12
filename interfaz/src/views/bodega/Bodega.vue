<template>
  <ul class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="#">Bodega</a></li>
    <li class="breadcrumb-item active">Configuración</li>
  </ul>
  <nav 
      class="navbar navbar-expand-lg navbar-light"
    >
      <button 
        class="navbar-toggler" 
        type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#navbarLight"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarLight">
        <div class="mt-2">
          <button 
            class="btn btn-secondary me-2"
            @click="$emit('regresar')"
          >
            <i class="fas fa-arrow-left"></i>
          </button>
          <a class="navbar-brand fw-bold" href="#">
            <span> {{ bodega != null ? 'Bodega ' + bodega.nombre : 'Nueva bodega'}}</span>
          </a>
        </div>
      </div>
    </nav>

    <Card class="mt-2">
      <ul class="nav nav-tabs nav-tabs-v2 ps-4 pe-4">
        <li class="nav-item me-3">
          <a 
            href="#tab-bodega" 
            class="nav-link active" 
            data-bs-toggle="tab"
            @click="vista = 1"
          >
            <i class="fas fa-store me-1"></i>Bodega
          </a>
        </li>
        <template v-if="bodega != null">
          <li class="nav-item me-3">
            <a 
              href="#tab-area" 
              class="nav-link" 
              data-bs-toggle="tab"
              @click="vista = 2"
            >
              <i class="fas fa-chart-area me-1"></i>Área
            </a>
          </li>
          <li class="nav-item me-3">
            <a 
              href="#tab-sector" 
              class="nav-link" 
              data-bs-toggle="tab"
              @click="vista = 3"
            >
              <i class="fas fa-vector-square me-1"></i>Sector
            </a>
          </li>
          <li class="nav-item me-3">
            <a 
              href="#tab-tramo" 
              class="nav-link" 
              data-bs-toggle="tab"
              @click="vista = 4"
            >
              <i class="fas fa-road me-1"></i>Tramo
            </a>
          </li>
          <li class="nav-item me-3">
            <a 
              href="#tab-ubicacion" 
              class="nav-link" 
              data-bs-toggle="tab"
              @click="vista = 5"
            >
              <i class="fas fa-location-dot me-1"></i>Ubicación
            </a>
          </li>
        </template>
      </ul>
      <div class="tab-content p-3">
        <div 
          class="tab-pane fade show active" 
          id="tab-bodega"
        >
          <FormBodega
            v-if="vista == 1"
            :cat="cat"
            :bodega="bodega"
            @actualizar="actualizaBodega"
          />
        </div>
        <div 
          class="tab-pane fade"
          id="tab-area"
        >
          <FormArea
            v-if="vista == 2"
            :bodega="bodega"
            @actualizar="actualizaCat"
          />
        </div>
        <div 
          class="tab-pane fade"
          id="tab-sector"
        >
          <FormSector
            v-if="vista == 3"
            :bodega="bodega"
            :cat="cat"
            @actualizar="actualizaCat"
          />
        </div>
        <div 
          class="tab-pane fade"
          id="tab-tramo"
        >
          <FormTramo
            v-if="vista == 4"
            :bodega="bodega"
            :cat="cat"
            @actualizar="actualizaCat"
          />
        </div>
        <div 
          class="tab-pane fade"
          id="tab-ubicacion"
        >
          <FormUbicacion
            v-if="vista == 5"
            :bodega="bodega"
            :cat="cat"
            @actualizar="actualizaCat"
          />
        </div>
      </div>
    </Card>
</template>

<script>
  import FormBodega from '@/views/bodega/FormBodega.vue'
  import FormArea from '@/views/bodega/FormArea.vue'
  import FormSector from '@/views/bodega/FormSector.vue'
  import FormTramo from '@/views/bodega/FormTramo.vue'
  import FormUbicacion from '@/views/bodega/FormUbicacion.vue'

  export default {
    name:"Bodega",
    props: {
      bodega: {
        type: Object,
        required: false,
        default: null
      }
    },
    data:() => ({
      cat: {
        empresas: [],
        areas: [],
        sectores: [],
        tramos: []
      },
      fbuscar: {},
      vista: 1
    }),
    created() {
      this.fbuscar.bodega_id = this.bodega != null ? this.bodega.id : -1
      this.getDatos()
    },
    methods: {
      getDatos() {
        this.inicio = true

        this.$http
        .get(`${this.$baseUrl}/bodega/bodega/get_datos`, { params: this.fbuscar })
        .then(result => {
          this.inicio = false

          let res = result.data.cat
          this.cat.empresas = res.empresas
          this.cat.areas = res.areas ? res.areas : []
          this.cat.sectores = res.sectores ? res.sectores : []
          this.cat.tramos = res.tramos ? res.tramos : []
          this.cat.rotacion = res.rotacion ? res.rotacion : []

        }).catch(e => {
          this.inicio = false
          console.log(e)
        })
      },
      actualizaBodega(obj) {
        this.$emit("actualizar", obj)
        this.fbuscar.bodega_id = obj.id
        this.getDatos()
      },
      actualizaCat(obj) {
        if (this.vista == 2) {
          this.setCatalogo('areas', obj)

        } else if (this.vista == 3) {
          this.setCatalogo('sectores', obj)

        } else if (this.vista == 4) {
          this.setCatalogo('tramos', obj)
        }
      },
      setCatalogo(catalogo, obj) {
        let tmp = this.cat[catalogo].filter(e => {                    
          return e.id == obj.id
        })[0];

        if (tmp) {
          let idx = this.cat[catalogo].indexOf(tmp)
          for (let i in obj) {
            this.cat[catalogo][idx][i] = obj[i]
          }         
        } else {
          this.cat[catalogo].push(obj)
        }
      }
    },
    components: {
      FormBodega,
      FormArea,
      FormSector,
      FormTramo,
      FormUbicacion
    }
  }
</script>
