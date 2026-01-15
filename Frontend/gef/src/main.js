import { createApp } from 'vue' //aplicacion vue
import App from './App.vue' //componente principal
import router from './router/index.js' 
import axios from './axios.js' //instancia personalizada

const app = createApp(App)
app.config.globalProperties.$axios = axios //axios en cualquier componente
app.use(router)
app.mount('#app') //donde muestra la aplicacion