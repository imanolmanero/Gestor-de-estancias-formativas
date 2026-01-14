<script setup>
const notas = [
    {nombre: 'DIW', nota:7},
    {nombre: 'DBEA', nota:10},
    {nombre: 'SI', nota:6},
    {nombre: 'DAW', nota:5},
    {nombre: 'DWEC', nota:4},
    {nombre: 'IPE2', nota:9},
    {nombre: 'DWES', nota:8},
    {nombre: 'FAFS', nota:''},
]
function mostrarDato(dato){
    if (dato == ''){
        return 'No hay nota'
    }
    return dato;
}

</script>
<template>
    <h1>Notas</h1>
    <table>
        <tbody>
            <tr v-for="asignatura in notas" :key="asignatura.nombre">
                <td><b>{{ asignatura.nombre }}: </b>{{ mostrarDato(asignatura.nota) }}</td>
            </tr>
        </tbody>
    </table>
    <button>Calcular nota</button>
</template>