
export default function notificar(tipo, mensaje) {
	switch (tipo) {
		case 0:
			this.$toast.error(mensaje)
			break;
		case 1:
			this.$toast.success(mensaje)
			break;
	}
} 
