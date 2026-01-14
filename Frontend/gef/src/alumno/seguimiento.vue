<script setup>
import {ref} from 'vue'
const seguimientos = ref([
    {
        dia: '2025-01-10',
        hora: '09:30',
        accion: 'Reunión inicial con el tutor',
        receptor: 'Tutor centro',
        emisor: 'Alumno',
        medio: 'EN_PERSONA',
        editando: false
    },
    {
        dia: '2025-01-18',
        hora: '12:00',
        accion: '',
        receptor: 'Tutor empresa',
        emisor: 'Tutor centro',
        medio: 'EMAIL',
        editando: false
    },
    {
        dia: '2025-01-25',
        hora: '16:45',
        accion: 'Llamada para resolver dudas',
        receptor: 'Tutor empresa',
        emisor: 'Alumno',
        medio: 'TELEFONO',
        editando: false
    }
])

function mostrarDato(dato){
    if (dato == ''){
        return 'No hay registros';
    }
    return dato;
}

function editar(seguimiento){
    seguimiento.editando = true
}

function guardar(seguimiento){
    seguimiento.editando = false
}

function eliminar(index){
    seguimientos.value.splice(index,1)
}

function crearSeguimiento(){
    const nuevo = {
        dia: '',
        hora: '',
        accion: '',
        receptor: 'Alumno',
        emisor: 'Alumno',
        medio: 'EMAIL',
        editando: true 
    }

    seguimientos.value.push(nuevo)
}

</script>
<template>
    <h1>Seguimiento</h1>

    <button @click="crearSeguimiento">Nuevo seguimiento</button>

    <div id="seguimiento">
        <table border="1px">
            <thead>
                <tr>
                    <th>Dia</th>
                    <th>Hora</th>
                    <th>Accion</th>
                    <th>Emisor</th>
                    <th>Receptor</th>
                    <th>Medio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(s, index) in seguimientos" :key="s.id">
                    <!-- DIA -->
                    <td>
                        <span v-if="!s.editando">{{ mostrarDato(s.dia) }}</span>
                        <input v-else type="date" v-model="s.dia">
                    </td>

                    <!-- HORA -->
                    <td>
                        <span v-if="!s.editando">{{mostrarDato(s.hora)}}</span>
                        <input v-else type="time" v-model="s.hora">
                    </td>

                    <!-- ACCION -->
                    <td>
                        <span v-if="!s.editando">{{mostrarDato(s.accion)}}</span>
                        <input v-else type="text" v-model="s.accion">
                    </td>

                    <!-- EMISOR -->
                    <td>
                        <span v-if="!s.editando">{{ s.emisor }}</span>
                        <select v-else v-model="s.emisor">
                            <option>Alumno</option>
                            <option>Tutor centro</option>
                            <option>Tutor empresa</option>
                        </select>
                    </td>

                    <!-- RECEPTOR -->
                    <td>
                        <span v-if="!s.editando">{{ s.receptor }}</span>
                        <select v-else v-model="s.receptor">
                            <option>Alumno</option>
                            <option>Tutor centro</option>
                            <option>Tutor empresa</option>
                        </select>
                    </td>

                    <!-- MEDIO -->
                    <td>
                        <span v-if="!s.editando">{{ s.medio }}</span>
                        <select v-else v-model="s.medio">
                            <option>EMAIL</option>
                            <option>TELEFONO</option>
                            <option>EN_PERSONA</option>
                            <option>VIDEOLLAMADA</option>
                            <option>OTRO</option>
                        </select>
                    </td>

                    <!-- BOTONES -->
                     <td>
                        <button v-if="!s.editando" @click="editar(s)">Editar</button>
                        <button v-else @click="guardar(s)">Guardar</button>
                        <button @click="eliminar(index)">Eliminar</button>
                     </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>