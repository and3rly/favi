<template>

  <template  v-if="recepcion.estado_recepcion_id == 6">
    <div class="alert alert-success text-center" role="alert"> 
      Recepción finalizada con éxito.
    </div>
  </template>

  <div class="row g-1 mb-3" v-else>
    <!--div class="col-sm-2">
      <label for="inputCantidad" class="form-label fw-bold">Cantidad</label>
      <input type="number" class="form-control" id="inputCantidad" :disabled="parseInt(recepcion.ingresa_productos) !== 1">
    </div-->
    <div class="col-sm-10">
      <label for="inputCodigo" class="form-label fw-bold">Código/Barra</label>
      <input 
        type="text" 
        class="form-control text-center" 
        id="inputCodigo" 
        :disabled="parseInt(recepcion.ingresa_productos) !== 1"
        v-model="codigo"
      >
    </div>
    <div class="col-sm-1 d-grid gap-2 text-center"><br>
      <button class="btn btn-secondary" title="Agregar producto" :disabled="parseInt(recepcion.ingresa_productos) !== 1" @click="getProducto">
        <i class="fas fa-plus"></i>
      </button>
    </div>
    <div class="col-sm-1 d-grid gap-2 text-center"><br>
      <button class="btn btn-lime" title="Buscar producto" @click="abrir">
        <i class="fas fa-search"></i>
      </button>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-sm table-hover table-bordered">
      <thead class="bg-light">
        <tr>
          <th>#</th>
          <th>Código</th>
          <th>Nombre</th>
          <th>Cantidad</th>
          <th>Fecha Vence</th>
          <th>Lote</th>
          <th>UM</th>
          <th>Estado</th>
          <th>Presentación</th>
          <th v-if="recepcion.estado_recepcion_id != 6"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(i, idx) in lista">
          <td>{{ i.no_linea }}</td>
          <td>{{ i.codigo_producto }}</td>
          <td>{{ i.nombre_producto }}</td>
          <td>
            <input 
              type="number" 
              class="form-control text-center" 
              v-model="i.cantidad_recibida"
            />
          </td>
          <td>
            <input 
              type="date" 
              class="form-control text-center"
              :class="i.control_vence == 1 && (i.fecha_vence == null || !i.fecha_vence) ? 'bg-danger bg-opacity-20': ''"
              v-model="i.fecha_vence"
              :disabled="i.control_vence == 0"
            />
          </td>
          <td>
            <input 
              type="text" 
              class="form-control text-center" 
              v-model="i.lote"
              required
            />
          </td>
          <td>
            <select 
              name="selectUm" 
              id="selectUm"
              class="form-select"
              v-model="i.unidad_medida_id" 
            >
              <option value=""></option>
              <option 
                v-for="(j, idx) in cat.um" 
                :value="j.id"
              >
                {{ j.nombre }}
              </option>
            </select>
          </td>
          <td>
            <select 
              name="selectUm" 
              id="selectUm"
              class="form-select"
              v-model="i.estado_producto_id" 
            >
              <option value=""></option>
              <option 
                v-for="(k, idx) in cat.estado_prod" 
                :value="k.id"
              >
                {{ k.nombre }}
              </option>
            </select>
          </td>
          <td>
            <select 
              name="selectUm" 
              id="selectUm"
              class="form-select"
              v-model="i.presentacion_producto_id" 
            >
              <option :value="null"></option>
              <option 
                v-for="(l, idx) in cat.presentacion.filter(e =>  {return e.producto_id == i.id_producto})" 
                :value="l.id"
              >
                {{ l.codigo }} - {{ l.factor}}
              </option>
            </select>
          </td>
          <td class="text-center" v-if="recepcion.estado_recepcion_id != 6">
            <a href="#" class="text-danger" title="Eliminar" @click="eliminar_producto(i,idx)">
              <i class="fas fa-trash"></i>
            </a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div 
    class="modal fade" 
    id="mdlProductos"
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
            <i class="fas fa-cubes-stacked  fa-sm me-2 ms-1"></i>Producto
          </h1>
          <button 
            type="button" 
            class="btn-close" 
            aria-label="Close"
            @click="cerrar"
          >
          </button>
        </div>
        <div class="modal-body">
          <table class="table table-sm table-hover table-bordered">
            <thead class="bg-light">
              <tr>
                <td colspan="100">
                  <input type="search" class="form-control" placeholder="Buscar..." v-model="termino">
                </td>
              </tr>
              <tr>
                <th>#</th>
                <th>Código</th>
                <th>Producto</th>
                <th>UM</th>
                <th>Marca</th>
                <th class="text-center" width="120">Cantidad</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(i, idx) in filtrada">
                <td>{{ idx + 1 }}</td> 
                <td>{{ i.codigo }}</td>
                <td>{{ i.descripcion }}</td>
                <td>{{ i.nombre_um }}</td>
                <td>{{ i.nombre_marca }}</td>
                <td class="text-center">
                  <input type="text" class="form-control text-center" v-model="i.cantidad" @change="agregarProducto(i)">
                </td>
                <td class="text-center">
                  <button class="btn btn-sm btn-lime" @click="agregarProducto(i)">
                    <i class="fas fa-plus"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div> 

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
            @click="cerrar"
          >
          </button>
        </div>
        <div class="modal-body">
          <FormOc
            :rec="recepcion"
            @actualizar="actualizarDetalle"
          ></FormOc>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import FormOc from "@/views/recepcion/FormOc.vue"

  export default {
    props: {
      detalle: {
        type: Array,
        required: true
      },
      cat: {
        type: Array,
        required: true
      },
      recepcion: {
        type: Object,
        required: true
      }
    },
    data: () => ({
      lista: [],
      producto: {
        presentacion_producto_id: null,
        unidad_medida_id: null,
        estado_producto_id: null,
        producto_bodega_id: null,
        control_vence: false,
        lote: null,
        fecha_vence: null,
        id: ""
      },
      codigo: "",
      termino: ""
    }),
    mounted() {
      if (this.recepcion != null) {

        if (parseInt(this.recepcion.ingresa_productos) == 1) {
          this.modal = new this.$modal(document.getElementById('mdlProductos'));
        } else {
          this.modal = new this.$modal(document.getElementById('mdlOc'));
        }
      }
    },
    created() {
      this.lista = this.detalle
    },
    methods: {
      agregarProducto(obj) {
        this.producto = {
          no_linea: this.detalle.length + 1,
          codigo_producto: obj.codigo,
          nombre_producto: obj.descripcion,
          cantidad_recibida: obj.cantidad,
          id_producto: obj.producto_id ,
          unidad_medida_id: obj.unidad_medida_id,
          estado_producto_id: obj.estado_producto_id,
          control_vence: obj.control_vence,
          id: "",
          recepcion_enc_id: this.recepcion.id,
          producto_bodega_id: obj.producto_bodega 
        }

        this.lista.push({ ...this.producto })

        this.codigo = ""
      },
      abrir() {
        this.modal.show()
      },
      cerrar() {
        this.modal.hide()
      },
      actualizarDetalle(detalle) {
        this.$emit("actualizarDet", detalle)
      },
      eliminar_producto(obj, idx) {
        if (confirm("¿Está seguro?")) {

          if (obj.id != "") {
            this.btnGuardar = true

            this.$http
            .post(`${this.$baseUrl}/recepcion/detalle/eliminar_producto/${obj.id}`)
            .then(res => {
              this.btnGuardar = false

              if (res.data.exito) { 
                this.lista.splice(idx, 1)
                this.$toast.success(res.data.mensaje)
              } else {
                this.$toast.error(res.data.mensaje)
              } 

            }).catch(e => {
              this.btnGuardar = false
              console.log(e)
            })   
          } else {
            this.lista.splice(idx, 1)
            this.$toast.success("Producto eliminado con éxito.")
          }
        } 
      },
      getProducto() {
        if (this.codigo !== "") {
          if (this.listaProductos.length > 0) {
            let tmp = this.listaProductos.filter(e => {
              return e.codigo.trim().toLowerCase() == this.codigo.trim().toLowerCase()
            })[0]

            if (tmp) {
              this.agregarProducto(tmp)
            }
          }
        } else {
          this.$toast.warning("Debe ingresar un código de producto")
        }
      }
    },
    computed: {
      listaProductos() {
        if (this.recepcion !== null && this.cat.productos) {
          return this.cat.productos.filter(e => {
            return e.bodega_id = this.recepcion.bodega_id
          })
        }

        return []
      },
      filtrada() {
        return this.listaProductos.filter(o => {
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
    watch: {
      detalle(v) {
        this.lista = v
      },
      recepcion(v) {
        if (parseInt(this.recepcion.ingresa_productos) == 1) {
          this.modal = new this.$modal(document.getElementById('mdlProductos'));
        } else {
          this.modal = new this.$modal(document.getElementById('mdlOc'));
        }
      }
    },
    components: {
      FormOc
    }
  }
</script> 