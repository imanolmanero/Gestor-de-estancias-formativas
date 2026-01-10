import axios from 'axios'

axios.defaults.baseURL = 'http://localhost:8000/api'
axios.defaults.headers.common['Accept'] = 'application/json'
axios.defaults.headers.common['Content-Type'] = 'application/json'

// Agregar token a las peticiones
const token = localStorage.getItem('token')
if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
}

export default axios