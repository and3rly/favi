export default {
	name: 'Catalogo',
    data: () => ({
		cat: {},
        args: {},
        ocupado: false,
        usuario: {}
	}),
	created () {
	},
	methods: {
		getCatalogo (lista) {
			this.ocupado = true
			this.$http
			.get(`${this.$baseUrl}/catalogo/ver_lista?format=json`, {params: {lista:lista, args: this.args}})
			.then(r => {
				if (r.data.exito) {
					this.ocupado = false
                    for (let i in r.data.lista) {
						this.cat[i] = r.data.lista[i]
                    }
				} else {
					alert(r.data.mensaje);
				}
			})
			.catch(e => {
				alert(e);
			});
		}
	}
}