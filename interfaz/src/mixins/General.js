export default {
	name: 'General',
	data: () => ({
		pk: '',
		fk: '',
		cargando: false,
		autoBuscar: false,
		controlador: '',
		form: {},
		filtro: {},
		lista: [],
		cat: []
	}),
	mounted() {
		if (this.autoBuscar) {
			this.buscar()
		}
	},
	methods: {
		guardar() {

		},
		buscar() {
			this.cargando = true
			this.$http
			.get(`${this.$baseUrl}/${this.controlador}/buscar`, {params: this.filtro})
			.then(res => {
				this.cargando = false
				if (res.data.lista) {
					this.lista = res.data.lista
				}
			}).catch(e => {
				this.cargando = false
				console.log(e)
			})
		}
	}
}