<script setup>
import { ref, defineAsyncComponent } from 'vue'
const Alumno = defineAsyncComponent(()=>import('./alumno/alumno.vue'));
const Crear = defineAsyncComponent(()=>import('./crear/crear.vue'));
const vistaActiva = ref(null)
function cambiar(vista){
    vistaActiva.value = vistaActiva.value === vista ? null : vista;
}
</script>
<template>
    <nav>
        <button @click="cambiar('alumno')">Info de alumno</button>
        <button @click="cambiar('crear')">Crear</button>
    </nav>
    <main>
        <Alumno v-if="vistaActiva === 'alumno'"/>
        <Crear v-if="vistaActiva === 'crear'"/>
    </main>
</template>