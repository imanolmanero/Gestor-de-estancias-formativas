<script setup>
import { ref, onMounted, computed } from 'vue'
import api from '@/services/api'

const props = defineProps({
    idAlumno: {
        type: Number,
        required: true
    }
});

const asignaturas = ref([])
const tecnicas = ref([])
const transversales = ref([])
const tieneEstancia = ref(false)

function mostrarDato(dato) {
    if (dato == null || dato === undefined) {
        return 'No hay nota'
    }
    return dato;
}

async function getNotas() {
    try {
        const response = await api.getNotas(props.idAlumno)
        asignaturas.value = response.data.asignaturas
        tecnicas.value = response.data.tecnicas
        transversales.value = response.data.transversales 
        tieneEstancia.value = response.data.tiene_estancia
    } catch (err) {
        console.error('Error al cargar notas:', err)
        asignaturas.value = []
        tecnicas.value = []
        transversales.value = []
    }
}

// Calcular nota promedio de competencias técnicas por asignatura
function getNotaTecnicaAsignatura(nombreAsignatura) {
    const resultados = tecnicas.value.filter(t => t.asignatura_nombre === nombreAsignatura)
    
    if (resultados.length === 0) return null
    
    const notasValidas = resultados.filter(r => r.nota !== null && r.nota !== undefined)
    if (notasValidas.length === 0) return null
    
    const promedio = notasValidas.reduce((sum, r) => sum + parseFloat(r.nota), 0) / notasValidas.length
    return promedio.toFixed(2)
}

// Calcular nota promedio de competencias transversales
const notaTransversalPromedio = computed(() => {
    if (transversales.value.length === 0) return null
    
    const notasValidas = transversales.value.filter(t => t.nota !== null && t.nota !== undefined)
    if (notasValidas.length === 0) return null
    
    const promedio = notasValidas.reduce((sum, t) => sum + parseFloat(t.nota), 0) / notasValidas.length
    return promedio.toFixed(2)
})

onMounted(() => {
    getNotas()
})
</script>

<template>
    <div>
        <h1>Notas</h1>
        
        <div v-if="!tieneEstancia" class="alert alert-warning mb-3">
            El alumno no tiene una estancia asignada. Las notas de empresa no están disponibles.
        </div>

        <table>
            <thead>
                <tr>
                    <th rowspan="2">Asignatura</th>
                    <th colspan="1">Centro</th>
                    <th colspan="2">Empresa</th>
                </tr>
                <tr>
                    <th>Nota Centro</th>
                    <th>Com. Técnicas</th>
                    <th>Com. Trans.</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="asignatura in asignaturas" :key="asignatura.id_asignatura">
                    <td>{{ asignatura.nombre }}</td>
                    <td>{{ mostrarDato(asignatura.nota) }}</td>
                    <td>{{ mostrarDato(getNotaTecnicaAsignatura(asignatura.nombre)) }}</td>
                    <td>{{ mostrarDato(notaTransversalPromedio * 2.5) }}</td>
                </tr>
                
                <tr v-if="asignaturas.length === 0">
                    <td colspan="4">No hay asignaturas para mostrar</td>
                </tr>
            </tbody>
        </table>

        

        
    </div>
</template>