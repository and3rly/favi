<template>
  <div class="alert alert-info p-2 mb-3">
    <i class="fas fa-lightbulb me-1"></i> Seleccione un pedido para cargar su detalle.
  </div>

  <div class="table-responsive">
    <table class="table table-sm table-hover table-bordered">
      <thead class="bg-light">
        <tr>
          <th class="text-center">Id</th>
          <th class="text-center">Documento</th>
          <th>Bodega</th>
          <th>Cliente</th>
          <th class="text-center">Fecha Pedido</th>
          <th class="text-center">Fecha Creado</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(i, idx) in pedidos" style="cursor: pointer;" @click="$emit('agregar-detalle', i)">
          <td class="text-center">{{ i.id }}</td>
          <td class="text-center"> 
            <a href="#" title="Pedido">{{ i.no_documento }}</a>
          </td>
          <td>{{ i.nombre_bodega }}</td>
          <td>{{ i.nombre_cliente }}</td>
          <td class="text-center">{{ formatoFecha(i.fecha_pedido, 1) }}</td>
          <td class="text-center">{{ formatoFecha(i.fecha_agr, 2) }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
  import Utileria from "@/mixins/Utileria.js"

  export default {
    name: "Pedidos",
    emits: ["agregar-detalle"],
    mixins: [Utileria],
    data: () => ({
      pedidos: []
    }),
    created() {
      this.getPedidos()
    },
    methods: {
      getPedidos() {
        this.inicio = true

        this.$http
        .get(`${this.$baseUrl}/despacho/principal/get_pedidos`)
        .then(res => {

          this.inicio = false
          this.pedidos = res.data.lista

        }).catch(e => {
          this.inicio = false
          console.log(e)
        })
      },
    }
  }
</script>