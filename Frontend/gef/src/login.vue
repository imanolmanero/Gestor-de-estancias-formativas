<template>
    <div>
        <h2>Inicio de Sesion</h2>
        <form @submit.prevent="login">
            <input type="email" v-model="email" placeholder="Email">
            <input type="password" v-model="password" placeholder="Contraseña">
            <button type="submit">Continuar</button>
        </form>
        <p v-if="error"> {{ error }}</p>
    </div>
</template>

<script>
    import axios from 'axios'

    export default{
        data() {
            return {
                email: '',
                contraseña: '',
                error: '',
            }
        },
        methods: {
            async login(){
                try{
                    const response = await axios.post ('http://localhost:8000/api/login', {
                        email: this.email,
                        contraseña: this.contraseña
                    })
                    localStorage.setItem('token', response.data.acces_token)
                    alert('Has iniciado sesion correctamente!')
                }catch(err){
                    this.error = err.response.data.message ||'Error al iniciar sesion'
                }
            }
        }
    }
</script>