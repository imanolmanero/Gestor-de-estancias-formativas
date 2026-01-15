import axios from 'axios'
//crea la instancia para conectar con la api
const instance = axios.create({
    baseURL: 'http://localhost:8000/api',
    whitCredentials: true,
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }
})
//antes de cada peticion http
instance.interceptors.request.use(
    config => {
        //confirma que tenga el token de autenticaccion
        const token = localStorage.getItem('token')
        if (token) {
            config.headers.Authorization = `Bearer ${token}`
        }
        return config
    },
    error => {
        return Promise.reject(error)
    }
)


export default instance