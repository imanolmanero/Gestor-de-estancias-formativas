<script setup>
import { computed } from 'vue'

const props = defineProps({
    alumno: Object
})

// Mapeo de nombres de campos a etiquetas amigables
const etiquetas = {
    'id_usuario': 'ID',
    'email': 'Email',
    'nombre': 'Nombre',
    'apellidos': 'Apellidos',
    'telefono': 'Teléfono',
    'grado': 'Grado',
    'familia': 'Familia Profesional',
    'codigo_grado': 'Código del Grado'
}

// Orden de visualización preferido
const ordenCampos = [
    'nombre',
    'apellidos', 
    'email',
    'telefono',
    'grado',
    'familia',
    'codigo_grado',
    'id_usuario'
]

// Computar los datos filtrados y ordenados
const datosFormateados = computed(() => {
    if (!props.alumno) return []
    
    const datos = []
    
    // Primero agregar los campos en el orden preferido
    ordenCampos.forEach(campo => {
        if (props.alumno[campo] !== undefined && props.alumno[campo] !== null) {
            datos.push({
                campo: campo,
                etiqueta: etiquetas[campo] || campo,
                valor: props.alumno[campo]
            })
        }
    })
    
    // Luego agregar cualquier otro campo que no esté en el orden
    Object.keys(props.alumno).forEach(campo => {
        if (!ordenCampos.includes(campo) && 
            props.alumno[campo] !== undefined && 
            props.alumno[campo] !== null) {
            datos.push({
                campo: campo,
                etiqueta: etiquetas[campo] || campo,
                valor: props.alumno[campo]
            })
        }
    })
    
    return datos
})
</script>

<template>
    <table class="table table-bordered">
        <tbody>
            <tr v-for="item in datosFormateados" :key="item.campo">
                <td class="campo-nombre"><b>{{ item.etiqueta }}:</b></td>
                <td class="campo-valor">{{ item.valor }}</td>
            </tr>
        </tbody>
    </table>
</template>

<style scoped>
.campo-nombre {
    width: 40%;
    background-color: #f8f9fa;
    font-weight: bold;
}

.campo-valor {
    width: 60%;
}

.table {
    margin-bottom: 0;
}
</style>