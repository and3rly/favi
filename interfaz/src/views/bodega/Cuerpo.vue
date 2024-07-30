<template>
  <template v-if="actual == 1">
    <div class="d-flex align-items-center mb-4">
      <h1 class="page-header mb-0">
        <i class="fas fa-home fa-sm me-2 ms-1"></i>Bodega
      </h1>

      <div class="ms-auto">
        <a href="#" class="btn btn-theme" @click="verBodega(null)">
          <i class="fa fa-plus-circle fa-fw me-2"></i> Nuevo
        </a>
      </div>
    </div>

    <Card class="mt-1">
      <CardBody class="p-0">
        <div class="input-group mt-3 mb-3 px-3">
          <div class="input-group">
            <input 
              type="text" 
              class="form-control ps-35px"
              placeholder="Buscar..." 
              v-model="termino"
              style="border-radius: 4px;" 
            />
            <div class="input-group-text position-absolute top-0 bottom-0 bg-none border-0" style="z-index: 1020;">
              <i class="fa fa-search opacity-5"></i>
            </div>
          </div>
        </div>

        <div v-if="inicio === true" class="text-center">
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
          <p>Cargando registros...</p>
        </div>

        <div v-else class="table-responsive">
          <table class="table table-sm table-hover table-striped m-0">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Código</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Encargado</th>
                <th>Empresa</th>
                <th class="text-center">Largo</th>
                <th class="text-center">Ancho</th>
                <th class="text-center">Alto</th>
                <th class="text-center">Estado</th>
              </tr>
            </thead>
            <tbody>
              <tr 
                v-for="(i, idx) in filtrada" 
                :key="idx"
                @click="verBodega(i)"
                style="cursor: pointer;"
              >
                <th class="text-center">{{ idx + 1 }}</th>
                <td class="text-center">{{ i.codigo }}</td>
                <td>
                  <a 
                    href="javascript:;"
                    @click="verBodega(i)"
                  >
                    {{ i.nombre }}
                  </a>
                </td>
                <td>{{ i.direccion }}</td>
                <td>{{ i.telefono }}</td>
                <td>{{ i.correo }}</td>
                <td>{{ i.encargado }}</td>
                <td>{{ i.nempresa }}</td>
                <td class="text-center">{{ i.largo }}</td>
                <td class="text-center">{{ i.ancho }}</td>
                <td class="text-center">{{ i.alto }}</td>
                <td class="text-center">
                  <span 
                    v-if="i.activo == 1"
                    class="badge bg-success text-success-800 bg-opacity-25 px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center"
                  >
                    <i class="fa fa-check-circle text-success fs-10px fa-fw me-5px"></i> Activo
                  </span>

                  <span 
                    v-else
                    class="badge bg-danger text-danger-800 bg-opacity-25 px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center"
                  >
                    <i class="fa fa-times-circle text-danger fs-10px fa-fw me-5px"></i> Inactivo
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </CardBody>
    </Card>
  </template>
  
  <Bodega 
    v-if="actual == 2"
    :bodega="reg"
    @actualizar="actualizaBodega"
    @regresar="actual = 1"
  />

</template>

<script>
  import Bodega from '@/views/bodega/Bodega.vue'

  export default {
    name: 'Cuerpo',
    data:() => ({
      inicio: false,
      lista: [],
      bform: {},
      actual: 1,
      reg: null,
      termino: ''
    }),
    created() {
      this.buscar()
    },
    methods: {
      buscar() {
        this.inicio = true

        this.$http
        .get(`${this.$baseUrl}/bodega/bodega/buscar`, {params: this.bform})
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
      verBodega(obj) {
        this.reg = obj
        this.actual = 2
      },
      actualizaBodega(obj) {
        if (this.reg === null) {
          this.lista.push(obj)
          this.reg = obj
        } else {
          for (let i in this.reg) {
            this.reg[i] = obj[i]
          }
        }
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
    },
    components: {
      Bodega
    }
  }
</script>