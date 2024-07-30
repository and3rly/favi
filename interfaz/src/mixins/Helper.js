import Catalogo from '@/mixins/Catalogo.js'

export default {
	name: 'Helper',
	mixins: [Catalogo],
	data: () => ({
		pk: '',
		fk: '',
		controlador: '',
		_key: 'id',
		nombreAccion: 'guardar',
		cargando: false,
		autoBuscar: true,
		btnGuardar: false,
		formEspecial: false,
		_updLista: false,
		inicio: false,
		_emit: false,
		tmpReg: null,
		modal: null,
		form: {},
		fbase: {},
		fbuscar: {},
		lista: [],
		cat: []
	}),
	mounted() {
		if (this.autoBuscar) {
			this.buscar()
		}

		this.form = {...this.form, ...this.fbase}
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
			.post(`${this.$baseUrl}/${this.controlador}/${this.nombreAccion}/${this.pk}`, datos)
			.then(result => {
				this.btnGuardar = false

				let res = result.data
				
				if (res.exito) {
					this.$toast.success(res.mensaje)

					if (this.pk == "") {
						this.limpiar()
					}

					if (this._emit) {
						if (this._updLista) {
							this.actLista(res.linea)
						}

						this.$emit('actualizar', res.linea)
					} else {
						if (res.linea) {
							this.actLista(res.linea);
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
			this.inicio = true
			
			this.$http
			.get(`${this.$baseUrl}/${this.controlador}/buscar`, {params: this.fbuscar})
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
		actLista(obj) {
			if (this.pk === "") {
				this.lista.push(obj)
			} else {
				let tmp = this.lista.filter(e => {										
					return e[this._key] == this.pk
				})[0];

				let idx = this.lista.indexOf(tmp)

				for (let i in obj) {
					this.lista[idx][i] = obj[i]
				}
			}
		},
		setDatosForm(obj) {
			this.pk = obj[this._key]

			for (let i in obj) {
				this.form[i] = obj[i]
			}
		},
		limpiar() {
			this.pk = ""
			this.form = {}
			this.form = {...this.form, ...this.fbase}
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