export default {
	name: 'General',
	data: () => ({
		pk: '',
		fk: '',
		termino: '',
		controlador: '',
		cargando: false,
		autoBuscar: false,
		btnGuardar: false,
		tmpReg: null,
		modal: null,
		form: {},
		filtro: {},
		lista: [],
		cat: [],
		fdata: new FormData()
	}),
	mounted() {
		if (this.autoBuscar) {
			this.buscar()
		}
	},
	methods: {
		guardar(archivo = false) {
			this.btnGuardar = true

			if (archivo) {			
				for (let i in this.form) {
					this.fdata.append(i, this.form[i]);
				}
			}

			this.$http
			.post(`${this.$baseUrl}/${this.controlador}/guardar/${this.pk}`, this[archivo ? 'fdata': 'form'])
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
					this.filtrada[o.idx][i] = o.linea[i]
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
	}
}