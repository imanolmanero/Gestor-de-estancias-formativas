import { createRouter, createWebHistory } from 'vue-router'
import login from '../login.vue'
import principal from '../principal.vue'
const routes = [
    {
        path: '/',
        name: 'login',
        component: login
    },
    {
        path: '/alumno',
        name: 'principal',
        component: principal
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router