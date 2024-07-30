import {defineStore} from 'pinia'
import axiosClient from "@/plugins/axios.js"

export const useLoginStore = defineStore('login', {
	state:() => ({
		token: localStorage.getItem('token'),
		usuario: JSON.parse(localStorage.getItem('usuario')),
		urlBase: ''
	}),
	persist: {
		key: 'session'
	},
	actions: {
		login(data) {
			return new Promise((resolve, reject) => {
				axiosClient.defaults.headers.common['usuario'] = data.usuario;
				axiosClient.defaults.headers.common['clave']   = data.clave;
				
				axiosClient.post(`${this.urlBase}/sesion/login`, data)
				.then(res => {

					if (res.data.exito) {
						this.usuario = res.data.usuario
						this.token = res.data.token
					}
					
					resolve(res.data);

				}).catch(e => {
					reject(e);
				});
			})	
		},
		async logout() {
			await axiosClient.post(`${this.urlBase}/sesion/logout`)
			.then (res => {
				if (res.data.exito) {
					this.token = null;
					this.usuario = null;

					delete axiosClient.defaults.headers.common['Authorization']
				}
			});
		},
		async validaToken () {
			const storeLogin = useLoginStore();

			if (this.token) {
				await axiosClient.post(`${this.urlBase}/sesion/validar_token`, {token: this.token})
				.then(res => {

					if (res.data.valido) {
						axiosClient.defaults.headers.common['Authorization'] = this.token;
					}

				}).catch(e => {
					if (e.response.data) {
						if (e.response.status == 401) {
							storeLogin.logout()
							delete axiosClient.defaults.headers.common['Authorization'];
						}
					}
				});
			}
		}
	},
	getters: {
		isLoggedIn: state => !!state.token
	}
})