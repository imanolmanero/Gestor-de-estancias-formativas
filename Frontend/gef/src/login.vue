<template>
    <div class="login-container">
        <h2>Inicio de Sesión</h2>
        <form @submit.prevent="login">
            <input type="email" v-model="email" placeholder="Email" required>
            <input type="password" v-model="password" placeholder="Contraseña" required>
            <button type="submit">Continuar</button>
        </form>
        <p v-if="error" class="error">{{ error }}</p>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    data() {
        return {
            email: '',
            password: '', 
            error: '',
        }
    },
    methods: {
        async login() {
            try {
                const response = await axios.post('http://localhost:8000/api/login', {
                    email: this.email,
                    password: this.password  
                })
                
                localStorage.setItem('token', response.data.access_token)  
                alert('¡Has iniciado sesión correctamente!')
                
            } catch(err) {
                this.error = err.response?.data?.message || 'Error al iniciar sesión'
                console.error(err)
            }
        }
    }
}
</script>

<style scoped>
.login-container {
    max-width: 400px;
    margin: 100px auto;
    padding: 30px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    border-radius: 8px;
    background: white;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

input {
    display: block;
    width: 100%;
    margin: 15px 0;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    box-sizing: border-box;
}

input:focus {
    outline: none;
    border-color: #4CAF50;
}

button {
    width: 100%;
    padding: 12px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
}

button:hover {
    background-color: #45a049;
}

.error {
    color: #f44336;
    text-align: center;
    margin-top: 15px;
    font-size: 14px;
}
</style>