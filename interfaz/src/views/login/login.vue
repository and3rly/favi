<template>
	<div class="container d-flex justify-content-center align-items-center min-vh-100">
		<div class="row border rounded-3 p-2 bg-white shadow box-area">
			<div 
				class="col-md-6 rounded-3 d-flex justify-content-center align-items-center flex-column left-box" 
				style="background: #ffff;"
			>
				<div class="featured-image mb-3">
					<img 
						src="@/assets/images/logo.jpg" 
						class="img-fluid" 
						style="width: 350px;"
					>
				</div>
			</div>
			<div class="col-md-6 right-box">
				<div class="row align-items-center">

					<div class="header-text mb-4">
						<h4 class="text-center mb-2">Iniciar Sesión</h4>
						<p class="text-center">POS - Facturación de Ventas e Inventario</p>
					</div>

          <form @submit.prevent="login">
            <div v-if="mensaje" class="alert alert-danger d-flex align-items-center py-2" role="alert">
            <i class="fa-solid fa-circle-exclamation me-1"></i> {{mensaje}} 
          </div>
  					<div class="input-group mb-3">
  						<input 
  							type="text" 
  							class="form-control form-control-md" 
  							placeholder="Usuario"
                v-model="form.usuario"
  						>
  					</div>
  					<div class="input-group mb-3">
  						<input 
  							type="password" 
  							class="form-control form-control-md" 
  							placeholder="Contraseña"
                v-model="form.clave"
  						>
  					</div>

  					<!--div class="input-group mb-5 d-flex justify-content-between">
  						<div class="form-check">
  							<input 
  								type="checkbox"
  								class="form-check-input"
  								id="formCheck"
  							>
  							<label 
  								for="formCheck" 
  								class="form-check-label mb-2"
  							>
  								<small>Mostar constraseña</small>
  							</label>
  						</div>
  					</div-->

  					<div class="input-group mb-2">
  						<button type="submit" class="btn btn-primary w-100">Iniciar</button>
  					</div>
  					<!--div class="text-center pb-0">
  						<small><a href="#">¿Olvidaste tu contraseña?</a></small>
  					</div-->
          </form>
				</div>
			</div> 
		</div>
	</div>
</template>

<script>
	import '@/assets/css/login.css'; 
  import { useLoginStore } from "@/stores/app-login";

	export default {
		name: 'Login',
    data() {
      return {
        mensaje: null,
        form: {}
      };
    },
    methods: {
      login() {
        const storeLogin = useLoginStore();

        storeLogin.login(this.form)
        .then(res => {
          if (storeLogin.isLoggedIn) {
            this.$router.push({name: "Inicio"});
            //this.$toast.success(res.mensaje , { timeout: 2000 });
          } else {
            this.mensaje = res.mensaje
          }
        })
      }
    }
	}
</script>