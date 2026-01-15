<template>
    <form @submit.prevent="$emit('guardar')">
       
        <div>
            <label for="descripcion">Descripción:</label>
            <textarea v-model="competencia.descripcion" required></textarea>
        </div>
        <div>
            <label for="grado">Grado al que pertenece:</label>
            <select v-model="competencia.id_grado" required>
                <option disabled value="">Selecciona un grado</option>
                <option v-for="grado in grados" :key="grado.id_grado" :value="grado.id_grado">
                    {{ grado.nombre }}
                </option>
        </select>        </div>
        <button type="submit">Crear Competencia</button>
    </form>
</template>
<script>
    export default {
        props: ['competencia', 'grados']
    }
</script>