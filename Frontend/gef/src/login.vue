<template>
    
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <img src="./assets/images/logo.jpg" class="btn-icon" alt="Logo de egibide">
                        
                        <form @submit.prevent="login">
                            <div class="mb-3">
                                <input 
                                    type="email" 
                                    v-model="email" 
                                    placeholder="Email" 
                                    class="form-control"
                                    required
                                >
                            </div>
                            
                            <div class="mb-3">
                                <input 
                                    type="password" 
                                    v-model="password" 
                                    placeholder="Contraseña" 
                                    class="form-control"
                                    required
                                >
                            </div>
                            
                            <button 
                                type="submit" 
                                class="btn btn-primary w-100"
                                :disabled="loading"
                            >
                                <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
                                {{ loading ? 'Cargando...' : 'Continuar' }}
                            </button>
                        </form>
                        
                        <div v-if="error" class="alert alert-danger mt-3 mb-0" role="alert">
                            {{ error }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    //libreria para conectar vue con la api
import axios from '@/axios' 

// exporta el componente para que vue use sus datos y metodos
export default {
    data() {
        return {
            email: '',
            password: '', 
            error: '',
            loading: false
        }
    },
    methods: {
        async login() {
            //para que se vea 'Cargando...' en el boton
            this.loading = true
            this.error = ''
            
            try {
                //espera a que le responda laravel para validar los datos
                const response = await axios.post('/login', {
                    email: this.email,
                    password: this.password  
                })
                //se guarda el token en local y le da acceso 
                if (response.data.access_token) {
                    localStorage.setItem('token', response.data.access_token)
                    this.$router.push('/dashboard')
                }
                
            } catch(err) {
                if (err.response?.status === 401) {
                    this.error = err.response.data.message
                } else {
                    this.error = 'Error al iniciar sesión'
                }
            } finally {
                this.loading = false
            }
        }
    }
}
</script>

<style scoped src="./assets/css/login.css"></style>