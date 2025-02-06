<template>
  <div class="mb-sm-3 mb-3 mt-2 d-sm-flex" v-if="despacho != null">
    
    <div class="mt-sm-0 me-3 mt-2" v-if="this.despacho.estado_despacho_id == 4">
      <a
        :href="`${this.$urlImp}/despacho/principal/imprimir/${despacho.id}`" target="_blank"
        class="text-body text-decoration-none"
      >
        <i class="fas fa-print fa-fw me-1 text-muted"></i> Imprimir
      </a>
    </div>

    <div class="mt-sm-0 me-3 mt-2" v-if="despacho.estado_despacho_id != 4">
      <a 
        href="javascript:;"  
        class="text-body text-decoration-none"
        @click="guardarDetalle"
      >
        <i class="fas fa-check fa-fw text-muted"></i> Despachar
      </a>
    </div>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <ul class="nav nav-tabs nav-tabs-v2 ps-4 pe-4">
        <li class="nav-item me-3">
          <a 
            href="#tab-bodega" 
            class="nav-link active" 
            data-bs-toggle="tab"
          >
            <i class="fas fa-arrow-alt-circle-down me-1"></i>Encabezado
          </a>
        </li>
        <li class="nav-item me-3">
          <a
            id="tab-detalle"
            href="#tab-det" 
            class="nav-link" 
            data-bs-toggle="tab"
            @click="getDetalle"
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
            :despacho="despacho"
            @actualizar="actLista"
          ></Form>
        </div>
        <div 
          class="tab-pane fade"
          id="tab-det"
        > 
          <div class="text-end">
            <button class="btn btn-primary mb-3" @click="abrirModal">
              <i class="fas fa-plus"></i> Agregar pedido
            </button>
          </div>
          <div class="table-responsive">
            <div class="table-responsive">
              <table class="table table-sm table-hover table-bordered">
                <thead class="bg-light">
                  <tr>
                    <th class="text-center" width="100">No. Línea</th>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Estado</th>
                    <th width="150">Cantidad</th>
                    <th width="150">Precio</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(i, idx) in detalle">
                    <td class="text-center">{{ idx + 1 }}</td>
                    <td>{{ i.codigo_producto }}</td>
                    <td>{{ i.nombre_producto }}</td>
                    <td>{{ i.nombre_estado_producto }}</td>
                    <td>
                      <input type="number" class="form-control text-center" v-model="i.cantidad_despachada">
                    </td>
                    <td>{{ i.precio }}</td>
                    <td>{{ i.total }}</td>
                  </tr>
                </tbody>
              </table>

              <div class="d-flex justify-content-end mt-3">
                <table class="table table-borderless mt-3 float-right" style="width: auto;">
                  <tbody>
                    <tr>
                      <td class="text-right font-weight-bold">
                        <h4>Total:</h4>
                      </td>
                      <td class="text-center">
                        <h4>{{ totalGeneral }}</h4>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>  
  </div>

  <div 
    class="modal fade" 
    id="mdlPedidos"
    data-bs-backdrop="static" 
    data-bs-keyboard="false" 
    tabindex="-1" 
    aria-labelledby="staticBackdropLabel" 
    aria-hidden="true">

    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 
            class="modal-title fs-5" 
            id="staticBackdropLabel"
          > 
            <i class="fas fa-indent me-1"></i> Pedidos
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
          <Pedido v-if="verPedidos == true" @agregar-detalle="setDetalle"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Form from "@/views/despacho/Form.vue"
  import Pedido from "@/views/despacho/Pedido.vue"

  export default {
    emits: ["actualizar"],
    props: {
      despacho: {
        type: Object,
        default: null
      }
    },
    data: () => ({
      pedidos: [],
      modal: null,
      verPedidos: false,
      detalle: [], 
      tmp: null
    }),
    mounted() {
      this.modal = new this.$modal(document.getElementById('mdlPedidos'))
    },
    created() {
      this.tmp = this.despacho
    },
    computed: {
      totalGeneral() {
        const total = this.detalle.reduce((acc, item) => acc + (parseFloat(item.total) || 0), 0);
        const formatoQ = new Intl.NumberFormat('es-GT', {
          style: 'currency',
          currency: 'GTQ',
          minimumFractionDigits: 2
        }).format(total);
        return `${formatoQ}`;
      },
    },
    methods: {
      abrirModal() {
        this.verPedidos = true
        this.modal.show()
      },
      cerrarModal() {
        this.verPedidos = false
        this.modal.hide()
      },
      actLista(obj) {
        this.$emit("actualizar", obj)
      },
      getDetalle() {
        this.vista = 2
        this.inicio = true
        
        let datos = {
          despacho_enc_id: this.despacho.id
        }

        this.$http
        .get(`${this.$baseUrl}/despacho/detalle/buscar`, {params: datos})
        .then(res => {
          this.inicio = false
          if (res.data.lista) {
            this.detalle = res.data.lista
          }
        }).catch(e => {
          this.inicio = false
          console.log(e)
        })
      },
      setDetalle(obj) {
        if (obj) {
          obj.detalle.forEach(e => {
            let datos = {
              despacho_enc_id: this.despacho.id,
              no_linea: e.no_linea,
              codigo_producto: e.codigo_producto,
              nombre_producto: e.nombre_producto,
              nombre_estado_producto: e.nombre_estado_producto,
              cantidad_despachada: e.cantidad,
              peso_despachado: e.peso,
              pedido_enc_id: e.pedido_enc_id,
              pedido_det_id: e.id,
              producto_bodega_id: e.producto_bodega_id,
              presentacion_producto_id: e.presentacion_producto_id,
              unidad_medida_id: e.unidad_medida_id,
              estado_producto_id: e.estado_producto_id,
              precio : e.precio,
              total : e.cantidad * e.precio
            }

            this.detalle.push(datos)
          })
        }
      },
      guardarDetalle() {
        this.btnGuardar = true

        if (this.detalle.length == 0) {
          this.$toast.warning("Despacho sin detalle.")
          return 
        }


        if (confirm("¿Está seguro?")) {
          let datos = {
            detalle: this.detalle, 
            despacho: this.despacho
          }

          this.$http
          .post(`${this.$baseUrl}/despacho/detalle/guardar`, datos)
          .then(result => {
            this.btnGuardar = false
            let r = result.data

            this.$emit("actualizar", r.despacho)
            this.$toast.success(r.mensaje)

          }).catch(e => {
            this.btnGuardar = false
            console.log(e)
          })
        }
      },
    },
    components: {
      Form,
      Pedido
    }
  }
</script>