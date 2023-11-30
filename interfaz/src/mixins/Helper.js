export default {
	name: 'General',
	data: () => ({
		pk: '',
		fk: '',
		controlador: '',
		cargando: false,
		autoBuscar: true,
		btnGuardar: false,
		formEspecial: false,
		_emit: false,
		tmpReg: null,
		modal: null,
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

			let datos = this.form

			if (this.formEspecial) {			
				for (let i in this.form) {
					datos.append(i, this.form[i]);
				}
			}

			this.$http
			.post(`${this.$baseUrl}/${this.controlador}/guardar/${this.pk}`, datos)
			.then(result => {
				this.btnGuardar = false

				let res = result.data

				if (res.exito) {
					this.$toast.success(res.mensaje)

					if (this._emit) {
						this.$emit('actualizar', res.linea)
					} else {
						if (res.linea) {
							if (this.pk === "") {
								this.lista.push(res.linea)
							} else {
								//Actualiza elemento de lista
							}
						}
					}
				} else {
					this.$toast.error(res.mensaje)
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