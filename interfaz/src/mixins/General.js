export default {
	name: 'General',
	data: () => ({
		pk: '',
		fk: '',
		cargando: false,
		autoBuscar: false,
		btnGuardar: false,
		tmpReg: null,
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
			this.btnGuardar = true

			this.$http
			.post(`${this.$baseUrl}/${this.controlador}/guardar/${this.pk}`, this.form)
			.then(res => {
				this.btnGuardar = false

				if (res.data.exito) {
					this.archivo = null

					if (res.data.linea) {
						this.$emit('actualizar', res.data.linea, this.pk)
						this.$emit('cerrar')
					}
					this.$toast.success(res.data.mensaje)
				} else {
					this.$toast.error(res.data.mensaje)
				}

			}).catch(e => {
				this.btnGuardar = false
				console.log(e)
			})
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
		},
		notificar(tipo, mensaje) {
			switch (tipo) {
				case 0:
					this.$toast.error(mensaje)
					break;
				case 1:
					this.$toast.success(mensaje)
					break;
			}
		},
		setDatosForm(reg) {
			for (let i in this.form) {
				this.form[i] = reg[i]
			}
		},
		setRegLista(o) {
			if (o.pk === '') {
				this.lista.push(o.linea)
			} else {
				for (let i in o.linea) {
					this.lista[o.idx][i] = o.linea[i]
				}
			}
		}
	}
}