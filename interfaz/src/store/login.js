import {defineStore} from 'pinia'
import axiosClient from "@/plugins/axios.js" 

export const useLoginStore = defineStore({
	id: 'login',
	state:() => ({
		token: localStorage.getItem('token'),
		usuario: JSON.parse(localStorage.getItem('usuario'))
	}),
	share: {
    enable: true,
    initialize: true,
  },
  persist: true,
	actions: {
		login(data) {
			return new Promise((resolve, reject) => {
				axiosClient.defaults.headers.common['usuario'] = data.usuario;
				axiosClient.defaults.headers.common['clave']   = data.clave;

				axiosClient.post("/api/index.php/sesion/login", data)
				.then(res => {

					if (res.data.exito) {
						this.usuario = res.data.usuario
						this.token = res.data.token

						localStorage.setItem('usuario', JSON.stringify(res.data.usuario));
						localStorage.setItem('token', res.data.token);
					}
					
					resolve(res.data);

				}).catch(e => {
					reject(e);
				});
			})	
		},
		async logout() {
			await axiosClient.post("/api/index.php/sesion/logout")
			.then (res => {
				if (res.data.exito) {
					this.token = null;
					this.usuario = null;

					localStorage.removeItem('usuario');
					localStorage.removeItem('token');

					delete axiosClient.defaults.headers.common['Authorization']
				}
			});
	},
	},
	getters: {
		isLoggedIn: state => !!state.token
	}
})